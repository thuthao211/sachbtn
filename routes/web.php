<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SachController4;

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