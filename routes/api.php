<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductController;

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


Route::get('user-api', [UsersController::class, 'indexApi']); // Menampilkan semua post
Route::post('user-api', [UsersController::class, 'storeApi']); // Menyimpan post baru
Route::get('user-api/{id}', [UsersController::class, 'showApi']); // Menampilkan post tertentu
Route::put('user-api/{id}', [UsersController::class, 'updateApi']); // Memperbarui post tertentu
Route::delete('user-api/{id}', [UsersController::class, 'destroyApi']); // Menghapus post tertentu


Route::post('/send-email', [EmailController::class, 'sendEmail']);
