<?php

namespace App\Http\Controllers\API;

use App\Enums\RegularExpressionLocation;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Mechanic;
use App\Models\Service;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ServiceMechanicController extends Controller
{
    /*****************
     * @param Request $request
     *
     * @return JsonResponse
     *
     */
    public function mechanic_list_near(Request $request): JsonResponse
    {
        ////TODO: We must log data in the log file
        $rules = array(
            "latitude" => ['required', 'regex:' . RegularExpressionLocation::LATITUDE],
            "longitude" => ['required', 'regex:' . RegularExpressionLocation::LONGITUDE],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $addresses = Location::findNearMechanic($latitude, $longitude)->get();
            return response()->json($addresses, HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 301);
        }
    }

    //// لیست سرویس های که در مجموع ارائه می شه
    public function service_list(Request $request)
    {
        try {
            $result = null;
            $service = $request->service;
            $car = $request->car;
            if ($service == null && $car == null)
                $result = Service::giveLastItems()->get();
            if ($service == null && $car != null)
                $result = Service::giveLastItemsWithCar($car)->get();
            if ($service != null && $car == null)
                $result = Service::giveLastItemsWithService($service)->get();

            return response()->json([$result, 'Send list successfully.'], 200);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 301);
        }
    }

    //TODO:Check ALL Validation ....
    //// لیست سرویس هایی که برای یک مکانیکی خاص ارائه می شه
    public function service_list_for_mechanic(Request $request)
    {
        try {
            $mechanic = $request->mechanic;
            $phone = $request->phone;
            $type = $request->type;
            $type_vehicle = $request->type_vehicle;
            if ($mechanic == null && $phone == null && $type == null && $type_vehicle == null)
                return response()->json(['error' => 'you must enter value'], 301);
            $current_mechanic = null;
            if ($mechanic != null)
                $current_mechanic = Mechanic::findByName($mechanic)->get();

            if ($phone != null)
                $current_mechanic = Mechanic::findByPhone($phone)->get();

            if ($type != null)
                $current_mechanic = Mechanic::findBytype($type)->get();

            if ($type_vehicle != null)
                $current_mechanic = Mechanic::findByTypeVehicle($type_vehicle)->get();

            return response()->json([$current_mechanic, 'Send list successfully.'], 200);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 301);
        }
    }

    //// لیست مکانیکی هایی که یک سرویس خاصی رو ارائه می شه
    public function list_mechanic_for_service(Request $request)
    {
        ////TODO: We must log data in the log file
        $rules = array(
            "service" => "required",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        try {
            $service = $request->service;
            if ($service == null)
                return response()->json(['error' => 'you must enter value'], 301);

            $mechanics = null;
            if ($service != null) {
                if (Service::findByName($service)->count() != 0)
                    $mechanics = Service::findByName($service)->Mechanics()->take(5)->get();
            }

            return response()->json([$mechanics, 'Send list successfully.'], 200);

        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 301);
        }
    }

    //// ارائه سرویس توسط مکانیک یا ادمین اساین میشه
    public function assign_mechanic_serve_service(Request $request)
    {
        $rules = array(
            "services" => "required",
            "mechanic" => "required|exists:mechanics,id",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $services = $request->services;
            $mechanic = Mechanic::findOrFail($request->mechanic);
            if ($services == null || $mechanic == null)
                return response()->json(['error' => 'you must enter value'], 301);
            $mechanic->Services()->sync([]);
            foreach ($services as $key => $service) {
                $mechanic->Services()->attach($key, $service);
            }

            return response()->json([$mechanic, 'Send list successfully.'], 200);

        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 301);
        }


    }


}
