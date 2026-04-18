<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DanhGiaController extends Controller
{
    public function index()
    {
        $danhgia = DB::table('danh_gia as dg')
            ->join('sach as s', 'dg.sach_id', '=', 's.id')
            ->join('users as u', 'dg.user_id', '=', 'u.id') 
            ->select(
                'dg.id', 
                'dg.diem as diem_so', 
                'dg.noi_dung', 
                'dg.trang_thai',     
                'dg.created_at as ngay_tao', 
                's.ten_sach', 
                'u.name as ho_ten'
            ) 
            ->orderByRaw("FIELD(dg.trang_thai, 'cho_duyet') DESC")
            ->orderBy('dg.created_at', 'DESC') 
            ->get();

        return view('admin.danhgia', compact('danhgia'));
    }

    public function duyet($id)
    {
        DB::table('danh_gia')->where('id', $id)->update(['trang_thai' => 'da_duyet']);
        return redirect()->route('admin.danhgia.index')->with('success', 'Đã duyệt đánh giá!');
    }

    public function tuchoi($id)
    {
        DB::table('danh_gia')->where('id', $id)->update(['trang_thai' => 'tu_choi']);
        return redirect()->route('admin.danhgia.index')->with('success', 'Đã từ chối đánh giá!');
    }

    public function xoa($id)
    {
        DB::table('danh_gia')->where('id', $id)->delete();
        return redirect()->route('admin.danhgia.index')->with('success', 'Đã xóa đánh giá!');
    }
}