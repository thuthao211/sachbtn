<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonHangController;

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



Route::prefix('admin')->group(function () {
    
    // Quản lý User: http://127.0.0.1:8000/admin/user
    Route::get('/user', [UserController::class, 'index'])->name('sys.user.index');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('sys.user.revoke');

    // Quản lý Đơn hàng: http://127.0.0.1:8000/admin/donhang
    Route::get('/donhang', [DonHangController::class, 'index'])->name('admin.donhang.index');
    Route::post('/donhang/update/{id}', [DonHangController::class, 'update'])->name('admin.donhang.update');
});