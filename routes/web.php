<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', [ProductController::class, 'welcome'])->middleware('redirect.admin')->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', function () { return 'Admin Product Create Page'; })->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/customers', [AdminDashboardController::class, 'adminCustomersIndex'])->name('customers.index');
    });

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('customer.dashboard');
        })->name('dashboard');
    });


Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect('/');
    }

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'customer') {
        return redirect()->route('customer.dashboard');
    }

    return redirect('/');
})->middleware('auth')->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/products', [ProductController::class, 'index'])->middleware('redirect.admin')->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// API-like routes for admin product management
Route::get('/api/products/{product}', [AdminProductController::class, 'show']);
Route::patch('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
