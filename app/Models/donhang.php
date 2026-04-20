<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hang';

    // ✅ THÊM ĐOẠN NÀY
    protected $fillable = [
        'user_id',
        'tong_tien',
        'thanh_toan',
        'trang_thai',
        'ten_nguoi_nhan',
        'so_dien_thoai',
        'dia_chi_giao',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chiTiet() {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
    }
}