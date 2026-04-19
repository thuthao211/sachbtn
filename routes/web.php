<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
Route::get('/', [HomeController::class, 'index']);

Route::get('/index', function () {
    return view('sach.index');
})->middleware(['auth', 'verified'])->name('index');

Route::get('/chitiet/{id}', [BookController::class, 'chitietsach'])->name('sach.details');
Route::post('/them-gio-hang', [BookController::class, 'cartadd'])->name('cartadd');
Route::middleware(['auth'])->group(function () {
    Route::get('/giohang', [BookController::class, 'order'])->name('order');
    Route::post('/cart/delete', [BookController::class, 'cartdelete'])->name('cartdelete');
    Route::post('/order/create', [BookController::class, 'ordercreate'])->name('ordercreate');
    Route::post('/sach/danhgia', [BookController::class, 'danhgia'])->name('book.rate');
    
});