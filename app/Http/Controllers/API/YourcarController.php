<?php

namespace App\Http\Controllers\API;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\YourcarResource;
use App\Models\User;
use App\Models\Yourcar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class YourcarController extends Controller
{
    /*****************
     * @return \Illuminate\Http\JsonResponse | \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try {
            if (\Auth::user()->checkedHasAnyRole([RoleTypes::SUPER_ADMIN, RoleTypes::ADMIN])->count()) {
                $car = Yourcar::paginate(6);
                return response()->json($car, HTTPResponse::HTTP_OK);
            }
            $user = \Auth::user();
            return YourcarResource::collection(Yourcar::whereUserId($user->id)->get());
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /*****************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = array(
            "color_id" => "required|exists:colors,id",
            "carmodel_id" => "required|exists:carmodels,id",
            "year_id" => "required|exists:years,id",
            "pelak" => "required|unique:yourcars,pelak",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = \Auth::user();
            $user->YourCars()->create([
                'color_id' => $request->color_id,
                'carmodel_id' => $request->carmodel_id,
                'year_id' => $request->year_id,
                'pelak' => $request->pelak,
            ]);

            return response()->json(['message', "Successfully, Your car selected successful."], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /******************
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = array(
            "color_id" => "required|exists:colors,id",
            "carmodel_id" => "required|exists:carmodels,id",
            "year_id" => "required|exists:years,id",
            "pelak" => "required|unique:yourcars,pelak," . $id,
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = \Auth::user();
            $yourCar = Yourcar::findOrFail($id);
            $yourCar->color_id = $request->color_id;
            $yourCar->carmodel_id = $request->carmodel_id;
            $yourCar->year_id = $request->year_id;
            $yourCar->pelak = $request->pelak;
            $yourCar->user_id = $user->id;
            $yourCar->save();
            return response()->json([$yourCar->id, "Successfully, Your car update."], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /****************
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            $yourCar = Yourcar::findOrFail($id);
            $yourCar->delete();
            return response()->json(['Your car delete successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


}
