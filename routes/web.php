<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SachController4;
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
    
    // --- THÊM SÁCH ---
    Route::get('/themsach', [SachController4::class, 'trangThemSach'])->name('admin.themsach');
    Route::post('/themsach', [SachController4::class, 'luuSach'])->name('admin.themsach.submit');

    // --- SỬA SÁCH (Đường dẫn này sẽ giải quyết cái lỗi đỏ lòm lúc nãy) ---
    Route::get('/sach/edit/{id}', [SachController4::class, 'trangSuaSach'])->name('admin.sach.edit');
    Route::post('/sach/edit/{id}', [SachController4::class, 'capNhatSach'])->name('admin.sach.update');

    // --- XÓA SÁCH ---
    Route::get('/sach/delete/{id}', [SachController4::class, 'xoaMemSach'])->name('admin.sach.delete');
    
    // --- DANH SÁCH & LỌC THỂ LOẠI ---
    // QUAN TRỌNG: Route có đuôi {id_theloai?} luôn phải nằm ở ĐÁY của group này
    Route::get('/theloai', [SachController4::class, 'trangQuanLyTheLoai'])->name('admin.theloai');

   
    Route::get('/sach/{id_theloai?}', [SachController4::class, 'trangQuanLySach'])->name('admin.sach');

    // Thêm thể loại
    Route::get('/theloai/create', [SachController4::class, 'trangThemTheLoai'])->name('admin.theloai.create');
    Route::post('/theloai/store', [SachController4::class, 'luuTheLoai'])->name('admin.theloai.store');
    
    // Sửa thể loại
    Route::get('/theloai/edit/{id}', [SachController4::class, 'trangSuaTheLoai'])->name('admin.theloai.edit');
    Route::post('/theloai/update/{id}', [SachController4::class, 'capNhatTheLoai'])->name('admin.theloai.update');
    
    // Xóa (mềm) thể loại
    Route::get('/theloai/delete/{id}', [SachController4::class, 'xoaTheLoai'])->name('admin.theloai.delete');

});
    // Quản lý User: http://127.0.0.1:8000/admin/user
    Route::get('/user', [UserController::class, 'index'])->name('sys.user.index');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('sys.user.revoke');

    // Quản lý Đơn hàng: http://127.0.0.1:8000/admin/donhang
    Route::get('/donhang', [DonHangController::class, 'index'])->name('admin.donhang.index');
    Route::post('/donhang/update/{id}', [DonHangController::class, 'update'])->name('admin.donhang.update');

use App\Http\Controllers\DashboardController;

Route::get('/admin/index', [App\Http\Controllers\DashboardController::class, 'index'])
    ->name('admin.index')
    ->middleware(['web', 'auth']); 
use App\Http\Controllers\DanhGiaController;

Route::get('/admin/danhgia', [DanhGiaController::class, 'index'])->name('admin.danhgia.index');
Route::get('/admin/danhgia/{id}/duyet', [DanhGiaController::class, 'duyet'])->name('admin.danhgia.duyet');
Route::get('/admin/danhgia/{id}/tu-choi', [DanhGiaController::class, 'tuchoi'])->name('admin.danhgia.tuchoi');
Route::get('/admin/danhgia/{id}/xoa', [DanhGiaController::class, 'xoa'])->name('admin.danhgia.xoa');
