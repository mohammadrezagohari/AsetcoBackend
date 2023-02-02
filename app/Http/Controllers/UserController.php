<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Plank\Mediable\Facades\MediaUploader;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class UserController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = array(
            'name' => 'required',
            'email' => 'required|email',
           'mobile' => 'required|ir_mobile',
            'national_identity' => 'required|ir_national_code',
            'gender' => ['required', Rule::in(Gender::ALL)],
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        try {
            $input = $request->all();
            $passEncrypt = bcrypt($input['password']);
            \DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
               'mobile' => $request->mobile,
                'national_identity' => $request->national_identity,
                'gender' => $request->gender,
                'password' => $passEncrypt
            ]);
            \DB::commit();
            return response()->json([
                'message' => 'تبریک! اطلاعات با موفقیت ثبت گریده است',
            ], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(['error' => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }

    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = array(
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|ir_mobile',
            'national_identity' => 'required|ir_national_code',
            'gender' => ['required', Rule::in(Gender::ALL)],
            'password' => 'nullable|min:6',
            'c_password' => 'nullable|same:password',
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        $user = Auth::user();
        $input = $request->all();
        $passEncrypt=null;
        if (isset($input['password'])) {
            $passEncrypt = bcrypt($input['password']);
        }
        $user->update(
            [
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'national_identity' => $request->national_identity,
                'gender' => $request->gender,
                'password' => $passEncrypt,
            ]
        );

        return response()->json([
            'message' => 'تبریک! اطلاعات با موفقیت بروزرسانی شده است',
        ], HTTPResponse::HTTP_OK);
    }

    public function delete(User $user): \Illuminate\Http\JsonResponse
    {
        try {
            $user->delete();
            return response()->json([
                'message' => 'کاربر با موفقیت حذف گردید',
            ], HTTPResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], HTTPResponse::HTTP_FORBIDDEN);
        }
    }

    public function index()
    {
        try {
            $users = User::all();
            return UserResource::collection($users);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], HTTPResponse::HTTP_FORBIDDEN);
        }
    }

    public function profile()
    {
        try {
            return UserResource::make(Auth::user());
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], HTTPResponse::HTTP_FORBIDDEN);
        }

    }
}
