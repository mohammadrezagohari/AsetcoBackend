<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SelectResource;
use App\Http\Resources\ServicesResource;
use App\Models\Basket;
use App\Models\Service;
use App\Models\Servicecategory;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ServiceController extends Controller
{

    public function store(Request $request)
    {
        $rules = array(
            "subject" => "required|string|max:255",
            "description" => "required",
            "price" => "required",
            "carmodel_id" => "required|exists:carmodels,id",
            "servicecategory_id" => "required|exists:servicecategories,id",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        try {
            $data = $request->all();
            $service = Service::create($data);
            return response()->json([$service->id, 'Service add successfully.'], 200);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }


    public function index()
    {
        try {
            $models = Service::all()->take(100);
            return SelectResource::collection($models);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, Request $request)
    {
        $rules = array(
            "subject" => "required|string|max:255",
            "description" => "required",
            "price" => "required",
            "carmodel_id" => "required|exists:carmodels,id",
            "servicecategory_id" => "required|exists:servicecategories,id",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $service = Service::findOrFail($id);
            $service->subject = $request->subject;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->carmodel_id = $request->carmodel_id;
            $service->servicecategory_id = $request->servicecategory_id;
            $service->save();
            return response()->json([$service->id, 'Service update successfully.'], 200);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }

    public function delete($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->Mechanics()->detach();
//            $service->forceDelete();
            $service->delete();
            return response()->json(['Service delete successfully.'], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_FORBIDDEN);
        }
    }


    //////// چک کن که خودروی من این سرویس رو داره؟!
    public function check_your_car_has_service($carmodel_id)
    {
        try {
            $user = Auth::user();
            $carmodels = $user->YourCars()->where('carmodel_id', '=', $carmodel_id)->pluck('carmodel_id')->toArray();
            $service = Service::whereIn('carmodel_id', $carmodels)->get();
            return response()->json($service, 200);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], 401);
        }

    }

    public function getByCategory(Servicecategory $servicecategory, Basket $basket): AnonymousResourceCollection
    {
        return SelectResource::collection($servicecategory->Services->whereIn('carmodel_id', $basket->carmodel_id));
    }

    /*****************
     * @return \Illuminate\Http\JsonResponse
     * list of services
     */
    public function list_services()
    {
        try {
            return ServicesResource::collection(Auth::user()->mechanic->Services);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }

}
