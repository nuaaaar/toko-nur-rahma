<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Export;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('guest')->group(function()
{
    Route::get('/', function () {
        return redirect()->route(auth()->check() ? 'dashboard.index' : 'login');
    });

    Route::get('login', [Auth\LoginController::class, 'index']);

    Route::post('login', [Auth\LoginController::class, 'login'])->name('login');

    Route::get('forgot-password', [Auth\ForgotPasswordController::class, 'index'])->name('password.request');

    Route::post('forgot-password', [Auth\ForgotPasswordController::class, 'sentResetLinkEmail'])->name('password.email');

    Route::get('reset-password/{token}', [Auth\ResetPasswordController::class, 'index'])->name('password.reset');

    Route::post('reset-password', [Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});


Route::middleware('auth')->group(function()
{
    Route::get('logout', [Auth\LoginController::class, 'logout'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('dashboard')->name('dashboard.')->group(function()
    {
        Route::resource('backup-data', Dashboard\BackupDataController::class)->only('index');

        Route::resource('bank', Dashboard\BankController::class);

        Route::resource('customer', Dashboard\CustomerController::class);

        Route::resource('customer-return', Dashboard\CustomerReturnController::class);

        Route::resource('delivery-order', Dashboard\DeliveryOrderController::class);

        Route::resource('procurement', Dashboard\ProcurementController::class);

        Route::resource('product', Dashboard\ProductController::class);

        Route::resource('product-stock', Dashboard\ProductStockController::class);

        Route::resource('profit-loss', Dashboard\ProfitLossController::class)->only('index');

        Route::resource('purchase-order', Dashboard\PurchaseOrderController::class);

        Route::prefix('purchase-order/{purchase_order}')->name('purchase-order.')->group(function()
        {
            Route::put('change-status', Dashboard\PurchaseOrderChangeStatusController::class)->name('change-status');
        });

        Route::resource('role-and-permission', Dashboard\RoleAndPermissionController::class);

        Route::resource('sale', Dashboard\SaleController::class);

        Route::resource('stock-opname', Dashboard\StockOpnameController::class);

        Route::resource('supplier', Dashboard\SupplierController::class);

        Route::resource('user', Dashboard\UserController::class);
    });

    Route::prefix('export')->name('export.')->group(function()
    {
        Route::get('customer-return', Export\CustomerReturnExportController::class)->name('customer-return');

        Route::get('procurement', Export\ProcurementExportController::class)->name('procurement');

        Route::get('product', Export\ProductExportController::class)->name('product');

        Route::get('purchase-order', Export\PurchaseOrderExportController::class)->name('purchase-order');

        Route::get('sale', Export\SaleExportController::class)->name('sale');

        Route::get('stock-opname', Export\StockOpnameExportController::class)->name('stock-opname');
    });
});

