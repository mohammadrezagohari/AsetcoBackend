<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SelectResource;
use App\Http\Resources\ServiceResource;
use App\Models\Car;
use App\Models\Service;
use App\Models\Servicecategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ServicecategoyController extends Controller
{
    public function store(Request $request)
    {
        $rules = array(
            "category" => "required|string|unique:servicecategories,category",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $service = Service::create($request->category);
            if ($service)
                return response()->json([$service->id, 'اطلاعات با موفقیت ثبت شده است.'], HTTPResponse::HTTP_OK);
            else
                return response()->json(['error' => 'در هنگام ثبت اطلاعات، خطا رخ داده است.'], HTTPResponse::HTTP_CONTINUE);

        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /**********************
     * @param Request $request
     * @return JsonResponse
     * connect cars to servicecategories
     */
    public function assign_car_to_category(Request $request): JsonResponse
    {
        $rules = array(
            "categories.*" => "required|exists:categories,id",
            "cars.*" => "required|unique:servicecategories,category",        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $categories = Servicecategory::whereIn('id', json_decode($request->categories))->pluck('id')->toArray();
            $cars = Car::whereIn('id', json_decode($request->cars))->get();
            foreach ($cars as $car) {
                $car->Servicecategories()->sync($categories);
            }
            return response()->json(['success' => 'اطلاعات با موفقیت ثبت شده است.'], HTTPResponse::HTTP_OK);

        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function ServiceFilterByCategory(Request $request)
    {

        $rules = array(
            "category" => "required|exists:servicecategories,id",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $currentCategory = Servicecategory::findOrFail($request->category)->Services;
            return response()->json(ServiceResource::collection($currentCategory), HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function index()
    {
        try {
            $models = Servicecategory::all()->take(100);
            return SelectResource::collection($models);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

}
