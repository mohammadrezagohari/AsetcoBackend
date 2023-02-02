<?php

use App\Enums\PermissionTypes;
use App\Http\Controllers\API\BasketController;
use App\Http\Controllers\API\CarController;
use App\Http\Controllers\API\ColorController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\InviteController;
use App\Http\Controllers\API\MechanicController;
use App\Http\Controllers\API\ModelController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ProblemController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RateController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ServicecategoyController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\ServiceMechanicController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\API\YearController;
use App\Http\Controllers\API\YourcarController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Mechanic\MobileMechanicController;
use App\Http\Controllers\Mechanic\StableMechanicController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------F-------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/cities/{province}', [CityController::class, 'get']);
Route::get('/invited-by/{invite}', [InviteController::class, 'verifyInvite'])->name('invite.verifyInvite');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('login', function () {
        return 'ok';
    })->name('test-token');

    #region Model
    Route::prefix('models')->group(function () {
        Route::get('/{car}', [ModelController::class, 'index'])->name('model.index');
        Route::post('/store', [ModelController::class, 'store'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('model.store');
        Route::patch('/update/{id}', [ModelController::class, 'update'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('model.update');
        Route::delete('/delete/{id}', [ModelController::class, 'delete'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('model.delete');
    });
    #endregion
    #region Color
    Route::prefix('color')->group(function () {
        Route::get('/index', [ColorController::class, 'index'])->name('color.index');
        Route::post('/store', [ColorController::class, 'store'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('color.store');
        Route::patch('/update/{id}', [ColorController::class, 'update'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('color.update');
        Route::delete('/delete/{id}', [ColorController::class, 'delete'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('color.delete');
    });
    #endregion
    #region car
    Route::prefix('car')->group(function () {
        Route::get('/index', [CarController::class, 'index'])->name('car.index');
        Route::post('/store', [CarController::class, 'store'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('car.store');
        Route::patch('/update/{id}', [CarController::class, 'update'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('car.update');
        Route::delete('/delete/{id}', [CarController::class, 'delete'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('car.delete');
    });
    #endregion
    #region Year
    Route::prefix('years')->group(function () {
        Route::get('/index', [YearController::class, 'index'])->name('year.index');
        Route::post('/store', [YearController::class, 'store'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('year.store');
        Route::patch('/update/{id}', [YearController::class, 'update'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('year.update');
        Route::delete('/delete/{id}', [YearController::class, 'delete'])->middleware('is_authorized:' . PermissionTypes::EDIT_CAR)->name('year.delete');
    });
    #endregion
    #region products
    Route::prefix('products')->group(function () {
        Route::get('/index', [ProductController::class, 'index'])->name('products.index');
        Route::post('/store', [ProductController::class, 'store'])->middleware('is_authorized:' . PermissionTypes::EDIT_PRODUCT)->name('products.store');
        Route::patch('/update/{id}', [ProductController::class, 'update'])->middleware('is_authorized:' . PermissionTypes::EDIT_PRODUCT)->name('products.update');
        Route::delete('/delete/{id}', [ProductController::class, 'delete'])->middleware('is_authorized:' . PermissionTypes::EDIT_PRODUCT)->name('products.delete');
    });
    #endregion
    #region services
    Route::prefix('services')->group(function () {
        Route::get('/checked-car-service/{carmodel_id}', [ServiceController::class, 'check_your_car_has_service'])->name('services.checkHasThisCar');
        Route::get('/index', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/{servicecategory}/{basket}', [ServiceController::class, 'getByCategory'])->name('getByCategory');
        Route::post('/store', [ServiceController::class, 'store'])->middleware('is_authorized:' . PermissionTypes::EDIT_SERVICE)->name('services.store');
        Route::patch('/update/{id}', [ServiceController::class, 'update'])->middleware('is_authorized:' . PermissionTypes::EDIT_SERVICE)->name('services.update');
        Route::delete('/delete/{id}', [ServiceController::class, 'delete'])->middleware('is_authorized:' . PermissionTypes::EDIT_SERVICE)->name('services.delete');
        Route::get('/list-services', [ServiceController::class, 'list_services'])->name('services.list');
    });

    Route::post('/category-assign-car', [ServicecategoyController::class, 'assign_car_to_category'])->name('category.to.car');
    Route::post('/service-filter-category', [ServicecategoyController::class, 'ServiceFilterByCategory'])->name('service.filter.category');
    Route::prefix('service-category')->group(function () {
        Route::get('/', [ServicecategoyController::class, 'index'])->name('service-category.index');
    });
    ///// مسیر بالا برای فیلتر کردن سرویس توسط دسته بندی سرویس ها
    #endregion
    #region problems
    Route::prefix('problems')->group(function () {
        Route::get('/list', [ProblemController::class, "list"])->name('problems.list');
    });
    #endregion
    #region filter
    Route::prefix('filter')->group(function () {
        ///// سرویس هایی که برای یک دسته بندی خاص ساخته شده اند.
        Route::post('/service-category', [ServicecategoyController::class, 'ServiceFilterByCategory'])->name('service.filter.category');
    });
    #endregion
    #region transaction
    Route::prefix('transaction')->group(function () {
        Route::post('/connect-to-bank/{basket}', [TransactionController::class, 'connect_bank_saderat'])->name('transaction.connect_bank');
        Route::post('/callback/saderat', [TransactionController::class, 'callback_saderat'])->name('callback.saderat');
    });
    #endregion

    #region invite
    Route::prefix('invite')->group(function () {
        Route::post('/generate', [InviteController::class, 'generate'])->name('invite.generate');
        Route::get('/list-your-invites', [InviteController::class, 'listYourInvites'])->name('invite.listYourInvites');
        Route::get('/user-invite-list/{user}', [InviteController::class, 'userInviteList'])->name('invite.userInviteList');
    });
    #endregion

    #region basket
    Route::prefix('basket')->group(function () {
        Route::get('/user-request-list', [BasketController::class, 'userBasketList'])->name('baskets.userBasketList');
        Route::get('/step_check_accept_mechanic/{basket}', [BasketController::class, 'step_check_accept_mechanic'])->name('basket.step_check_accept_mechanic');
        Route::get('/get-step', [BasketController::class, 'step_past'])->name('basket.step_past');
        Route::post('/step_car_select', [BasketController::class, 'step_car_select'])->name('basket.step_car_select');  ///01
        Route::post('/step_mechanic_type_select/{basket}', [BasketController::class, 'step_mechanic_type_select'])->name('basket.step_mechanic_type_select');//02
        Route::post('/step_select_problem/{basket}', [BasketController::class, 'step_select_problem'])->name('basket.step_select_problem');//03 if has prblem
        Route::post('/step_select_your_service/{basket}', [BasketController::class, 'step_select_your_service'])->name('basket.step_select_your_service');
        Route::post('/step-select-date-picker/{basket}', [BasketController::class, 'select_date_time_picker'])->name('basket.select_date_time_picker');
        Route::post('/step-select-mechanic/{basket}', [BasketController::class, 'step_select_mechanic'])->name('basket.step_select_mechanic');
        Route::get('/generate_factor/{basket}', [BasketController::class, 'generate_factor'])->name('basket.generate_factor');
        Route::get('/generate_factor_for_mechanic/{basket}', [BasketController::class, 'generate_factor_for_mechanic'])->name('basket.generate_factor_for_mechanic');
        Route::post('/delete_service_factor/{basket}', [BasketController::class, 'delete_service_factor'])->name('basket.delete_service_factor');
        Route::post('/add_service_factor/{basket}', [BasketController::class, 'add_service_factor'])->name('basket.add_service_factor');
        Route::post('/update_factor/{basket}', [BasketController::class, 'update_factor'])->name('basket.update_factor');
        Route::post('/add_mechanic_factor/{basket}', [BasketController::class, 'add_mechanic_factor'])->name('basket.add_mechanic_factor');
        Route::get('/calculate-rent/{basket}', [BasketController::class, 'calculate_rent'])->name('basket.calculate_rent');
        Route::get('/canceling/{basket}', [BasketController::class, 'canceling'])->name('basket.canceling');
        Route::get('/cancel_mechanic_factor/{basket}', [BasketController::class, 'cancel_mechanic_factor'])->name('basket.cancel_mechanic_factor');
        Route::post('/accept-request-mechanic/{basket}', [BasketController::class, 'post_accept_request_mechanic'])->name('basket.post_accept_request_mechanic');
        Route::post('/mechanic-add-service/{basket}', [BasketController::class, 'mechanic_add_service_basket'])->name('basket.mechanic_add_service');
        Route::post('/mechanic-remove-service/{basket}', [BasketController::class, 'mechanic_remove_service_basket'])->name('basket.mechanic_remove_service_basket');
        //// route delivery step (get step) and (set step) status
//        Route::get('/get-step-delivery/{basket}', [BasketController::class, 'get_step_delivery'])->name('baskets.get_step_delivery');
        Route::post('/set-step-delivery/{basket}', [BasketController::class, 'set_step_delivery'])->name('baskets.set_step_delivery');
    });
    #endregion

    #region service_mechanic /**** section service for mechanic *****/
    Route::post('/list/services', [ServiceMechanicController::class, 'service_list'])->name('service.list');
    Route::post('/list-services/find-by-mechanic/', [ServiceMechanicController::class, 'service_list_for_mechanic'])
        ->name('service.find.mechain');

    Route::post('/list-services/find-by-service/', [ServiceMechanicController::class, 'list_mechanic_for_service'])
        ->name('mechanics.find.service');


    Route::post('/services-assign/mechanic-serve-service/', [ServiceMechanicController::class, 'assign_mechanic_serve_service'])
        ->name('assign.mechanic.serve.service');

    Route::post('/mechanic/list/near', [ServiceMechanicController::class, 'mechanic_list_near'])
        ->name('mechanic.list.near');

    Route::post('/services-assign/user-request-service/', [OrderController::class, 'user_request_service'])
        ->name('user.request.service');
    #endregion
    #region order /*** section order api route ***/
    Route::post('/order/store', [OrderController::class, 'store'])
        ->name('order.store');

    Route::post('/order/mechanic-serve-products', [OrderController::class, 'mechanic_serve_products'])
        ->name('order.mechanic.serve.products');

    Route::post('/order/index', [OrderController::class, 'index'])
        ->name('order.index');

    Route::patch('/order/update/{order}', [OrderController::class, 'update'])
        ->name('order.update');

    Route::delete('/order/delete/{order}', [OrderController::class, 'delete'])
        ->name('order.update');
    #endregion
    #region Comment /******** section comment api *********/
    Route::get('comments/index', [CommentController::class, 'index'])->name('comments.index');
    Route::get('comments/mechanic/{mechanic}', [CommentController::class, 'mechanic'])->name('comments.mechanic');
    Route::post('comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::post('comment/reply/{comment}', [CommentController::class, 'reply'])->name('comment.reply');
    Route::post('comment/accepted/{comment}', [CommentController::class, 'accepted'])->name('comment.accepted');
    Route::delete('comment/delete/{comment}', [CommentController::class, 'delete'])->name('comment.delete');
    #endregion
    #region Rate /******** section Rates api *********/
    Route::post('rate/{mechanic}/store', [RateController::class, 'store'])->name('rate.store');
    Route::get('rate/top-rate', [RateController::class, 'top_rate_mechanic'])->name('rate.top_rate_mechanic');
    #endregion
    #region Mechanic /******** section Mechanic api *********/
    Route::get('dashboard/mechanic/index', [MechanicController::class, 'index'])->name('mechanic.index');
    Route::post('dashboard/mechanic/store', [MechanicController::class, 'staore'])->name('mechanic.store');
    Route::patch('dashboard/mechanic/{mechanic}/update', [MechanicController::class, 'update'])->name('mechanic.update');
    ///TODO: Exception" just location use location id but every others using mechanic_id
    Route::post('dashboard/mechanic/store', [MechanicController::class, 'store'])->name('mechanic.store');

    Route::patch('dashboard/mechanic/{user}/update/both', [MechanicController::class, 'updateBothService'])->name('mechanic.update');
    Route::patch('dashboard/mechanic/{user}/update/stable', [MechanicController::class, 'updateStableService'])->name('mechanic.update.stable');
    Route::patch('dashboard/mechanic/{user}/update/update', [MechanicController::class, 'updateMobileService'])->name('mechanic.update.mobile');
    Route::patch('dashboard/mechanic/{location}/location/update', [MechanicController::class, 'update_location'])->name('mechanic.update.location');
    Route::patch('dashboard/mechanic/{mechanic}/address/update', [MechanicController::class, 'udpate_address_mechanic'])->name('mechanic.update.location');
    Route::delete('dashboard/mechanic/{mechanic}/delete', [MechanicController::class, 'delete'])->name('mechanic.delete');
    Route::post('mechanic/find/near', [MechanicController::class, 'findNearLocation'])->name('mechanic.findNearLocation');
    #endregion
    #region YourCar /********* section User selected cars ********/
    // کاربر میاد اینجا ماشینش رو انتخاب میکنه، تعیین رنگ و مدل و سال و برند خودرو اینجاس
    Route::prefix('yourcars')->group(function () {
        Route::get('/index', [YourcarController::class, 'index'])->name('yourcar.index');
        Route::post('/store', [YourcarController::class, 'store'])->name('yourcar.store');
        Route::post('/update/{id}', [YourcarController::class, 'update'])->name('yourcar.update');
        Route::delete('/delete/{id}', [YourcarController::class, 'delete'])->name('yourcar.delete');
    });
    #endregion

    Route::prefix('wallets')->group(function () {
        Route::get('/', [WalletController::class, 'index'])->name('wallets.index');
        Route::post('/increase/mechanic', [WalletController::class, 'increaseMechanic'])->name('wallets.increaseMechanic');
        Route::post('/increase/user', [WalletController::class, 'increaseUser'])->name('wallets.increaseUser');
    });
    Route::prefix('payment')->group(function () {
        Route::post('/request', [PaymentController::class, 'request'])->name('payment.request');
        Route::post('/accept/{payment}', [PaymentController::class, 'acceptPayment'])->name('payment.acceptPayment');
        Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
    });

    Route::prefix('media')->middleware('auth:sanctum')->group(function () {
        Route::post('/', [MediaController::class, 'store'])->name('store-media');
    });
    
    Route::name('user.')->prefix('user')->middleware('auth:sanctum')->group(function () {
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'delete'])->middleware('is_authorized:' . PermissionTypes::EDIT_USER)->name('delete');
        Route::get('/all', [UserController::class, 'index'])->name('all');
        Route::get('/', [UserController::class, 'profile'])->name('profile');
    });
    
    Route::name('mechanic.')->prefix('mechanic')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [MechanicController::class, 'show'])->name('mechanic.show');
        Route::patch('/update/both', [MechanicController::class, 'updateBothService'])->name('mechanic.update');
        Route::patch('/update/stable', [MechanicController::class, 'updateStableService'])->name('mechanic.update.stable');
        Route::post('/select-mechanic/{basket}', [MechanicController::class, 'select_mechanic'])->name('mechanic.select.list');
        Route::post('/serve-mechanic-for-problem/{basket}', [MechanicController::class, 'serve_mechanic_for_problem'])->name('mechanic.serve.mechanic.problem'); /// ارائه لیست مکانیک برای سرویس مورد نظر شما
        Route::get('/get-last-request-mechanic', [MechanicController::class, 'get_last_request_mechanic'])->name('get-last-request-mechanic'); //// لیست آخرین درخواست هایی که برای مکانیک ارائه میشه.
        Route::get('/get-my-request-mechanic', [MechanicController::class, 'get_my_request_mechanic'])->name('get_my_request_mechanic'); //// لیست آخرین درخواست هایی که برای مکانیک ارائه میشه.
        Route::post('/update-service-price', [MechanicController::class, 'update_service_price'])->name('mechanic.update_service_price');
    
        Route::name('stable.')->prefix('/stable')->group(function () {
            Route::post('/{user}', [StableMechanicController::class, 'store'])->name('store');
            Route::put('/{user}/{mechanic}', [StableMechanicController::class, 'update'])->middleware('is_authorized:' . PermissionTypes::EDIT_MECHANIC)->name('update');
            Route::delete('/{user}/{mechanic}', [StableMechanicController::class, 'delete'])->middleware('is_authorized:' . PermissionTypes::EDIT_MECHANIC)->name('delete');
            Route::get('/{user}/{mechanic}', [StableMechanicController::class, 'show'])->name('show');
            Route::get('/', [StableMechanicController::class, 'index'])->name('list');
        });
        Route::name('mobile.')->prefix('/mobile')->group(function () {
            Route::post('/{user}', [MobileMechanicController::class, 'store'])->name('store');
            Route::put('/{user}/{mechanic}', [MobileMechanicController::class, 'update'])->middleware('is_authorized:' . PermissionTypes::EDIT_MECHANIC)->name('update');
            Route::delete('/{user}/{mechanic}', [MobileMechanicController::class, 'delete'])->middleware('is_authorized:' . PermissionTypes::EDIT_MECHANIC)->name('delete');
            Route::get('/{user}/{mechanic}', [MobileMechanicController::class, 'show'])->name('show');
            Route::get('/', [MobileMechanicController::class, 'index'])->name('list');
        });
    });
    
    Route::name('role.')->prefix('role')->middleware(['auth:sanctum', 'is_authorized:' . PermissionTypes::EDIT_ROLE])->group(function () {
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::post('assign', [RoleController::class, 'assign'])->name('assign');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'delete'])->name('delete');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        Route::get('/', [RoleController::class, 'index'])->name('index');
    });
    
    


});

Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::get('verify', [LoginController::class, 'verify'])->name('verify')->middleware('auth:sanctum');
    Route::post('register', [RegisterController::class, 'register'])->name('register');
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    Route::post('verification.code', [VerificationCodeController::class, 'send'])->name('verification.send');
    Route::post('verification.verify', [VerificationCodeController::class, 'verify'])->name('verification.verify');
});

