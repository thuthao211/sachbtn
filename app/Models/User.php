<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Cho phép insert dữ liệu (fix lỗi của bạn)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',          
        'dia_chi',        
        'ten_ngan_hang',  
        'stk_ngan_hang',  
        'vi_dien_tu',
        'vi_dien_tu_sdt'
    ];

    /**
     * Ẩn dữ liệu nhạy cảm
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ép kiểu dữ liệu
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}