<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\buyer\BuyerController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\seller\PenjualController;
use App\Http\Controllers\buyer\AuthBuyerController;
use App\Http\Controllers\seller\AuthSellerController;

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

Route::get('/', [AuthBuyerController::class, 'viewLogin'])->name('buyer.login.view')->middleware('guest');

// Auth::routes();

// login
Route::prefix('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('auth.index')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/reload-captcha', [AuthController::class, 'reloadCaptcha'])->name('reload-captcha')->middleware('guest');
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
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/{user}/get', [UserController::class, 'get'])->name('admin.users.get');
        Route::put('/{user}/update', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{user}/delete', [UserController::class, 'delete'])->name('admin.users.delete');
        // log-activity
        Route::get('/log-activities', [LogActivityController::class, 'index'])->name('admin.users.log');
    });

    // products
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/{product}/update', [ProductController::class, 'update'])->name('admin.product.update');
        Route::get('/{product}/detail', [ProductController::class, 'detail'])->name('admin.product.detail');
        Route::delete('/{product}/delete', [ProductController::class, 'delete'])->name('admin.product.delete');
        Route::get('/import-products', [ProductController::class, 'importProduct'])->name('modal.import.product');
    });

    // seller
    Route::prefix('sellers')->group(function () {
        Route::get('/', [SellerController::class, 'index'])->name('admin.seller.index');
        Route::get('/create', [SellerController::class, 'create'])->name('admin.seller.create');
        Route::post('/', [SellerController::class, 'store'])->name('admin.seller.store');
        Route::get('/{seller}/edit', [SellerController::class, 'edit'])->name('admin.seller.edit');
        Route::put('/{seller}/update', [SellerController::class, 'update'])->name('admin.seller.update');
        Route::get('/{seller}/detail', [SellerController::class, 'detail'])->name('admin.seller.detail');
        Route::delete('/{seller}/delete', [SellerController::class, 'delete'])->name('admin.seller.delete');
    });

    // transaksi
    Route::prefix('transaction')->group(function () {
        Route::get('/', [HistoryController::class, 'index'])->name('admin.transactions.index');
        Route::get('/{transaction}/detail', [HistoryController::class, 'detail'])->name('admin.transactions.detail');
    });

    // pdf
    Route::prefix('pdf')->group(function () {
        Route::get('/transaction', [PdfController::class, 'PdfHistoryTransactions'])->name('pdf.transaction');
        Route::get('/payment', [PdfController::class, 'PdfHistoryPayments'])->name('pdf.payments');
        Route::get('/product', [PdfController::class, 'PdfProduct'])->name('pdf.product');
        Route::get('/seller', [PdfController::class, 'PdfSeller'])->name('pdf.seller');
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
        Route::get('/seller-export', [ExcelController::class, 'sellerExport'])->name('excel.export.seller');
        // download template excel
        Route::get('/template-product', function () {
            return response()->download(public_path('template-import/template-product.xlsx'));
        })->name('download.template.product');
        // import
        Route::post('/product-import', [ExcelController::class, 'productImport'])->name('excel.import.product');
    });

    // recycle bin
    Route::prefix('recycle')->group(function () {
        // users
        Route::get('/users', [UserController::class, 'indexRestore']);
        Route::get('/users-json', [UserController::class, 'showAllDeleted']);
        Route::get('/users/{id}/restore', [UserController::class, 'restore']);
        Route::get('/users/{id}/destroy', [UserController::class, 'destroy']);

        // products
        Route::get('/products', [ProductController::class, 'indexRestore']);
        Route::get('/products-json', [ProductController::class, 'showRestore']);
        Route::get('/products/{id}/restore', [ProductController::class, 'restore']);
        Route::get('/products/{id}/destroy', [ProductController::class, 'destroy']);
    });
});

Route::prefix('buyer')->group(function () {
    Route::prefix('auth')->group(function () {
        // login
        Route::post('/login', [AuthBuyerController::class, 'login'])->name('buyer.login')->middleware('guest');
        // daftar
        Route::get('/daftar', [AuthBuyerController::class, 'viewRegister'])->name('buyer.register.view')->middleware('guest');
        Route::post('/register', [AuthBuyerController::class, 'register'])->name('buyer.register')->middleware('guest');
        Route::get('/verify/{username}', [AuthBuyerController::class, 'viewOtp'])->name('buyer.otp.view')->middleware('guest');
        Route::post('/verify', [AuthBuyerController::class, 'verifyOtp'])->name('buyer.otp')->middleware('guest');
        // login google
        Route::get('/google/redirect', 'Auth\Buyer\SocialiteController@redirect')->name('buyer.google.redirect')->middleware('guest');
        Route::get('/google/callback', 'Auth\Buyer\SocialiteController@callback')->name('buyer.google.callback')->middleware('guest');
        // logout
        Route::get('/logout', [AuthBuyerController::class, 'logout'])->name('buyer.logout');
        // ubah password
        Route::post('/change-password', [AuthBuyerController::class, 'changePassword'])->name('buyer.changePassword');
        // lupa password
        Route::get('forgot-password', 'Auth\Buyer\AuthController@viewForgotPassword')->name('buyer.forgotPassword.view');
        Route::post('forgot-password', 'Auth\Buyer\AuthController@sendResetLink')->name('buyer.forgotPassword.email');
        Route::get('reset-password/{token}', 'Auth\Buyer\AuthController@showResetForm')->name('buyer.forgotPassword.reset');
        Route::post('reset-password', 'Auth\Buyer\AuthController@resetPassword')->name('buyer.forgotPassword.update');
    });

    Route::prefix('cart')->group(function () {
        Route::get('/my-cart', [CartController::class, 'index'])->name('buyer.cart.index')->middleware('auth.buyer');
        Route::post('/my-cart', [CartController::class, 'store'])->name('buyer.cart.store')->middleware('auth.buyer');
        Route::post('/my-cart/update-quantity', [CartController::class, 'updateQuantity'])->name('buyer.cart.updateQuantity')->middleware('auth.buyer');
        Route::delete('/my-cart/{id}', [CartController::class, 'destroy'])->name('buyer.cart.remove')->middleware('auth.buyer');
    });

    Route::prefix('transaction')->group(function () {
        Route::get('/pre-checkout', [TransactionController::class, 'preCheckout'])->name('buyer.buy.now')->middleware('auth.buyer');
        Route::post('/checkout', [TransactionController::class, 'checkoutBuyer'])->name('buyer.checkout')->middleware('auth.buyer');
    });

    Route::get('/', [BuyerController::class, 'index'])->name('buyer.index')->middleware('auth.buyer');
    Route::get('/search-product', [BuyerController::class, 'searchProduct'])->name('buyer.product.search')->middleware('auth.buyer');
    Route::get('/detail-produk/{slug}', [BuyerController::class, 'detailProduct'])->name('buyer.product.detail')->middleware('auth.buyer');
    Route::get('/search-seller', [PenjualController::class, 'searchSeller'])->name('buyer.seller.search');
    Route::get('/my-profile', [BuyerController::class, 'indexProfile'])->name('buyer.profile')->middleware('auth.buyer');
    Route::get('/my-history-payment', [BuyerController::class, 'indexHistoryPayment'])->name('buyer.history')->middleware('auth.buyer');
});

Route::prefix('seller')->group(function () {
    Route::prefix('auth')->group(function () {
        // login
        Route::get('/login-as-seller', [AuthSellerController::class, 'viewLogin'])->name('seller.loginView');
        Route::post('/login', [AuthSellerController::class, 'login'])->name('seller.login');
        // logout
        Route::get('/logout', [AuthSellerController::class, 'logout'])->name('seller.logout');
    });

    Route::get('/', [PenjualController::class, 'index'])->name('seller.index');
});
