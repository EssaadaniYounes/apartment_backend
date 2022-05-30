<?php


use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LodgingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);


Route::middleware('auth:api')->group(function () {
    Route::resource('roles', RolesController::class);
    Route::resource('users', UserController::class);
    Route::resource('properties', PropertyController::class);
    Route::resource('lodgings', LodgingController::class);
    Route::post('lodgings/store', [LodgingController::class,'store_img']);
    Route::post('clients/store', [ClientController::class,'store_imgs']);
    Route::get('lodgings/lodging/{id}', [LodgingController::class,'getLodgingInfos']);
    Route::post('properties/store_img', [PropertyController::class,'store_imgs']);
    Route::get('available', [PropertyController::class,'getAvailable']);
    Route::resource('clients', ClientController::class);
    Route::resource('sales', SaleController::class);
    Route::put('sales/sale/{id}', [SaleController::class,'updateRest']);
    Route::resource('payments', PaymentController::class);
    Route::get('payments/payment/notifications', [PaymentController::class,'getNotifications']);
    Route::get('payments/sale/{id}',[PaymentController::class,'getPayments']);
    Route::get('payment/print/{id}',[PaymentController::class,'getPrintDetails']);
});
