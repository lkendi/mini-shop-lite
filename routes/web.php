<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
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
        Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::patch('/customers/{customer}', [AdminCustomerController::class, 'update'])->name('customers.update');
    });

use App\Services\CartService;

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', function (CartService $cartService) {
            $cart = $cartService->all();
            return view('customer.dashboard', compact('cart'));
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
Route::get('/api/customers/{customer}', [AdminCustomerController::class, 'show']);
Route::get('/api/products/{product}', [AdminProductController::class, 'show']);
Route::patch('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

// Checkout & Orders
Route::post('/checkout', [CheckoutController::class, 'store'])->middleware(['auth'])->name('checkout.store');
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/complete', [AdminOrderController::class, 'complete'])->name('orders.complete');
    });
