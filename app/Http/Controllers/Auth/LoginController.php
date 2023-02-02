<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'mobile' => 'required|ir_mobile',
            'password' => 'required|min:8',
            'role_id' => ['required', 'exists:App\Models\Role,id'],
        ]);
        $user = User::where('mobile', $request->mobile)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 400);
        }

        $role = $user->roles()->find($request->role_id);
        if (!$role) {
            return response()->json([
                'message' => 'you don\'t have access to the role.'
            ], 400);
        }

        $user->tokens()->delete();
        $token = $user->createToken($user->mobile, $role->permissions_array)->plainTextToken;
        return response()->json([
            'message' => 'you are successfully logged in.',
            'token' => $token,
            'user' => $user,
        ], 200);

    }

    public function verify(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'message' => 'you ar not logged in'
            ], 403);
        }
        return response()->json([
            'message' => 'you are logged in',
            'user' => $user,
        ], 200);
    }

}
