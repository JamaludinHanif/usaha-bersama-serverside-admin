<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UsersController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('user-api', [UsersController::class, 'indexApi']); // Menampilkan semua post
Route::post('user-api', [UsersController::class, 'storeApi']); // Menyimpan post baru
Route::get('user-api/{id}', [UsersController::class, 'showApi']); // Menampilkan post tertentu
Route::put('user-api/{id}', [UsersController::class, 'updateApi']); // Memperbarui post tertentu
Route::delete('user-api/{id}', [UsersController::class, 'destroyApi']); // Menghapus post tertentu


Route::post('/send-email', [EmailController::class, 'sendEmail']);
