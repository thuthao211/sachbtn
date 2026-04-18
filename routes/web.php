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

Route::get('/', [HomeController::class, 'index']);
Route::get('/sach/theloai/{id}', [HomeController::class, 'theLoai']);
Route::get('/timkiem', [HomeController::class, 'search']);
require __DIR__.'/auth.php';
use App\Http\Controllers\DashboardController;

Route::get('/admin/index', [App\Http\Controllers\DashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware(['web', 'auth']); 
use App\Http\Controllers\DanhGiaController;

Route::get('/admin/danhgia', [DanhGiaController::class, 'index'])->name('admin.danhgia.index');
Route::get('/admin/danhgia/{id}/duyet', [DanhGiaController::class, 'duyet'])->name('admin.danhgia.duyet');
Route::get('/admin/danhgia/{id}/tu-choi', [DanhGiaController::class, 'tuchoi'])->name('admin.danhgia.tuchoi');
Route::get('/admin/danhgia/{id}/xoa', [DanhGiaController::class, 'xoa'])->name('admin.danhgia.xoa');