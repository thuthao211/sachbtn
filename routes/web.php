<?php

use App\Http\Controllers\HomeController;
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

require __DIR__.'/auth.php';


use App\Http\Controllers\UserController;
use App\Http\Controllers\DonHangController;

Route::prefix('admin')->group(function () {
    
    // Quản lý User
    Route::get('user', [UserController::class, 'index'])->name('sys.user.index');
    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('sys.user.revoke');

    // Quản lý Đơn hàng
    Route::get('donhang', [DonHangController::class, 'index'])->name('sys.order.index');
    Route::put('donhang/{id}', [DonHangController::class, 'update'])->name('sys.order.update');
    
});