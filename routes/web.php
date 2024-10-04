<?php

use App\Mail\TestEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TesController;
// use Intervention\Image\Laravel\Facades\Image;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\AddUserController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecycleController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LogActivityController;

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

Route::get('/', [LoginController::class, 'index']);

Auth::routes();

Route::prefix('admin')->middleware(['is_admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            ''
        ]);
    });

    // users
    Route::prefix('users')->group(function () {
        // menggunakan ajax
        Route::get('/users', [UsersController::class, 'indexUsers']);
        Route::get('/create', [UsersController::class, 'create']);
        Route::get('/users-json', [UsersController::class, 'showAll']);
        Route::get('/users/{id}/edit', [UsersController::class, 'editUser2']);
        Route::post('/users', [UsersController::class, 'store']);
        Route::delete('/users/{id}', [UsersController::class, 'deleteUserAjax']);
        Route::put('/users/{id}', [UsersController::class, 'updateUser2']);
        // log-activity
        Route::get('/log-activities', [LogActivityController::class, 'showAll']);
        // excel

    });

    // quotes
    Route::prefix('products')->group(function () {
        // kelola products
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/create-products', [ProductController::class, 'showFormCreate']);
        Route::get('/products/{id}/edit', [ProductController::class, 'editproduct']);
    });

    // // recycle bin
    Route::prefix('recycle')->group(function () {
        // users
        Route::get('/users', [RecycleController::class, 'indexUsers']);
        Route::get('/users-json', [RecycleController::class, 'showAll']);
        Route::get('/users/{id}/restore', [RecycleController::class, 'restore']);
        Route::get('/users/{id}/destroy', [RecycleController::class, 'destroy']);

        // products
        Route::get('/products', [ProductController::class, 'indexRecycle']);
        Route::get('/products-json', [ProductController::class, 'showAllRecycle']);
        Route::get('/products/{id}/restore', [ProductController::class, 'restore']);
        Route::get('/products/{id}/destroy', [ProductController::class, 'destroy']);
    });
});

// login
Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/logout', [LoginController::class, 'logout']);
});


// example
Route::get('/blank', function () {
    notify()->success('Laravel Notify is awesome!');
    return view('blankExample');
});

Route::get('/tables', function () {
    return view('tableExample');
});

Route::prefix('pdf')->group(function () {
    Route::get('/generate-pdf-users-data', [PDFController::class, 'generatePDFUser']);
    Route::get('/generate-pdf-logs-data', [PDFController::class, 'generatePDFLog']);
});

Route::prefix('excel')->group(function () {
    Route::get('/export-users', [UsersController::class, 'export']);
    Route::get('/download-template-users', [UsersController::class, 'downloadTemplate']);
    Route::post('/import-users', [UsersController::class, 'import']);
});

// Route::get('/tes', function () {
//     // notify()->success('Laravel Notify is awesome!');
//     // drakify('success');
//     // smilify('success', 'You are successfully reconnected');
//     return view('tes');
// });

// tess
Route::get('/tes', [TesController::class, 'indexGenerate'])->name('code.index');
Route::post('/generate-nim', [TesController::class, 'generateNim'])->name('code.generate');
Route::get('/ranking-json', [TesController::class, 'ranking']);
Route::get('/api-quran', [TesController::class, 'fetchData']);
Route::get('/checkout-v1', [TesController::class, 'checkOutV1']);
Route::get('/tespdf123', [ProductController::class, 'checkOutV1']);


// cashier
Route::get('/cashier', [CashierController::class, 'index'])->name('cashier.index');
Route::post('/cashier', [CashierController::class, 'store'])->name('cashier.store');

// Route::get('/generate-nim', [UsersController::class, 'generateCode']);

Route::get('/tesgambar', function () {
    $image = Image::read('public/storage/galih.png');
});


Route::get('/send-test-email', function () {
    $details = [
        'title' => 'Test Email from Laravel',
        'body' => 'This is a test email to confirm SMTP configuration.'
    ];

    $emailUser = 'amandadmyntii@gmail.com';
    $emailUser2 = 'newhanif743@gmail.com';

    Mail::to($emailUser2)->send(new \App\Mail\TestEmail($details));
    return 'Email has been sent!';
});
