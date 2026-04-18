<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController; 
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

Route::middleware(['auth'])->group(function () {
    Route::prefix('user/taikhoan')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('profile');
        Route::post('/cap-nhat-thong-tin', [AccountController::class, 'updateProfile'])->name('update');
        Route::post('/doi-mat-khau', [AccountController::class, 'updatePassword'])->name('password');
        Route::get('/don-hang', [AccountController::class, 'orders'])->name('orders');
        Route::get('/don-hang/{id}', [AccountController::class, 'orderDetail'])->name('order_detail');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin/taikhoan')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('profile');
        Route::post('/cap-nhat-thong-tin', [AccountController::class, 'updateProfile'])->name('update');
        Route::post('/doi-mat-khau', [AccountController::class, 'updatePassword'])->name('password');
        Route::get('/don-hang', [AccountController::class, 'orders'])->name('orders');
        Route::get('/don-hang/{id}', [AccountController::class, 'orderDetail'])->name('order_detail');
    });
});

require __DIR__.'/auth.php';
Route::get('/', [HomeController::class, 'index']);
Route::get('/sach/theloai/{id}', [HomeController::class, 'theLoai']);
Route::get('/timkiem', [HomeController::class, 'search']);
require __DIR__.'/auth.php';



Route::prefix('admin')->group(function () {
    
    // Quản lý User: http://127.0.0.1:8000/admin/user
    Route::get('/user', [UserController::class, 'index'])->name('sys.user.index');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('sys.user.revoke');

    // Quản lý Đơn hàng: http://127.0.0.1:8000/admin/donhang
    Route::get('/donhang', [DonHangController::class, 'index'])->name('admin.donhang.index');
    Route::post('/donhang/update/{id}', [DonHangController::class, 'update'])->name('admin.donhang.update');
});
use App\Http\Controllers\DashboardController;

Route::get('/admin/index', [App\Http\Controllers\DashboardController::class, 'index'])
    ->name('admin.index')
    ->middleware(['web', 'auth']); 
use App\Http\Controllers\DanhGiaController;

Route::get('/admin/danhgia', [DanhGiaController::class, 'index'])->name('admin.danhgia.index');
Route::get('/admin/danhgia/{id}/duyet', [DanhGiaController::class, 'duyet'])->name('admin.danhgia.duyet');
Route::get('/admin/danhgia/{id}/tu-choi', [DanhGiaController::class, 'tuchoi'])->name('admin.danhgia.tuchoi');
Route::get('/admin/danhgia/{id}/xoa', [DanhGiaController::class, 'xoa'])->name('admin.danhgia.xoa');
