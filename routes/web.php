<?php

declare(strict_types=1);

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('products.index');
    })->name('dashboard');

    // Admin endpoints (define specific ones like 'create' before wildcard show route)
    Route::middleware('role:admin')->group(function () {
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Read-only catalog endpoints open to all authenticated users
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
