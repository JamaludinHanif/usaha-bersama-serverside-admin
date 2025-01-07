<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
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
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/login', [AuthController::class, 'authenticateApi']);
    Route::post('/logout', [AuthController::class, 'logoutApi']);
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('product')->group(function () {
    Route::post('/all-product', [ProductController::class, 'showApi']);
    Route::post('/search-product', [ProductController::class, 'searchProduct']);
    Route::get('/detail-product', [ProductController::class, 'detailApi']);
    Route::post('/make-redeem-code', [ProductController::class, 'addRedeemCode']);
    Route::post('/redeem-code', [ProductController::class, 'reedemCode']);
    Route::post('/my-cart', [UserController::class, 'myCart']);
});

// untuk user
Route::prefix('user')->group(function () {
    Route::get('/my-bill', [UserController::class, 'myBill']);
});

Route::prefix('transactions')->group(function () {
    // admin
    Route::get('/transactions-json', [HistoryController::class, 'getTransaction'])->name('index.transaction.json');
    Route::get('/payments-json', [HistoryController::class, 'getPayment'])->name('index.payments.json');
    // kelola bunga (admin)
    Route::get('/interest-json', [InterestController::class, 'showAll']);
    Route::post('/interest', [InterestController::class, 'store']);
    Route::delete('/interest/{id}', [InterestController::class, 'delete']);
    // kelola bunga (api)
    Route::get('/all-interest', [InterestController::class, "showAllApi"]);
    // user (api)
    Route::post('/pre-checkout', [TransactionController::class, 'preCheckout']);
    Route::post('/payment-cashier', [TransactionController::class, 'paymentCashier']);
    Route::get('/cek-status-payment', [TransactionController::class, 'cekStatusPayment']);
    Route::post('/payment-bill', [UserController::class, 'paymentBill']);
    // kasir (api)
    Route::get('/detail-payment', [TransactionController::class, 'getDataTransactionForCashier']);
    Route::post('/confirm-payment', [TransactionController::class, 'confirmPayment']);
});

Route::prefix('dashboard')->group(function () {
    Route::get('/stats-transaction', [DashboardController::class, 'transactionChart'])->name('chart.stats.transaction');
    Route::get('/weekly-income', [DashboardController::class, 'getWeeklyIncome'])->name('chart.weekly.income');
    Route::get('/top-product', [DashboardController::class, 'getTopSellingProducts'])->name('top.selling.product');

    // send message
    Route::post('/send-message', [DashboardController::class, 'sendMessage'])->name('send.message');

    // notes
    Route::prefix('notes')->group(function () {
        Route::get('/get-notes', [DashboardController::class, 'getNotes'])->name('get.notes');
        Route::post('/store', [DashboardController::class, 'storeNotes'])->name('store.notes');
    });
});

// Route::prefix('excel')->group(function () {
//     // import
//     Route::post('/product-import', [ExcelController::class, 'productImport'])->name('excel.import.product');
// });


Route::get('/export-invoice', [PdfController::class, 'exportInvoice']);
