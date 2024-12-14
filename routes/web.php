<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InterestController;
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
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/reload-captcha',[AuthController::class, 'reloadCaptcha'])->name('reload-captcha');
});

Route::prefix('admin')->middleware(['is_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/modal-whatsapp/{id}', [DashboardController::class, 'modalSendMessage'])->name('modal.send.whatsapp');

    // notes
    Route::prefix('notes')->group(function () {
        Route::get('/modal-create/{id}', [DashboardController::class, 'modalNotes'])->name('modal.create.notes');
    });

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
        Route::get('/import-products', [ProductController::class, 'importProduct'])->name('modal.import.product');
    });

    //
    Route::prefix('transaction')->group(function () {
        // riwayat transaksi
        Route::get('/transaction', [HistoryController::class, 'indexTransaction'])->name('index.transaction');
        Route::get('/{id}/detail', [HistoryController::class, 'getDetailTransaction'])->name('transaction.detail');
        // riwayat pembayaran
        Route::get('/payments', [HistoryController::class, 'indexPayment'])->name('index.payments');
        Route::get('/{id}/detail-payment', [HistoryController::class, 'getDetailPayment'])->name('payment.detail');
        // kelola bunga
        Route::get('/interest', [InterestController::class, 'index']);
        Route::get('/create-interest', [InterestController::class, 'create']);
    });

    // pdf
    Route::prefix('pdf')->group(function () {
        Route::get('/transaction', [PdfController::class, 'PdfHistoryTransactions'])->name('pdf.transaction');
        Route::get('/payment', [PdfController::class, 'PdfHistoryPayments'])->name('pdf.payments');
        Route::get('/product', [PdfController::class, 'PdfProduct'])->name('pdf.product');
        Route::get('/user', [PdfController::class, 'PdfUser'])->name('pdf.user');
        Route::get('/log-activity', [PdfController::class, 'PdfLog'])->name('pdf.log');
    });

    // excel
    Route::prefix('excel')->group(function () {
        // export
        Route::get('/transaction-export', [ExcelController::class, 'transactionExport'])->name('excel.export.transaction');
        Route::get('/payments-export', [ExcelController::class, 'paymentsExport'])->name('excel.export.payment');
        Route::get('/product-export', [ExcelController::class, 'productExport'])->name('excel.export.product');
        Route::get('/user-export', [ExcelController::class, 'userExport'])->name('excel.export.user');
        Route::get('/log-activity-export', [ExcelController::class, 'logActivityExport'])->name('excel.export.log-activity');
        // download template excel
        Route::get('/template-product', function () {
            return response()->download(public_path('template-import/template-product.xlsx'));
        })->name('download.template.product');
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

// tes
Route::get('/tesWa', [TesController::class, 'tesWa']);

