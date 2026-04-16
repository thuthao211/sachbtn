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
