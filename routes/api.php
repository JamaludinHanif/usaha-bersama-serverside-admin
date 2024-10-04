<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LogActivityController;

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

Auth::routes();

// auth
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'authenticateApi']);
    Route::post('/logout', [AuthController::class, 'logoutApi']);
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('product')->group(function () {
    Route::post('/all-product', [ProductController::class, 'showAllApi']);
    Route::post('/search-product', [ProductController::class, 'searchProduct']);
    Route::post('/pre-checkout', [ProductController::class, 'preCheckout']);
    Route::post('/checkout', [ProductController::class, 'checkOutV1']);
    Route::post('/make-redeem-code', [ProductController::class, 'addRedeemCode']);
    Route::post('/redeem-code', [ProductController::class, 'reedemCode']);
    Route::post('/my-cart', [UsersController::class, 'myCart']);
});

// untuk admin
Route::prefix('products')->group(function () {
    Route::get('/products-json', [ProductController::class, 'showAll']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
});

Route::prefix('users')->group(function () {
    Route::get('/users-json', [UsersController::class, 'showAll']);
    Route::post('/users', [UsersController::class, 'store']);
    Route::delete('/users/{id}', [UsersController::class, 'deleteUserAjax']);
    Route::put('/users/{id}', [UsersController::class, 'updateUser2']);
    // log-activity
    Route::get('/log-activities-json', [LogActivityController::class, 'showDataJson']);
});


Route::post('/send-email', [EmailController::class, 'sendEmail']);
