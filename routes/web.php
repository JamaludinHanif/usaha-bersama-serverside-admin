<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\TransactionController;

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
    return view('login');
});

// Auth::routes();

// login
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::prefix('admin')->middleware(['is_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // users
    Route::prefix('users')->group(function () {
        // menggunakan ajax
        Route::get('/users', [UserController::class, 'indexUsers']);
        Route::get('/create', [UserController::class, 'create']);
        Route::get('/users-json', [UserController::class, 'showAll']);
        Route::get('/users/{id}/edit', [UserController::class, 'editUser2']);
        Route::post('/users', [UserController::class, 'store']);
        Route::delete('/users/{id}', [UserController::class, 'deleteUserAjax']);
        Route::put('/users/{id}', [UserController::class, 'updateUser2']);
        // log-activity
        Route::get('/log-activities', [LogActivityController::class, 'showAll']);
        // excel

    });

    // products
    Route::prefix('products')->group(function () {
        // kelola products
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/create-products', [ProductController::class, 'showFormCreate']);
        Route::get('/products/{id}/edit', [ProductController::class, 'editproduct']);
    });

    // products
    Route::prefix('transaction')->group(function () {
        Route::get('/transaction', [TransactionController::class, 'showAll'])->name('transaction');
    });

    // recycle bin
    Route::prefix('recycle')->group(function () {
        // users
        Route::get('/users', [UserController::class, 'indexRestore']);
        Route::get('/users-json', [UserController::class, 'showAllDeleted']);
        Route::get('/users/{id}/restore', [UserController::class, 'restore']);
        Route::get('/users/{id}/destroy', [UserController::class, 'destroy']);

        // products
        Route::get('/products', [ProductController::class, 'indexRecycle']);
        Route::get('/products-json', [ProductController::class, 'showAllRecycle']);
        Route::get('/products/{id}/restore', [ProductController::class, 'restore']);
        Route::get('/products/{id}/destroy', [ProductController::class, 'destroy']);
    });
});
