<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    // Chỉ định tên bảng chính xác trong database
    protected $table = 'don_hang'; 

    // Cho phép lưu dữ liệu vào các cột
    protected $guarded = []; 

    // Báo Laravel bảng có cột created_at (thời gian tạo)
    public $timestamps = true; 
}