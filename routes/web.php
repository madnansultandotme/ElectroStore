<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Static pages
Route::view('/about', 'about')->name('about');
Route::view('/articles', 'articles')->name('articles');
Route::view('/contact', 'contact')->name('contact');

// Authenticated user dashboard (accessible to all authenticated users)
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Authenticated user routes (user-only features)
Route::middleware(['auth', 'blockadmin'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::resource('/admin/products', AdminProductController::class)->names('admin.products');
    Route::resource('/admin/categories', AdminCategoryController::class)->names('admin.categories');
    Route::resource('/admin/orders', AdminOrderController::class)->names('admin.orders');
    
    // Additional order management routes
    Route::patch('/admin/orders/{order}/notes', [AdminOrderController::class, 'updateNotes'])->name('admin.orders.notes');
    
    // Admin reports
    Route::get('/admin/reports', [App\Http\Controllers\Admin\AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/sales', [App\Http\Controllers\Admin\AdminReportController::class, 'sales'])->name('admin.reports.sales');
    Route::get('/admin/reports/inventory', [App\Http\Controllers\Admin\AdminReportController::class, 'inventory'])->name('admin.reports.inventory');
    Route::get('/admin/reports/customers', [App\Http\Controllers\Admin\AdminReportController::class, 'customers'])->name('admin.reports.customers');
    Route::get('/admin/reports/products', [App\Http\Controllers\Admin\AdminReportController::class, 'products'])->name('admin.reports.products');
});

require __DIR__.'/auth.php';
