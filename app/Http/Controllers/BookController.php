<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccessNotification;
use App\Models\User;

class BookController extends Controller
{
    public function chitietsach($id) {
        $sach = DB::table('sach')->where('id', $id)->first();
        $reviews = DB::table('danh_gia')
            ->join('users', 'danh_gia.user_id', '=', 'users.id')
            ->where('sach_id', $id)
            ->select('users.name', 'danh_gia.*')
            ->get();
        $categories = DB::table('dm_the_loai')->get();
        $canRate = false;
        if (Auth::check()) {
            $canRate = DB::table('don_hang')
                ->join('chi_tiet_don_hang', 'don_hang.id', '=', 'chi_tiet_don_hang.don_hang_id')
                ->where('don_hang.user_id', Auth::id())
                ->where('don_hang.trang_thai', 'da_giao')
                ->where('chi_tiet_don_hang.sach_id', $id)
                ->exists();
        }
        return view('sach.details', compact('sach', 'reviews', 'canRate', 'categories'));
    }
    public function cartadd(Request $request) {
        $id = $request->id;
        $num = (int)$request->num; 
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $cart[$id] += $num; 
        } else {
            $cart[$id] = $num;
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm vào giỏ!');
    }
    public function cartdelete(Request $request)
    {
        $id = $request->id;
        $cart = session('cart', []);
        if(isset($cart[$id])){
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
    public function order() {
        $categories = DB::table('dm_the_loai')->get();
        $cart = session()->get('cart', []);
        
        if(!empty($cart)) {
            $data = DB::table('sach')->whereIn('id', array_keys($cart))->get();
            $quantity = $cart;
        } else {
            $data = collect();
            $quantity = [];
        }
        return view('sach.order', [
            'data' => $data, 
            'quantity' => $quantity, 
            'categories' => $categories,
            'title' => 'Xác nhận đặt hàng'
        ]);
    }
    public function ordercreate(Request $request)
{
    $cart = session()->get('cart', []);
    if (empty($cart)) return redirect()->back();

    $orderId = DB::transaction(function () use ($request, $cart) {

        $books = DB::table('sach')
            ->whereIn('id', array_keys($cart))
            ->get();

        $tongTien = 0;
        $mailData = [];

        foreach ($books as $b) {
            if (!isset($cart[$b->id])) continue;

            $qty = $cart[$b->id];
            $tongTien += $b->gia * $qty;

            $mailData[] = [
                'ten_sach' => $b->ten_sach,
                'so_luong' => $qty,
                'don_gia' => $b->gia
            ];
        }

        // ✅ tạo đơn hàng + thông tin giao hàng
        $idDH = DB::table('don_hang')->insertGetId([
            'user_id' => Auth::id(),
            'tong_tien' => $tongTien,
            'thanh_toan' => $request->hinh_thuc_thanh_toan,
            'trang_thai' => 'cho_xac_nhan',

            // 🔥 thêm mới
            'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi_giao' => $request->dia_chi_giao,

            'created_at' => now(),
            'updated_at' => now()
        ]);

        // ✅ chi tiết đơn hàng
        foreach ($books as $b) {
            if (!isset($cart[$b->id])) continue;

            DB::table('chi_tiet_don_hang')->insert([
                'don_hang_id' => $idDH,
                'sach_id' => $b->id,
                'so_luong' => $cart[$b->id],
                'don_gia' => $b->gia,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // ✅ gửi mail
        try {
            Mail::to(Auth::user()->email)
                ->send(new OrderSuccessNotification($mailData));
        } catch (\Exception $e) {
            \Log::error($e->getMessage()); // không dd nữa
        }

        return $idDH;
    });

    session()->forget('cart');

    return redirect()->route('order')
        ->with('status', 'Đặt hàng thành công! Mã đơn: #' . $orderId);
}
    public function danhgia(Request $request) {

    $request->validate([
        'diem' => 'required|integer|min:1|max:5',
        'noi_dung' => 'required|min:3'
    ]);

    DB::table('danh_gia')->insert([
        'sach_id' => $request->sach_id,
        'user_id' => Auth::id(),
        'diem' => $request->diem,
        'noi_dung' => $request->noi_dung,
        'created_at' => now()
    ]);

    return redirect()->back()->with('status', 'Cảm ơn bạn đã đánh giá!');
}
}