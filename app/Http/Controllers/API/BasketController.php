<?php

namespace App\Http\Controllers\API;

use App\Enums\BasketStatusOrder;
use App\Enums\DeliveryStep;
use App\Enums\LocationType;
use App\Enums\MechanicTypes;
use App\Enums\RegularExpressionLocation;
use App\Enums\RoleTypes;
use App\Enums\StepRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\BasketResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryServiceResource;
use App\Http\Resources\FactorResource;
use App\Http\Resources\FactoryResource;
use App\Http\Resources\MechanicLocationResource;
use App\Http\Resources\MechanicOutResource;
use App\Http\Resources\MechanicRequestStatusResource;
use App\Http\Resources\MechanicTypeResource;
use App\Http\Resources\MehcanicLocationResource;
use App\Http\Resources\ServiceResource;
use App\Models\Basket;
use App\Models\Car;
use App\Models\Location;
use App\Models\Mechanic;
use App\Models\Mechanicaddress;
use App\Models\Mechanicrequest;
use App\Models\Problem;
use App\Models\Service;
use App\Models\Servicecategory;
use App\Models\User;
use App\Models\Yourcar;
use Auth;
use Carbon\Carbon;
use Exception;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use phpDocumentor\Reflection\Types\Resource_;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class BasketController extends Controller
{

    public function userBasketList()
    {
        try {
            $user = Auth::user();
            $baskets = $user->Baskets;//()->orderByDesc('id')->get();
            return BasketResource::collection($baskets);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function step_check_accept_mechanic($basket_id)
    {
        try {
            $basket = Basket::findOrFail($basket_id);
            if (@$basket->Mechanics()->where('status', '=', BasketStatusOrder::SUSPENDED)->count()) {
                return response()->json(new BasketResource($basket), HTTPResponse::HTTP_OK);
            }
            return response()->json(["message" => 'درخواست شما هنوز بلاتکلیف می باشد'], HTTPResponse::HTTP_MULTI_STATUS);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function step_past()
    {
        try {
            $user = Auth::user();
            $basket = Basket::whereUserId($user->id)->where('status', '=', BasketStatusOrder::ACTIVE)->first();
            return response()->json(new BasketResource($basket), HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /**************
     * @param Request $request
     * @return JsonResponse
     *
     *  STEP_01 IN ADD ITEM TO THE BASKET ....
     *
     */
    public function step_car_select(Request $request): JsonResponse
    {
        $rules = array(
            "carmodel" => "required|exists:carmodels,id",
            "user_id" => "nullable|exists:users,id",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = null;
            if (!Auth::user()->checkedHasAnyRole([RoleTypes::ADMIN, RoleTypes::SUPER_ADMIN])->count())  //// چک کن ادمین هست یا نه
                $user = Auth::user();   //// اگر ادمین نبود کاربر جاری رو بگیر
            else
                $user = User::findOrFail($request->user_id); ///// ادمین شناسه کاربری رو میده تا درخواست برای کاربر ثبت بشه

            $lat = 36.56809371602795;
            $lon = 53.058948837092295;
            ///// اگر کاربر درخواست فعال داشته باشه
            if ($user->Baskets()->whereIn('status', BasketStatusOrder::WORK)->count()) {
                /// TODO: اگر کاربر از یه مرحله ای گذشت چکش کنیم که به مرحله تعمییر نرسه
                /// خودرهای خود را چک میکنیم که آیا این خودرو مطعلق به شما می باشد؟!
                if (!@Yourcar::whereUserId($user->id)->whereCarmodelId($request->carmodel)->count())
                    return response()->json(["warning" => 'خودروی انتخابی شما در لیست خودروهای من وجود ندارد'], HTTPResponse::HTTP_LOCKED);
                /// بیا اون درخواست فعال کاربر رو بگیر و بعد ویرایش کنن بجای درخواست جدید
                $basket = $user->Baskets()->where('status', '=', BasketStatusOrder::ACTIVE)->firstOrFail();
                $basket->update([
                    'save_step' => StepRequest::STEP01,  ////
                    'status' => BasketStatusOrder::ACTIVE,  //// when user doesn't pay , status can be active , cancel , success transaction
                    'serve_product_by_mechanic' => true,/// default use true when we don't serve product
                    'mechanic_type' => MechanicTypes::BOTH,///// it's a real default value
                    'carmodel_id' => $request->carmodel,
                    'user_id' => $user->id,
                    'latitude' => $lat,
                    'longitude' => $lon
                ]);
                return response()->json([
                    'basket_id' => $basket->id,
                    'success' => 'item added to basket ,successfully.'
                ], HTTPResponse::HTTP_OK);
            }
            $basket = Basket::create([
                'save_step' => StepRequest::STEP01,  ////
                'status' => BasketStatusOrder::ACTIVE,  //// when user doesn't pay , status can be active , cancel , success transaction
                'serve_product_by_mechanic' => true,/// default use true when we don't serve product
                'mechanic_type' => MechanicTypes::BOTH,///// it's a real default value
                'carmodel_id' => $request->carmodel,
                'user_id' => $user->id,
                'latitude' => $lat,
                'longitude' => $lon
            ]);
            return response()->json(['basket_id' => $basket->id,
                'success' => 'item added to basket, successfully.'], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function step_mechanic_type_select($id, Request $request)
    {
        $rules = array(
            "mechanic_type" => ["required", Rule::in(MechanicTypes::ALL)],
            "i_know_problem" => ["required", Rule::in(["true", "false"])],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $basket = Basket::findOrFail($id);
            $problem = null;
            if (@is_string($request->i_know_problem))
                $problem = json_decode($request->i_know_problem);
            else
                $problem = $request->i_know_problem;

            $basket->updateOrFail([
                'save_step' => StepRequest::STEP02,  //// store user spend step
                'mechanic_type' => $request->mechanic_type,  /// mechanic type request
                'i_know_problem' => $problem,   /// when user know problem is true
            ]);
            if ($problem) {
                return response()->json(new MechanicTypeResource($basket), HTTPResponse::HTTP_OK);
            } else {
                $mechanics = Mechanic::whereActivated(true)
                    ->whereHas('locations', function ($q) use ($basket) {
                        $q->whereType(MechanicTypes::MOBILE)->selectRaw("mechanic_id, lat, lon,support_space, SQRT(POW(69.1 * (lat - '" . $basket->latitude .
                            "'), 2) + POW(69.1 * ('" . $basket->longitude . "' - lon) * COS(lat / 57.3), 2)) AS distance ")
                            ->havingRaw('distance < 200')->orderBy('distance');
                    })->get();
                foreach ($mechanics as $mechanic) {
                    if (!@$mechanic->Baskets->where('type', MechanicTypes::MOBILE)->where('status', '=', BasketStatusOrder::ACTIVE)->count() &&
                        !@$mechanic->Baskets()->wherePivot('mechanic_id', '=', $mechanic->id)->wherePivot('basket_id', '=', $basket->id)->count()) {
                        $mechanic->Baskets()->attach(array($basket->id => array('status' => BasketStatusOrder::SUSPENDED)));
                    } else {
                       $basket->updateOrFail([
                           'status' => BasketStatusOrder::FAILS,  //// store user spend step
                       ]);
                        return response()->json(['sorry' => 'اشتباهی رخ داده است.'], HTTPResponse::HTTP_BAD_REQUEST);
                    }
                   if (!@$mechanic->Baskets->where('type', MechanicTypes::MOBILE)->where('status', '=', BasketStatusOrder::ACTIVE)->count() &&
                       @$mechanic->Baskets()->wherePivot('mechanic_id', '=', $mechanic->id)->wherePivot('basket_id', '=', $basket->id)->count()) {
                   }
                }

                return response()->json(["basket" => $basket->id, "success" => 'درخواست شما ثبت شده است، لطفا منتظر بمانید'], HTTPResponse::HTTP_OK);
            }
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function step_select_problem($id, Request $request)
    {
        $rules = array(
            "problem" => ["required", Rule::exists('problems', 'id')],
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
            $basket = Basket::findOrFail($id);
            $currentProblem = Problem::findOrFail($request->problem);
            if ($basket->mechanic_type == MechanicTypes::STABLE) {
                $basket->updateOrFail([
                    'save_step' => StepRequest::STEP03,  //// store user spend step
                    'problem_id' => $currentProblem->id,   /// when user store problem
                    "latitude" => $request->latitude,
                    "longitude" => $request->longitude,
                ]);
                return response()->json(["message" => 'done'], HTTPResponse::HTTP_OK);
            }
            $basket->updateOrFail([
                'save_step' => StepRequest::STEP04,  //// store user spend step
                'problem_id' => $currentProblem->id,   /// when user store problem
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            return response()->json(["message" => 'done'], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function step_select_your_service($id, Request $request)
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

            if (is_string($request->services)) {
                $services = json_decode($request->services);
            } else {
                $services = $request->services;
            }
            $basket = Basket::findOrFail($id);
            $basket->updateOrFail([
                "latitude" => $request["latitude"],
                "longitude" => $request["longitude"],
            ]);
            if (!@Service::whereCarmodelId($basket->carmodel_id)->whereIn('id', $services)->count())
                return response()->json(["warning" => 'خودورهای انتخابی شما چنین سرویس را پشتیبانی نمی کند'], HTTPResponse::HTTP_LOCKED);

            $currentServices = Service::whereCarmodelId($basket->carmodel_id)->whereIn('id', $services)->pluck('id');


            $type = [$basket->mechanic_type, MechanicTypes::BOTH];

            $mechanics = Mechanic::whereActivated(true)
            ->WhereHas('services', function ($q) use ($currentServices) {
                $q->whereIn('service_id', $currentServices);
            })->whereHas('locations', function ($q) use ($basket) {
                $type = [$basket->mechanic_type, MechanicTypes::BOTH];
                $q->whereIn('type', $type)->selectRaw("mechanic_id, lat, lon,support_space, SQRT(POW(69.1 * (lat - '" . $basket->latitude .
                    "'), 2) + POW(69.1 * ('" . $basket->longitude . "' - lon) * COS(lat / 57.3), 2)) AS distance ")
                    ->havingRaw('distance < 2000')->orderBy('distance');
            })->get();

            if ($basket->mechanic_type == MechanicTypes::STABLE) {
                $basket->updateOrFail([
                    'save_step' => StepRequest::STEP03,  //// store user spend step
                ]);
            }
            if ($basket->mechanic_type == MechanicTypes::MOBILE) {
                $basket->updateOrFail([
                    'save_step' => StepRequest::STEP04,  //// store user spend step
                ]);
            }

            $basket->Services()->sync($services); ///do master step store
            if ($basket->mechanic_type == MechanicTypes::MOBILE) {
                $response = null;
                foreach ($mechanics as $mechanic) {
                    if (!@$mechanic->Baskets->where('type', MechanicTypes::MOBILE)->where('status', '=', BasketStatusOrder::ACTIVE)->count()) {
                        $mechanic->Baskets()->attach(array($basket->id => array('status' => BasketStatusOrder::SUSPENDED)));
                        $response = 1;
                    }
                }
                if ($response == null) {
                    $basket->updateOrFail([
                        'status' => BasketStatusOrder::FAILS,  //// store user spend step
                    ]);
                    return response()->json(['sorry' => 'مکانیکی یافت نشد!'], HTTPResponse::HTTP_BAD_REQUEST);
                }
                return response()->json(["basket" => $basket->id, "success" => 'درخواست شما ثبت شده است، لطفا منتظر بمانید'], HTTPResponse::HTTP_OK);
            } else {
                return MechanicOutResource::collection($mechanics);
            }
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /*******************************
     * @param $id
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Throwable
     * زمان انتخاب رفتن به تعمیرکار
     */
    public function select_date_time_picker($id, Request $request)
    {
        //////// step 100 for select date time picker ...
        $rules = array(
            "time" => ["required", "date_format:H:i"],
            "date" => ["required", "shamsi_date"],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $persianDateSplit = Str::of($request->date)->explode('/');
            $dateGregorianSpilt = Verta::getGregorian($persianDateSplit[0], $persianDateSplit[1], $persianDateSplit[2],);
            $date = implode('/', $dateGregorianSpilt);
            $dateConverted = Carbon::make($date)->format("Y/m/d");
            $basket = Basket::find($id);
            if (!@$basket->Reservation->count()) {
                $basket->Reservation()->create([
                    'date' => $dateConverted,
                    'time' => $request->time,
                ]);
            } else {
                $basket->Reservation()->update([
                    'date' => $dateConverted,
                    'time' => $request->time,
                ]);
            }
            $basket->save_step = StepRequest::STEP100;
            $basket->save();
            return BasketResource::make($basket);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    public function step_select_mechanic($id, Request $request)
    {
        $rules = array(
            "mechanic" => ["required", Rule::exists('mechanics', 'id')],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $basket = Basket::findOrFail($id);
            $basket->updateOrFail([
                'save_step' => StepRequest::STEP04,  //// store user spend step
            ]);
            $basketCount = $basket->getBasket($request->mechanic)->count();
            if (@$basketCount >= Mechanic::findOrFail($request->mechanic)->count_available) {
                return response()->json(["fails" => 'متاسفانه مکانیک مورد نظر شما، لیست خود را پر کرده است، لطفا بعدا درخواست کنید'], HTTPResponse::HTTP_BAD_REQUEST);
            }
//            $mechanicRequestCount = Mechanicrequest::whereMechanicId($request->mechanic)->whereNotIn('status', BasketStatusOrder::WORK)->whereDate('created_at', Carbon::today())->count();
            $mechanic = Mechanic::CanRepairCar($request->mechanic, $basketCount)->firstOrFail();
            $current = $mechanic->Locations->where('type', $basket->mechanic_type)->firstOrFail();
            if (@$current) {
                $mechanic->Baskets()->attach(array($basket->id => array('status' => BasketStatusOrder::SUSPENDED)));
                return MechanicLocationResource::make($current)->basket($basket);
            } else {
                return response()->json(["fails" => 'متاسفانه مکانیک مورد نظر شما، لیست خود را پر کرده است، لطفا بعدا درخواست کنید'], HTTPResponse::HTTP_BAD_REQUEST);
            }
        } catch (Exception $ex) {
            return response()->json(["error" => $ex], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function calculate_rent($id)
    {
        try {
            $basket = Basket::findOrFail($id);
            $location = $basket->mechanic->first()->Locations->where('type', '=', $basket->mechanic_type)->first();
            //// کرایه به کیلومتر 80000 ریـال
            $response = \Http::withHeaders([
                'x-api-key' => env("MAP_IR_KEY")
            ])->get('https://map.ir/distancematrix', [
                'origins' => '1,' . $basket->latitude . ',' . $basket->longitude,
                'destinations' => '1,' . $location->lat . ',' . $location->lon,
                'sorted' => 'true',
                '$filter' => 'type eq distance',
            ]);

            return response()->json(json_decode($response->body()), HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }

    }

    public function generate_factor($id)
    {
        $basket = Basket::findOrFail($id);
        return new BasketResource($basket);
    }

    public function generate_factor_for_mechanic($id)
    {
        $user = Auth::user();
        $mechanic = $user->mechanic->id;
        BasketResource::$currentMechanic = $mechanic;
//        $current = Basket::findOrFail($id)->Mechanics()->where('id','=',$mechanic->id)->first();
        $basket = Basket::with('mechanics')->findOrFail($id);
        return new BasketResource($basket);
    }


    public function post_accept_request_mechanic($basket, Request $request)
    {
        dd('come');
        $rules = array(
            "status" => ["required", Rule::in(BasketStatusOrder::ALL)],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            \DB::beginTransaction();
            $basket = Basket::findOrFail($basket);
            $user = Auth::user(); /// equals to mechanic این یعنی برابری با مکانیک میکنه
            dd($basket);
            if (@$request->status) {
                $basket->update([
                    'save_step' => StepRequest::STEP05,
                    'status' => BasketStatusOrder::ACTIVE,
                ]);
                $user->mechanic->Baskets()->where('id', '=', $basket->id)
                    ->updateExistingPivot($basket->id, ['status' => BasketStatusOrder::ACTIVE]);   ////   update pivot table mechanic basket
                $items = $basket->Mechanics()->where('id', '<>', $user->mechanic->id)->pluck('id'); //// select items ids aren't include active status
                $basket->Mechanics()->detach($items);  //// remove all de-active status
                $basket->update(['delivery_step' => DeliveryStep::ACCEPTED]);
                \DB::commit();
                return response()->json(["message" => "درخواست توسط شما تایید شده است."], HTTPResponse::HTTP_OK);
            } else {
                $user->mechanic->Baskets()->where('id', '=', $basket->id)
                    ->updateExistingPivot($basket->id, ['status' => BasketStatusOrder::CANCEL]);   ////   update pivot table mechanic basket
                $items = $basket->Mechanics()->where('id', '=', $user->mechanic->id)->pluck('id'); //// select items ids aren't include active status
                $basket->Mechanics()->detach($items);  //// remove all de-active status
                \DB::commit();
                return response()->json(["success" => "درخواست توسط شما رد شده است."], HTTPResponse::HTTP_OK);
            }
        } catch (Exception $ex) {
            \DB::rollBack();
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function canceling($id)
    {
        try {
            $basket = Basket::findOrFail($id);
            $basket->updateOrFail([
                'status' => BasketStatusOrder::CANCEL,  //// store user spend step
            ]);
            $items = $basket->Mechanics()->pluck('id'); //// select items ids aren't include active status
            $basket->Mechanics()->detach($items);  //// remove all de-active status
            return response()->json(["success" => "درخواست شما کنسل شده است."], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function cancel_mechanic_factor($id)
    {
        try {
            $basket = Basket::findOrFail($id);
            $basket->updateOrFail([
                'status' => BasketStatusOrder::CANCEL,  //// store user spend step
            ]);
            $user = Auth::user();
            $mechanic = $basket->Mechanics()->where('user_id', '=', $user->id)->pluck('id'); //// select items ids aren't include active status
            $basket->Mechanics()->detach([$mechanic]);  //// remove all de-active status
            return response()->json(["success" => "درخواست شما کنسل شده است."], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function delete_service_factor($basket_id, Request $request): JsonResponse
    {
        $rules = array(
            "service" => ["required", Rule::exists('services', 'id')],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $basket = Basket::findOrFail($basket_id);
            $service = Service::findOrFail($request->service)->subject;
            if ($basket->Services()->findOrFail($request->service)->where('status', '=', false)) {
                $basket->Services()->detach([$request->service]);
            }
            return response()->json(["success" => "سرویس " . $service . " با موفقیت حذف شده است."], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /**************************
     * @param $basket_id
     * @param Request $request
     * @return JsonResponse
     * Added Services to the factor
     */
    public function add_service_factor($basket_id, Request $request)
    {
        $rules = array(
            "service" => ["required", Rule::exists('services', 'id')],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $basket = Basket::findOrFail($basket_id);
            $basket->Services()->attach([$request->service]);
            return response()->json(["success" => "سرویس جدید با موفقیت ثبت شده است."], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /***************************
     * @param $basket_id
     * @param Request $request
     * @return JsonResponse
     * Add mechanic to factor
     */
    public function add_mechanic_factor($basket_id, Request $request)
    {
        $rules = array(
            "service" => ["required", Rule::exists('services', 'id')],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $basket = Basket::findOrFail($basket_id);
            $basket->Services()->attach([$request->service => ['status' => @$request->status ? $request->status : null, 'price' => @$request->price ? $request->price : null]]);
            return response()->json(["success" => "سرویس جدید با موفقیت ثبت شده است."], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /*********************
     * @param $basket_id
     * @param Request $request
     * @return JsonResponse
     * Mechanic Updated Factor
     */
    public function update_factor($basket_id, Request $request): JsonResponse
    {
        $rules = array(
            "service" => ["required", Rule::exists('services', 'id')],
            "price" => ["required"],
            "status" => ["required", "boolean"],);
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $basket = Basket::findOrFail($basket_id);
            $basket->Services()->updateExistingPivot($request->service, ['status' => $request->status, 'price' => $request->price]);
            return response()->json(["success" => "سرویس جدید با موفقیت ثبت شده است."], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /***********************
     * @param $basket_id
     * @param Request $request
     * @return JsonResponse
     * Mechanic Added Services to the Baskets
     */
    public function mechanic_add_service_basket($basket_id, Request $request)
    {

        $rules = array(
            "services.*" => ["required", "exists:services,id"],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $basket = Basket::findOrFail($basket_id);
            $user = Auth::user();
            $servicesArray = [];
            if (@is_string($request->services))
                $servicesArray = json_decode($request->services);
            else
                $servicesArray = $request->services;
            if (@$basket->Mechanics()->where('user_id', '=', $user->id)->wherePivot('status', '=', BasketStatusOrder::ACTIVE)->count())
                $basket->Services()->syncWithoutDetaching($servicesArray);
            else
                return response()->json(["error" => "کاربر گرامی، شما دسترسی به این بخش را ندارید"], HTTPResponse::HTTP_BAD_REQUEST);

            return response()->json(["success" => "سرویس جدید با موفقیت ثبت شده است."], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /**************************
     * @param $basket_id
     * @param Request $request
     * @return JsonResponse
     * Mechanic remove services from baskets ....
     */
    public function mechanic_remove_service_basket($basket_id, Request $request)
    {
        $rules = array(
            "services.*" => ["required", "exists:services,id"],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $basket = Basket::findOrFail($basket_id);
            $user = Auth::user();
            $servicesArray = [];
            if (@is_string($request->services))
                $servicesArray = json_decode($request->services);
            else
                $servicesArray = $request->services;

            if ($basket->Mechanics()->wherePivot('status', '=', BasketStatusOrder::ACTIVE)->where('user_id', '=', $user->id)->count())
                $basket->Services()->detach($servicesArray);
            else
                return response()->json(["error" => "کاربر گرامی، شما دسترسی به این بخش را ندارید"], HTTPResponse::HTTP_BAD_REQUEST);

            return response()->json(["success" => "سرویس های مورد نظر با موفقیت برداشته شده اند."], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    public function set_step_delivery($basket_id, Request $request)
    {
        $rules = array(
            "delivery_step" => ["required", Rule::in(DeliveryStep::ALL)],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $basket = Basket::findOrFail($basket_id);
            $basket->delivery_step = $request->delivery_step;
            $basket->save();
            return new BasketResource($basket);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }

    }

}
