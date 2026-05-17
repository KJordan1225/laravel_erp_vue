<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('customers', CustomerController::class);
    Route::get('/api/customers-list', [CustomerController::class, 'list'])
    ->name('customers.list');
    Route::resource('vendors', VendorController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('sales-orders', SalesOrderController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('expenses', ExpenseController::class);

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/company-settings', [CompanySettingController::class, 'edit'])
        ->name('company-settings.edit');

    Route::put('/company-settings', [CompanySettingController::class, 'update'])
        ->name('company-settings.update');

    Route::get('/profile', [UserProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [UserProfileController::class, 'update'])
        ->name('profile.update');
});

require __DIR__.'/auth.php';
