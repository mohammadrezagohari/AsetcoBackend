<?php

namespace App\Http\Controllers\Mechanic;

use App\Enums\DaysOfTheWeek;
use App\Enums\MechanicTypes;
use App\Enums\VehicleTypes;
use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class MobileMechanicController extends Controller
{
    public function store(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $rules = array(
            'type_vehicle' => ['required', Rule::in(VehicleTypes::ALL)],
            'pelak' => 'required|string'
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        $input = $request->all();

        $input['type'] = MechanicTypes::MOBILE;

        $user->mechanic()->create($input);

        return response()->json([
            'message' => 'mobile mechanic is successfully stored',
        ], 201);
    }

    public function update(Request $request, User $user, Mechanic $mechanic): \Illuminate\Http\JsonResponse
    {
        $rules = array(
            'type_vehicle' => ['required', Rule::in(VehicleTypes::ALL)],
            'pelak' => 'required|string'
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        $mechanic->update($request->all());

        return response()->json([
            'message' => 'mobile mechanic is successfully updated',
        ], 200);
    }

    public function delete(Request $request, User $user, Mechanic $mechanic): \Illuminate\Http\JsonResponse
    {
        $mechanic->delete();

        return response()->json([
            'message' => 'mobile mechanic is successfully deleted',
        ], 200);

    }

    public function show(Request $request, User $user, Mechanic $mechanic): \Illuminate\Http\JsonResponse
    {

        return response()->json([
            'mechanic' => $mechanic,
            'message' => 'mobile mechanic is successfully deleted',
        ], 200);

    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $mechanics = Mechanic::where('type', MechanicTypes::MOBILE)->paginate(10);

        return response()->json([
            'mechanics' => $mechanics,
            'message' => 'mobile mechanic is successfully deleted',
        ], 200);

    }
}
