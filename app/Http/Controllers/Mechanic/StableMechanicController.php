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

class StableMechanicController extends Controller {
    public function show(User $user, Mechanic $mechanic): \Illuminate\Http\JsonResponse {
        if ($mechanic->type != MechanicTypes::STABLE) {
            return response()->json([
                'message' => 'data not found',
            ], 404);
        }

        return response()->json([
            'mechanic' => $mechanic,
            'message'  => 'data successfully retrieved',
        ], 200);
    }

    public function index(): \Illuminate\Http\JsonResponse {
        $mechanics = Mechanic::where('type', MechanicTypes::STABLE)->paginate(5);

        return response()->json([
            'mechanics' => $mechanics,
            'message'   => 'data successfully retrieved',
        ], 200);
    }

    public function store(Request $request, User $user): \Illuminate\Http\JsonResponse {
        $rules = array(
            'name'            => 'required|max:255',
            'working_day'     => 'required|array|max:7',
            'working_day.*'   => ['required', Rule::in(DaysOfTheWeek::ALL)],
            'working_hour'    => 'required|array|size:2',
            'working_hour.*'  => 'required|date_format:H:i',
            'license'         => 'required|size:10',
            'activated'       => 'nullable|boolean',
            'province_id'     => 'required',
            'city_id'         => 'required',
            'count_available' => 'required',
            'detail_address'  => 'required',
            'phone'           => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        //TODO:activated should be checked!
        $user->mechanic()->create([
            'type'            => MechanicTypes::STABLE,
            'name'            => $request->name,
            'license'         => $request->license,
            'activated'       => $request->activated,
            'phone'           => $request->phone,
            'count_available' => $request->count_available,
        ]);
        $mechanic = $user->mechanic;

        $mechanic->MechanicAddress()->create([
            'province_id'    => $request->province_id,
            'city_id'        => $request->city_id,
            'detail_address' => $request->detail_address,
        ]);

        foreach ($request->working_day as $day) {
            $mechanic->dailyworks()->create([
                'day'  => $day,
                'from' => $request->working_hour[0],
                'to'   => $request->working_hour[1],
            ]);
        }

        return response()->json([
            'message' => 'stable mechanic is successfully stored',
        ], 200);
    }

    public function update(Request $request, User $user, Mechanic $mechanic): \Illuminate\Http\JsonResponse {
        $rules = array(
            'name'            => 'required|max:255',
            'working_day'     => 'required|array|max:7',
            'working_day.*'   => ['required', Rule::in(DaysOfTheWeek::ALL)],
            'type_vehicle'    => 'required|in:car,motorcycle',
            'working_hour'    => 'required|array|size:2',
            'working_hour.*'  => 'required|date_format:H:i',
            'license'         => 'required|size:10',
            'activated'       => 'nullable|boolean',
            'province_id'     => 'required',
            'city_id'         => 'required',
            'count_available' => 'required',
            'detail_address'  => 'required',
            'phone'           => 'required',
            'pelak'           => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        try {
            $mechanic->update([
                'type'            => $request->type,
                'name'            => $request->name,
                'phone'           => $request->phone,
                'license'         => $request->license,
                'activated'       => $request->activated,
                'type_vehicle'    => VehicleTypes::CAR,
                'pelak'           => $request->pelak,
                'count_available' => $request->count_available,
                'user_id'         => $user->id,
            ]);
            $mechanic->MechanicAddress()->updateOrCreate([
                'province_id'    => $request->province_id,
                'city_id'        => $request->city_id,
                'detail_address' => $request->detail_address,
            ]);

            $mechanic->dailyworks()->delete();

            foreach ($request->working_day as $day) {
                $mechanic->dailyworks()->create([
                    'day'  => $day,
                    'from' => $request->working_hour[0],
                    'to'   => $request->working_hour[1],
                ]);
            }

            return response()->json([
                'message' => 'stable mechanic is successfully updated',
            ], 200);
        } catch (\Exception $ex) {
//            dd($ex->getMessage());

            return response()->json([
                'error' => $ex->getMessage(),
            ], 401);
        }

    }

    public function delete(User $user, Mechanic $mechanic): \Illuminate\Http\JsonResponse {
        try {
            $mechanic->dailyworks()->delete();
            $mechanic->delete();

            return response()->json([
                'message' => 'stable mechanic is successfully deleted.',
            ], 200);
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }
}
