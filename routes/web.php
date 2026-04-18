<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController; 
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/index', function () {
    return view('sach.index');
})->middleware(['auth', 'verified'])->name('index');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/index', function () {
        return view('admin.index');
    })->name('admin.index');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('tai-khoan')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('profile');
        Route::post('/cap-nhat-thong-tin', [AccountController::class, 'updateProfile'])->name('update');
        Route::post('/doi-mat-khau', [AccountController::class, 'updatePassword'])->name('password');
        Route::get('/don-hang', [AccountController::class, 'orders'])->name('orders');
        Route::get('/don-hang/{id}', [AccountController::class, 'orderDetail'])->name('order_detail');
    });
});

require __DIR__.'/auth.php';