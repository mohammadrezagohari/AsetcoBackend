<?php

namespace App\Http\Controllers;

use App\Enums\MediaTypes;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class RoleController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = array(
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permission_ids' => ['required', 'array', 'max:7'],
            'permission_ids.*' => ['required', 'exists:App\Models\Permission,id'],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        $role = Role::create([
            'name' => $request->name
        ]);
        $role->permissions()->attach($request->permission_ids);
        return response()->json([
            'role' => $role,
            'message' => 'role successfully stored.',
        ], 200);
    }

    public function update(Request $request, Role $role): \Illuminate\Http\JsonResponse
    {
        $rules = array(
            'name' => ['required', 'string', 'max:255'],
            'permission_ids' => ['required', 'array', 'max:7'],
            'permission_ids.*' => ['required', 'exists:App\Models\Permission,id'],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }


        $role->update([
            'name' => $request->name
        ]);

        $role->permissions()->sync($request->permission_ids);

        return response()->json([
            'role' => $role,
            'message' => 'role successfully updated.',
        ], 200);
    }

    public function delete(Role $role): \Illuminate\Http\JsonResponse
    {
        $role->delete();

        return response()->json([
            'message' => 'role successfully deleted.',
        ], 201);
    }

    public function show(Role $role): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'role' => $role,
            'message' => 'data successfully retrieved.',
        ], 200);
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $roles = Role::all();
        return response()->json([
            'roles' => $roles,
            'message' => 'data successfully retrieved.',
        ], 200);
    }

    public function assign(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = array(
            'user_id' => ['required', 'exists:App\Models\User,id'],
            'role_ids' => ['required', 'array', 'max:7'],
            'role_ids.*' => ['required', 'exists:App\Models\Role,id'],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        $user = User::find($request->user_id);

        $user->roles()->sync($request->role_ids);
        return response()->json([
            'message' => 'roles are successfully assigned.',
        ], 200);

    }
}
