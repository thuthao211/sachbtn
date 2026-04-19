<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    // Xử lý cập nhật thông tin người dùng (Đã bổ sung Ngân hàng & Ví)
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|numeric',
            'dia_chi' => 'nullable|string|max:255',
            // Thêm validate nhẹ cho ngân hàng nếu cần
            'stk_ngan_hang' => 'nullable|numeric', 
        ]);

        $user = User::find(Auth::id());
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dia_chi' => $request->dia_chi,
            // BỔ SUNG LƯU CÁC TRƯỜNG NGÂN HÀNG Ở ĐÂY
            'ten_ngan_hang' => $request->ten_ngan_hang,
            'stk_ngan_hang' => $request->stk_ngan_hang,
            'vi_dien_tu' => $request->vi_dien_tu,
            'vi_dien_tu_sdt' => $request->vi_dien_tu_sdt,
        ]);

        return back()->with('success_profile', 'Cập nhật thông tin thành công!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed|different:current_password', 
        ], [
            'new_password.different' => 'Mật khẩu mới phải khác với mật khẩu hiện tại.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp.'
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success_password', 'Đổi mật khẩu thành công!');
    }

    public function orders()
    {
        $orders = DonHang::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('account.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = DonHang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $details = ChiTietDonHang::with('sach')->where('don_hang_id', $id)->get();
        
        return view('account.order_detail', compact('order', 'details'));
    }
    public function cancelOrder($id)
{
    $order = DonHang::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    // ❌ Không cho hủy nếu không phải "chờ xác nhận"
    if ($order->trang_thai !== 'cho_xac_nhan') {
        return back()->with('error', 'Chỉ được hủy đơn khi đang chờ xác nhận!');
    }

    // ✅ cập nhật trạng thái
    $order->update([
        'trang_thai' => 'da_huy'
    ]);

    return back()->with('success', 'Đã hủy đơn hàng thành công!');
}
}