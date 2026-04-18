<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_don_hang';

    // Bảng này thường không có updated_at nên tắt timestamps để tránh lỗi
    public $timestamps = false; 

    protected $guarded = [];

    // Liên kết với bảng sách để lấy tên và hình ảnh sách
    public function sach()
    {
        return $this->belongsTo(Sach::class, 'sach_id', 'id');
    }
}