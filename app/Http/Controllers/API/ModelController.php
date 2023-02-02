<?php

namespace App\Http\Controllers\API;

use App\Enums\DaysOfTheWeek;
use App\Enums\LocationType;
use App\Enums\MechanicTypes;
use App\Enums\RegularExpressionLocation;
use App\Enums\VehicleTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\SelectResource;
use App\Models\Car;
use App\Models\Carmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ModelController extends Controller
{
    /*****************
     * @return \Illuminate\Http\JsonResponse | \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * List of the models
     */
    public function index(Car $car)
    {
        try {
            $models = $car->CarModel;
            return SelectResource::collection($models);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    /*********************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Store in the model of the Carmodel
     */
    public function store(Request $request)
    {
        $rules = array(
            "name" => "required|string|max:250",
            "car_id" => "required|exists:cars,id",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        try {
            $model = Carmodel::create([
                'name' => $request->name,
                'car_id' => $request->car_id
            ]);
            return response()->json([$model->id, 'Model added successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /*****************
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * update the carmodel
     */
    public function update($id, Request $request)
    {
        $rules = array(
            "name" => "required|string|max:250",
            "car_id" => "required|exists:cars,id"
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $model = Carmodel::find($id);
            $model->name = $request->name;
            $model->car_id = $request->car_id;
            $model->save();
            return response()->json([$model->id, 'Model update successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    /***********************
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * delete carmodel in the database
     */
    public function delete($id)
    {
        try {
            $model = Carmodel::findOrFail($id);
            $model->delete();
            return response()->json(['Model delete successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }
}
