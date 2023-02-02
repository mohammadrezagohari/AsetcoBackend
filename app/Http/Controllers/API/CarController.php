<?php

namespace App\Http\Controllers\API;

use App\Enums\RegularExpressionLocation;
use App\Http\Controllers\Controller;
use App\Http\Resources\SelectResource;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class CarController extends Controller
{
    public function index()
    {
        try {
            $models = Car::all()->take(100);
            return SelectResource::collection($models);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {
        $rules = array(
            "brand" => "required|unique:cars,brand",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $car = Car::create(['brand' => $request->brand]);
            return response()->json(['message' => 'Car update successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, Request $request)
    {
        $rules = array(
            "brand" => "required|unique:cars,brand," . $id,
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $car = Car::find($id);
            $car->brand = $request->brand;
            $car->save();
            return response()->json(['message' => 'Car update successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function delete($id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->delete();
            return response()->json(['message' => 'Car delete successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    public function list(Request $request)
    {
        $rules = array(
            "user" => "required|exists:users,id",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            if (@$request->user || $request->user == null)
                return response()->json(["error" => "your car not found."], HTTPResponse::HTTP_BAD_REQUEST);

            $user_id = $request->user;  //// user here define user id
            $user = User::findOrFail($user_id);
            $cars = $user->Cars()->get();
            return response()->json($cars, HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_FORBIDDEN);
        }
    }


}
