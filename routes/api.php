<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\TransactionController;

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

// Auth::routes();

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
    Route::post('/make-redeem-code', [ProductController::class, 'addRedeemCode']);
    Route::post('/redeem-code', [ProductController::class, 'reedemCode']);
    Route::post('/my-cart', [UserController::class, 'myCart']);
});

Route::prefix('products')->group(function () {
    // untuk admin
    Route::get('/products-json', [ProductController::class, 'showAll']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
});

// untuk admin
Route::prefix('users')->group(function () {
    Route::get('/users-json', [UserController::class, 'showAll']);
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUserAjax']);
    Route::put('/users/{id}', [UserController::class, 'updateUser2']);
    // log-activity
    Route::get('/log-activities-json', [LogActivityController::class, 'showDataJson']);
});

// untuk user
Route::prefix('user')->group(function () {
    Route::get('/my-bill', [UserController::class, 'myBill']);
});

Route::prefix('transactions')->group(function () {
    // admin
    Route::get('/transactions-json', [TransactionController::class, 'showDataJsonAdmin']);
    // kelola bunga (admin)
    Route::get('/interest-json', [InterestController::class, 'showAll']);
    Route::post('/interest', [InterestController::class, 'store']);
    Route::delete('/interest/{id}', [InterestController::class, 'delete']);
    // kelola bunga (api)
    Route::get('/all-interest', [InterestController::class, "showAllApi"]);
    // user (api)
    Route::post('/pre-checkout', [TransactionController::class, 'preCheckout']);
    Route::post('/checkout', [TransactionController::class, 'checkOutV1']);
    Route::get('/cek-status-payment', [TransactionController::class, 'cekStatusPayment']);
    Route::post('/payment-bill', [UserController::class, 'paymentBill']);
    // kasir (api)
    Route::get('/detail-payment', [TransactionController::class, 'getDataTransactionForCashier']);
    Route::post('/confirm-payment', [TransactionController::class, 'confirmPayment']);
});
