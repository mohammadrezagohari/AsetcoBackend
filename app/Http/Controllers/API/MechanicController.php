<?php

namespace App\Http\Controllers\API;

use App\Enums\BasketStatusOrder;
use App\Enums\DaysOfTheWeek;
use App\Enums\Gender;
use App\Enums\LocationType;
use App\Enums\MechanicTypes;
use App\Enums\RegularExpressionLocation;
use App\Enums\RoleTypes;
use App\Enums\StepRequest;
use App\Enums\VehicleTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\BasketResource;
use App\Http\Resources\LastRequestMechanicResource;
use App\Http\Resources\MechanicOutResource;
use App\Http\Resources\MechanicResource;
use App\Models\Basket;
use App\Models\Location;
use App\Models\Mechanic;
use App\Models\Mechanicaddress;
use App\Models\Mechanicrequest;
use App\Models\Service;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class MechanicController extends Controller
{
    //// لیست مکانیک
    public function index()
    {
        return response()->json(Mechanic::with(['locations'])->paginate(5));
    }

    /// اضافه کردن مکانیک
    public function store(Request $request): JsonResponse
    {
        $rules = array(
            'type_vehicle' => ['required', Rule::in(VehicleTypes::ALL)],
            'supported_brands' => 'required|exists:cars,id',
            'supported_services' => 'required|exists:services,id',
            'pelak' => 'nullable|string',
            'name' => 'required|max:255',
            'full_name' => 'nullable|max:255',
            'working_day' => 'required',
            'working_day.*' => ['required', Rule::in(DaysOfTheWeek::ALL)],
            'working_hour' => 'required',
            'working_hour.*' => 'required|date_format:H:i',
            'license' => 'required|size:10',
            'activated' => 'nullable|boolean',
            'parts_supplier' => 'nullable|boolean',
            'user_id' => 'nullable|exists:users,id|unique:mechanics,user_id',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:provinces,id',
            'count_available' => 'required|numeric',
            'support_space' => 'required|numeric',
            'phone' => 'required',
            'type' => ['required', Rule::in(MechanicTypes::ALL)],
            'lat' => ['required', "regex:" . RegularExpressionLocation::LATITUDE],
            'lon' => ['required', "regex:" . RegularExpressionLocation::LONGITUDE],
            'location_type' => ['required', Rule::in(LocationType::ALL)],
            'detail_address' => ['nullable', 'string', 'max:255'],
            'street' => 'nullable|string|max:255',
            'alley' => 'nullable|string|max:255',
            'flat' => 'nullable|string|max:255',
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            DB::beginTransaction();
            $activated = null;
            $user = null;
            if (@Auth::user()->checkedHasAnyRole([RoleTypes::ADMIN, RoleTypes::SUPER_ADMIN])->count()) {
                $activated = $request->activated == null ? false : $request->activated;
                $user = User::findOrFail($request->user_id);
            } else {
                $user = Auth::user()->id;
                $activated = false;
            }

            $mechanic = $user->mechanic()->create([
                'type_vehicle' => $request->type_vehicle,
                'pelak' => $request->pelak,
                'name' => $request->name,
                'full_name' => $request->full_name,
                'parts_supplier' => $request->parts_supplier,
                'license' => $request->license,
                'activated' => $activated,
                'type' => $request->type,
                'phone' => $request->phone,
                'count_available' => $request->count_available,
            ]);

            Mechanicaddress::create([
                'street' => $request->street,
                'alley' => $request->alley,
                'flat' => $request->flat,
                'detail_address' => $request->detail_address,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'mechanic_id' => $user->mechanic->id,
            ]);

            Location::create([
                'lat' => $request->lat,
                'lon' => $request->lon,
                'type' => $request->location_type,
                'support_space' => $request->support_space,
                'mechanic_id' => $user->mechanic->id,
            ]);

            $days = json_decode($request->working_day);
            $hours = json_decode($request->working_hour);
            foreach ($days as $day) {
                $mechanic->dailyworks()->create([
                    'day' => $day,
                    'from' => $hours[0],
                    'to' => $hours[1],
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => "congratulation, your transaction is successfully",
            ], HTTPResponse::HTTP_FORBIDDEN);

            DB::rollBack();
            return response()->json([
                'fails' => "Sorry, you can't access this page.",
            ], HTTPResponse::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'Errormessage' => $exception->getMessage(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

    }

    /// بروزرسانی اطلاعات مکانیکی
    public function updateBothService(Request $request)
    {
        $rules = array(
            'name' => 'required|max:255',
            'mobile' => 'required|ir_mobile',
            'national_identity' => 'required|ir_national_code',
            'gender' => ['required', Rule::in(Gender::ALL)],
            'type_vehicle' => ['required', Rule::in(VehicleTypes::ALL)],
            'supported_brands' => 'required|exists:cars,id',
            'supported_services' => 'required|exists:services,id',
            'pelak' => 'nullable|string',
            'full_name' => 'nullable|max:255',
            'working_day' => 'required',
            'working_day.*' => ['required', Rule::in(DaysOfTheWeek::ALL)],
            'working_hour' => 'required',
            'working_hour.*' => 'required|date_format:H:i',
            'license' => 'required|size:10',
            'activated' => 'nullable|boolean',
            'parts_supplier' => 'required|boolean',
            'user_id' => 'nullable|exists:users,id|unique:mechanics,user_id',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'count_available' => 'nullable|numeric',
            'support_space' => 'nullable|numeric',
            'phone' => 'required',
            'type' => ['required', Rule::in(MechanicTypes::ALL)],
            'lat' => ['required', "regex:" . RegularExpressionLocation::LATITUDE],
            'lon' => ['required', "regex:" . RegularExpressionLocation::LONGITUDE],
            'detail_address' => ['nullable', 'string', 'max:255'],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        $user = Auth::user();
        DB::beginTransaction();
        try {

//            $activated = null;
//            $user = null;
//            if (Auth::user()->checkedHasAnyRole([RoleTypes::ADMIN, RoleTypes::SUPER_ADMIN])) {
//                $activated = $request->activated == null ? false : $request->activated;
//                $user = User::findOrFail($request->user_id);
//            } else {
//                $user = Auth::user()->id;
//                $activated = false;
//            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'national_identity' => $request->national_identity,
                'gender' => $request->gender,
            ]);
            $mechanic = $user->mechanic;
            if ($mechanic) {
                $mechanic->update([
                    'type_vehicle' => $request->type_vehicle,
                    'pelak' => $request->pelak,
                    'name' => $request->name,
                    'full_name' => $request->full_name,
                    'parts_supplier' => $request->parts_supplier,
                    'license' => $request->license,
                    'type' => $request->type,
                    'phone' => $request->phone,
                ]);

            } else {
                $mechanic = $user->mechanic()->create([
                    'type_vehicle' => $request->type_vehicle,
                    'pelak' => $request->pelak,
                    'name' => $request->name,
                    'full_name' => $request->full_name,
                    'parts_supplier' => $request->parts_supplier,
                    'license' => $request->license,
                    'type' => $request->type,
                    'phone' => $request->phone,
                ]);
            }
            if ($mechanic->mechanicaddress) {

                $mechanic->mechanicaddress()->update([
                    'detail_address' => $request->detail_address,
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                ]);

            } else {
                $mechanic->mechanicaddress()->create([
                    'detail_address' => $request->detail_address,
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                ]);

            }

            // TODO: support space needs to be added from request
            $location = $mechanic->Locations()->firstWhere('type', LocationType::STABLE);
            if (isset($location)) {
                $location->update([
                    'lat' => $request->lat,
                    'lon' => $request->lon,
                    'support_space' => 50,
                ]);

            } else {

                $mechanic->Locations()->create([
                    'lat' => $request->lat,
                    'lon' => $request->lon,
                    'type' => LocationType::STABLE,
                    'support_space' => 50,
                ]);

            }
            $mechanic->Services()->sync($request->supported_services);
            $mechanic->supportedBrands()->sync($request->supported_brands);
            //update daily works
            $mechanic->dailyworks()->delete();
            foreach ($request->working_day as $day) {
                $mechanic->dailyworks()->create([
                    'day' => $day,
                    'from' => $request->working_hour[0],
                    'to' => $request->working_hour[1],
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => "congratulation, successfully stored",
            ], HTTPResponse::HTTP_ACCEPTED);

        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'Errormessage' => $exception->getMessage(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function updateStableService(Request $request)
    {
        $rules = array(
            'name' => 'required|max:255',
            'mobile' => 'required|ir_mobile',
            'national_identity' => 'required|ir_national_code',
            'gender' => ['required', Rule::in(Gender::ALL)],
            'supported_brands' => 'required|exists:cars,id',
            'supported_services' => 'required|exists:services,id',
            'full_name' => 'nullable|max:255',
            'working_day' => 'required',
            'working_day.*' => ['required', Rule::in(DaysOfTheWeek::ALL)],
            'working_hour' => 'required',
            'working_hour.*' => 'required|date_format:H:i',
            'license' => 'required|size:10',
            'activated' => 'nullable|boolean',
            'parts_supplier' => 'required|boolean',
            'user_id' => 'nullable|exists:users,id|unique:mechanics,user_id',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'count_available' => 'nullable|numeric',
            'support_space' => 'nullable|numeric',
            'phone' => 'required',
            'type' => ['required', Rule::in(MechanicTypes::ALL)],
            'lat' => ['required', "regex:" . RegularExpressionLocation::LATITUDE],
            'lon' => ['required', "regex:" . RegularExpressionLocation::LONGITUDE],
            'detail_address' => ['nullable', 'string', 'max:255'],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        $user = Auth::user();
        DB::beginTransaction();
        try {

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'national_identity' => $request->national_identity,
                'gender' => $request->gender,
            ]);
            $mechanic = $user->mechanic;
            if ($mechanic) {
                $mechanic->update([
                    'type_vehicle' => $request->type_vehicle,
                    'pelak' => $request->pelak,
                    'name' => $request->name,
                    'full_name' => $request->full_name,
                    'parts_supplier' => $request->parts_supplier,
                    'license' => $request->license,
                    'type' => $request->type,
                    'phone' => $request->phone,
                ]);

            } else {
                $mechanic = $user->mechanic()->create([
                    'type_vehicle' => $request->type_vehicle,
                    'pelak' => $request->pelak,
                    'name' => $request->name,
                    'full_name' => $request->full_name,
                    'parts_supplier' => $request->parts_supplier,
                    'license' => $request->license,
                    'type' => $request->type,
                    'phone' => $request->phone,
                ]);
            }
            if ($mechanic->mechanicaddress) {

                $mechanic->mechanicaddress()->update([
                    'detail_address' => $request->detail_address,
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                ]);

            } else {
                $mechanic->mechanicaddress()->create([
                    'detail_address' => $request->detail_address,
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                ]);

            }

            // TODO: support space needs to be added from request
            $location = $user->mechanic->Locations()->firstWhere('type', LocationType::STABLE);
            if (isset($location)) {
                $location->update([
                    'lat' => $request->lat,
                    'lon' => $request->lon,
                    'support_space' => 50,
                ]);
            } else {
                $user->mechanic->Locations()->create([
                    'lat' => $request->lat,
                    'lon' => $request->lon,
                    'type' => LocationType::STABLE,
                    'support_space' => 50,
                ]);
            }
            $mechanic->Services()->sync($request->supported_services);
            $mechanic->supportedBrands()->sync($request->supported_brands);
            //update daily works
            $user->mechanic->dailyworks()->delete();
            foreach ($request->working_day as $day) {
                $user->mechanic->dailyworks()->create([
                    'day' => $day,
                    'from' => $request->working_hour[0],
                    'to' => $request->working_hour[1],
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => "congratulation, successfully stored",
            ], HTTPResponse::HTTP_ACCEPTED);

        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'Errormessage' => $exception->getMessage(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function updateMobileService(User $user, Request $request)
    {
        $rules = array(
            'name' => 'required|max:255',
            'mobile' => 'required|ir_mobile',
            'national_identity' => 'required|ir_national_code',
            'gender' => ['required', Rule::in(Gender::ALL)],
            'supported_brands' => 'required|exists:cars,id',
            'supported_services' => 'required|exists:services,id',
            'full_name' => 'nullable|max:255',
            'working_day' => 'required',
            'working_day.*' => ['required', Rule::in(DaysOfTheWeek::ALL)],
            'working_hour' => 'required',
            'working_hour.*' => 'required|date_format:H:i',
            'license' => 'required|size:10',
            'activated' => 'nullable|boolean',
            'parts_supplier' => 'required|boolean',
            'user_id' => 'nullable|exists:users,id|unique:mechanics,user_id',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'count_available' => 'nullable|numeric',
            'support_space' => 'nullable|numeric',
            'phone' => 'required',
            'type' => ['required', Rule::in(MechanicTypes::ALL)],
            'lat' => ['required', "regex:" . RegularExpressionLocation::LATITUDE],
            'lon' => ['required', "regex:" . RegularExpressionLocation::LONGITUDE],
            'detail_address' => ['nullable', 'string', 'max:255'],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();
        try {

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'national_identity' => $request->national_identity,
                'gender' => $request->gender,
            ]);
            $mechanic = $user->mechanic;
            if ($mechanic) {
                $mechanic->update([
                    'type_vehicle' => $request->type_vehicle,
                    'pelak' => $request->pelak,
                    'name' => $request->name,
                    'full_name' => $request->full_name,
                    'parts_supplier' => $request->parts_supplier,
                    'license' => $request->license,
                    'type' => $request->type,
                    'phone' => $request->phone,
                ]);

            } else {
                $mechanic = $user->mechanic()->create([
                    'type_vehicle' => $request->type_vehicle,
                    'pelak' => $request->pelak,
                    'name' => $request->name,
                    'full_name' => $request->full_name,
                    'parts_supplier' => $request->parts_supplier,
                    'license' => $request->license,
                    'type' => $request->type,
                    'phone' => $request->phone,
                ]);
            }
            if ($mechanic->mechanicaddress) {

                $mechanic->mechanicaddress()->update([
                    'detail_address' => $request->detail_address,
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                ]);

            } else {
                $mechanic->mechanicaddress()->create([
                    'detail_address' => $request->detail_address,
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                ]);

            }

            // TODO: support space needs to be added from request
            $location = $user->mechanic->Locations()->firstWhere('type', LocationType::STABLE);
            if (isset($location)) {
                $location->update([
                    'lat' => $request->lat,
                    'lon' => $request->lon,
                    'support_space' => 50,
                ]);

            } else {

                $user->mechanic->Locations()->create([
                    'lat' => $request->lat,
                    'lon' => $request->lon,
                    'type' => LocationType::STABLE,
                    'support_space' => 50,
                ]);

            }
            $mechanic->Services()->sync($request->supported_services);
            $mechanic->supportedBrands()->sync($request->supported_brands);
            //update daily works
            $user->mechanic->dailyworks()->delete();
            foreach ($request->working_day as $day) {
                $user->mechanic->dailyworks()->create([
                    'day' => $day,
                    'from' => $request->working_hour[0],
                    'to' => $request->working_hour[1],
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => "congratulation, successfully stored",
            ], HTTPResponse::HTTP_ACCEPTED);

        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'Errormessage' => $exception->getMessage(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    //// حذف مکانیکی
    public function delete($id)
    {
        try {
            if (Auth::user()->checkedHasAnyRole([RoleTypes::ADMIN])->count()) {
                $mechanic = Mechanic::findOrFail($id);
                $mechanic->delete();
                return response()->json([
                    'message' => "your mechanic is delete",
                ], HTTPResponse::HTTP_BAD_REQUEST);
            }
            if (Auth::user()->checkedHasAnyRole([RoleTypes::SUPER_ADMIN])->count()) {
                $mechanic = Mechanic::findOrFail($id);
                $mechanic->forceDelete();
                return response()->json([
                    'message' => "your mechanic is delete",
                ], HTTPResponse::HTTP_BAD_REQUEST);
            }


            return response()->json([
                'message' => "Sorry, you can't access this page.",
            ], HTTPResponse::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return response()->json([
                'Errormessage' => $exception->getMessage(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

    }

    /// پیدا کردن مکانیکی نزدیک
    public function findNearLocation(Request $request)
    {
        $rules = array(
            'lat' => ['required', "regex:" . RegularExpressionLocation::LATITUDE],
            'lon' => ['required', "regex:" . RegularExpressionLocation::LONGITUDE],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $locations = Location::findNearMechanic($request->lat, $request->lon)->pluck('mechanic_id');
            $mechanics = Mechanic::with(['locations', 'mechanicaddress'])->whereIn('id', $locations)->get();
            return response()->json([
                $mechanics,
            ], HTTPResponse::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json([
                'Errormessage' => $exception->getMessage(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }


    }

    /// بروز رسانی لوکشین جدید
    public function update_location($id, Request $request)
    {
        ///TODO: Exception" just location use location id but every others using mechanic_id
        $rules = array(
            'lat' => ['required', "regex:" . RegularExpressionLocation::LATITUDE],
            'lon' => ['required', "regex:" . RegularExpressionLocation::LONGITUDE],
            'location_type' => ['required', Rule::in(LocationType::ALL)],
            'support_space' => ['required', 'max:200', 'numeric'],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $location = null;
            if (@Location::find($id))
                $location = Location::findOrFail($id);
            else
                $location = new Location;

            $location->lat = $request->lat;
            $location->lon = $request->lon;
            $location->type = $request->location_type;
            $location->support_space = $request->support_space;
            $location->save();
            return response()->json([
                'message' => 'your location is updated...'
            ], HTTPResponse::HTTP_OK);

        } catch (Exception $exception) {
            return response()->json([
                'Errormessage' => $exception->getMessage(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /// بروزرسانی آدرس
    public function udpate_address_mechanic($id, Request $request)
    {
        $rules = array(
            'detail_address' => ['nullable', 'string', 'max:255'],
            'street' => 'nullable|string|max:255',
            'alley' => 'nullable|string|max:255',
            'flat' => 'nullable|string|max:255',
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $mechanic = Mechanic::findOrFail($id);
            $address = null;
            if (@Mechanicaddress::whereMechanicId($mechanic->id)->first())
                $address = Mechanicaddress::whereMechanicId($mechanic->id)->firstOrFail();
            else
                $address = new Mechanicaddress;

            $address->detail_address = $request->detail_address;
            $address->street = $request->street;
            $address->alley = $request->alley;
            $address->flat = $request->flat;
            $address->save();

            return response()->json([
                'message' => 'your address is updated...'
            ], HTTPResponse::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json([
                'Errormessage' => $exception->getMessage(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }


    }

    public function show(): MechanicResource
    {
        return new MechanicResource(Auth::user());
    }


    public function select_mechanic($id, Request $request)
    {
        $rules = array(
            "services" => ["required"],
            "services.*" => ["required", "exists:services,id"],
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
            if (is_string($request->services))
                $services = json_decode($request->services);
            else
                $services = $request->services;

            $basket = Basket::findOrFail($id);
            if (!@Service::whereCarmodelId($basket->carmodel_id)->whereIn('id', $services)->count())
                return response()->json(["warning" => 'خودورهای انتخابی شما چنین سرویس را پشتیبانی نمی کند'], HTTPResponse::HTTP_LOCKED);
            $request['mechanic_type'] = $basket->mechanic_type;
            $loc = $request->only(['latitude', 'longitude', 'mechanic_type']);
            $currentServices = Service::whereCarmodelId($basket->carmodel_id)->whereIn('id', $services)->pluck('id');

            $type = [$basket->mechanic_type, MechanicTypes::BOTH];
            $mechanics = Mechanic::whereActivated(true)
            ->WhereHas('services', function ($q) use ($currentServices) {
                $q->whereIn('service_id', $currentServices);
            })->whereHas('locations', function ($q) use ($loc) {
                $q->whereType($loc["mechanic_type"])->selectRaw("mechanic_id, lat, lon,support_space, SQRT(POW(69.1 * (lat - '" . $loc["latitude"] .
                    "'), 2) + POW(69.1 * ('" . $loc["longitude"] . "' - lon) * COS(lat / 57.3), 2)) AS distance ")
                    ->havingRaw("distance < 10000000000")->orderBy('distance');
            })->get();
            MechanicOutResource::$currentService = $currentServices;
            return MechanicOutResource::collection($mechanics);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    public function serve_mechanic_for_problem($id, Request $request)
    {

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
            $request['mechanic_type'] = MechanicTypes::STABLE;
            $loc = $request->only(['latitude', 'longitude', 'mechanic_type']);
            $mechanics = Mechanic::whereActivated(true)
                ->whereHas('locations', function ($q) use ($loc) {
                    $q->whereType($loc["mechanic_type"])->selectRaw("mechanic_id, lat, lon,support_space, SQRT(POW(69.1 * (lat - '" . $loc["latitude"] .
                        "'), 2) + POW(69.1 * ('" . $loc["longitude"] . "' - lon) * COS(lat / 57.3), 2)) AS distance ")
                        ->havingRaw('distance < 200000')->orderBy('distance');
                })->get();
            return MechanicOutResource::collection($mechanics);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public static function get_last_request_mechanic()
    {
        try {
            $user = Auth::user();
            $baskets = $user->mechanic->Baskets()->wherePivot('status', '=', BasketStatusOrder::SUSPENDED)->get();
            return LastRequestMechanicResource::collection($baskets);
        } catch (Exception $exception) {
            return response()->json(["error" => $exception->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function get_my_request_mechanic()
    {
        try {
            $user = Auth::user();
            $baskets = $user->mechanic->Baskets()->wherePivot('status', '<>', BasketStatusOrder::SUSPENDED)->get();
            return LastRequestMechanicResource::collection($baskets);
        } catch (Exception $exception) {
            return response()->json(["error" => $exception->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    public function update_service_price(Request $request)
    {
        $rules = array(
            "services" => ["required"],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = Auth::user();
            $serviceCollection = [];
            if (@is_string($request->services))
                $serviceCollection = json_decode($request->services);
            else
                $serviceCollection = $request->services;


            foreach ($serviceCollection as $service) {
                $user->mechanic->Services()
                    ->wherePivot('service_id', '=', $service['id'])
                    ->updateExistingPivot($service['id'], ['price' => $service['price']]);
            }
            return response()->json(["success" => "قیمت سرویس های مورد نظر تغییر کرده اند"], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    public function service_price(Request $request)
    {
        $rules = array(
            "services" => ["required"],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = Auth::user();
            $serviceCollection = [];
            if (@is_string($request->services))
                $serviceCollection = json_decode($request->services);
            else
                $serviceCollection = $request->services;
            foreach ($serviceCollection as $service) {
                $user->mechanic->Services()
                    ->wherePivot('service_id', '=', $service->id)
                    ->updateExistingPivot($service->id, ['price' => $service->price]);
            }
            return response()->json(["success" => "قیمت سرویس های مورد نظر تغییر کرده اند"], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

}
