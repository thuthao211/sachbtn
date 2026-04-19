<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use Illuminate\Http\Request;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        // 1. Khởi tạo query lấy kèm thông tin user (liên kết bảng)
        $query = \App\Models\DonHang::with('user');

        // 2. Xử lý tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 3. Lọc theo ngày
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // 4. Phân trang
        $donhangs = $query->latest()->paginate(10);
        $donhangs->appends($request->all());

        // 5. Trả về VIEW (Laravel sẽ tìm file ở resources/views/admin/quan-ly-don-hang.blade.php)
        return view('admin.quan-ly-don-hang', compact('donhangs'));
    }

    public function update(Request $request, $id)
    {
        $dh = \App\Models\DonHang::findOrFail($id);
        $dh->trang_thai = $request->trang_thai;
        $dh->save();
        
        return back()->with('thongbao', 'Đã cập nhật trạng thái đơn hàng!');
    }
}