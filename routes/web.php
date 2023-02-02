<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProvinceController;
use \App\Http\Controllers\CityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('admin/province/store', [ProvinceController::class, 'store'])->name('province.store');
Route::post('admin/city/store', [CityController::class, 'store'])->name('city.store');
