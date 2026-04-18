<?php
namespace App\Http\Controllers;

use App\Models\DonHang;
use Illuminate\Http\Request;

class DonHangController extends Controller
{
   public function index(Request $request)
{
    $query = \App\Models\DonHang::with('user');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('id', 'like', "%{$search}%")
              ->orWhereHas('user', function($u) use ($search) {
                  $u->where('name', 'like', "%{$search}%");
              });
        });
    }

    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Lấy dữ liệu và phân trang
    $donhangs = $query->latest()->paginate(10);
    $donhangs->appends($request->all());

    return view('admin.donhang.index', compact('donhangs'));
}

public function update(Request $request, $id)
{
    $dh = \App\Models\DonHang::findOrFail($id);
    $dh->trang_thai = $request->trang_thai;
    $dh->save();
    
    // Chuyển hướng kèm thông báo
    return back()->with('thongbao', 'Đã cập nhật trạng thái đơn hàng!');
}
}