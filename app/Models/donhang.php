<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hang';

  public function user() {
    return $this->belongsTo(User::class, 'user_id');
}
public function chiTiet() {
    return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
}
}