<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Enums\RoleTypes;
use App\Jobs\VerificationCodeSMS;
use App\Models\Role;
use App\Models\User;
use App\Models\VerificationCode;
use App\Notifications\VerificationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class VerificationCodeController extends Controller
{
    public function send(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = array(
            'role' => ['required', Rule::in([RoleTypes::MECHANIC, RoleTypes::USER])],
            'mobile' => 'required|ir_mobile',
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = User::firstWhere('mobile', $request->mobile);
            if (!$user) {
                $user = User::create([
                    'mobile' => $request->mobile
                ]);
            }
            $user->roles()->sync([Role::firstWhere('name', $request->role)->id]);
            VerificationCodeSMS::dispatch($user);
//        TODO: uncomment for production.
//        $user->notify(new VerificationNotification());
            return response()->json([
                'message' => 'the message is successfully sent.',
            ], HTTPResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function verify(Request $request)
    {
        $rules = array(
            'code' => 'required',
            'role' => ['required', Rule::in([RoleTypes::MECHANIC, RoleTypes::USER])],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $verificationCode = VerificationCode::firstWhere('code', $request->code);
            if (!@$verificationCode || $verificationCode->used || $verificationCode->expires_at < now())
                return response()->json([
                    'message' => 'verification code is not valid.',
                ], HTTPResponse::HTTP_BAD_REQUEST);

            $verificationCode->used = true;
            $verificationCode->save();
            $user = $verificationCode->user;
            $role = $user->roles()->firstWhere('name', $request->role);
            if (!$role) {
                return response()->json([
                    'message' => "you don't have access to the role."
                ], HTTPResponse::HTTP_BAD_REQUEST);
            }
            $user->tokens()->delete();
            $token = $user->createToken($user->mobile, $role->permissions_array)->plainTextToken;
            return response()->json([
                'message' => 'the message is successfully sent.',
                'token' => $token,
                'user' => $user,
            ], HTTPResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }
}
