<?php

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

use App\Http\Controllers\CartController;
use App\Http\Controllers\ConsumerController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
   return csrf_token();
});

Route::prefix('consumer')->group(function () {
    Route::post('/login', [ConsumerController::class, 'login']);
    Route::post('/register', [ConsumerController::class, 'register']);
    Route::post('/logout', [ConsumerController::class, 'logout']);
});

Route::prefix('merchant')->group(function () {
    Route::post('/login', [MerchantController::class, 'login']);
    Route::post('/register', [MerchantController::class, 'register']);
    Route::post('/logout', [MerchantController::class, 'logout']);
});

Route::prefix('consumer')->middleware('auth:consumer')->controller(CartController::class)->group(function () {
    Route::post('addToCart', 'addTo');
});

Route::prefix('store')->middleware('auth:merchant')->controller(StoreController::class)->group(function () {
    Route::patch('/', 'update');
});

Route::prefix('products')->middleware('auth:merchant')->controller(ProductsController::class)->group(function () {
    Route::post('/', 'store');
});
