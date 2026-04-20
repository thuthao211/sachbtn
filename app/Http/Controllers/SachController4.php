<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SachController4 extends Controller
{
    // ==========================================
    // 1. HIỂN THỊ DANH SÁCH (Sách mới thêm/mới sửa lên đầu)
    // ==========================================
    public function trangQuanLySach($id_theloai = null)
    {
        $danh_sach_the_loai = DB::table('dm_the_loai')->where('status', 1)->get();
        
        $query = DB::table('sach')->where('status', 1);

        // Lọc theo thể loại nếu có trên URL
        if ($id_theloai) {
            $query->where('dm_the_loai_id', $id_theloai);
        }

        // --- SỬA Ở ĐÂY ---
        // Đổi paginate(10) thành get() để DataTables có thể tự phân trang và tìm kiếm toàn bộ dữ liệu
        $danh_sach_sach = $query->orderBy('updated_at', 'desc')->get();

        return view('admin.quanlysach', [
            'danh_sach_sach' => $danh_sach_sach,
            'danh_sach_the_loai' => $danh_sach_the_loai,
            'id_theloai' => $id_theloai
        ]);
    }

    // ==========================================
    // 2. XÓA MỀM SÁCH
    // ==========================================
    public function xoaMemSach($id)
    {
        DB::table('sach')->where('id', $id)->update(['status' => 0]);
        return redirect()->route('admin.sach');
    }

    // ==========================================
    // 3. HIỂN THỊ TRANG THÊM SÁCH
    // ==========================================
    public function trangThemSach()
    {
        $danh_sach_the_loai = DB::table('dm_the_loai')->where('status', 1)->get();
        return view('admin.themsach', [
            'danh_sach_the_loai' => $danh_sach_the_loai
        ]);
    }

    // ==========================================
    // 4. LƯU SÁCH MỚI
    // ==========================================
    public function luuSach(Request $request)
    {
        $data = $request->except(['_token', '_method', 'hinh_anh']);

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/image'), $filename);
            $data['hinh_anh'] = $filename; 
        }

        foreach ($data as $key => $value) {
            if ($value === null || $value === '') {
                $data[$key] = null;
            }
        }

        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table('sach')->insert($data);

        return redirect()->route('admin.sach');
    }

    // ==========================================
    // 5. HIỂN THỊ TRANG CẬP NHẬT
    // ==========================================
    public function trangSuaSach($id)
    {
        $sach = DB::table('sach')->where('id', $id)->first();
        $danh_sach_the_loai = DB::table('dm_the_loai')->where('status', 1)->get();

        return view('admin.suasach', [
            'sach' => $sach,
            'danh_sach_the_loai' => $danh_sach_the_loai
        ]);
    }
    
    // ==========================================
    // 6. CẬP NHẬT SÁCH 
    // ==========================================
    public function capNhatSach(Request $request, $id)
    {
        $data = $request->except(['_token', '_method', 'hinh_anh']);

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/image'), $filename);
            $data['hinh_anh'] = $filename; 
        }

        foreach ($data as $key => $value) {
            if ($value === '') {
                $data[$key] = null;
            }
        }

        $data['updated_at'] = now();

        DB::table('sach')->where('id', $id)->update($data);

        return redirect()->route('admin.sach');
    }

    // ==========================================
    // 7. QUẢN LÝ THỂ LOẠI
    // ==========================================
    public function trangQuanLyTheLoai()
    {
        // Ở trang thể loại, nếu bạn không dùng DataTables trong View thì giữ nguyên paginate là đúng.
        // Còn nếu trang thể loại cũng dùng đoạn script DataTables giống trang sách, 
        // thì bạn cũng đổi ->paginate(10) thành ->get() ở đây nhé.
        $theloais = DB::table('dm_the_loai')->orderBy('id', 'desc')->paginate(10);

        return view('admin.theloai', compact('theloais'));
    }

    // ==========================================
    // 8. TRANG THÊM THỂ LOẠI
    // ==========================================
    public function trangThemTheLoai()
    {
        return view('admin.themtheloai');
    }

    // ==========================================
    // 9. LƯU THỂ LOẠI MỚI
    // ==========================================
    public function luuTheLoai(Request $request)
    {
        DB::table('dm_the_loai')->insert([
            'ten_the_loai' => $request->ten_the_loai,
            'status' => $request->status ?? 1 // Mặc định là 1 (Hoạt động)
        ]);
        return redirect()->route('admin.theloai');
    }

    // ==========================================
    // 10. TRANG SỬA THỂ LOẠI
    // ==========================================
    public function trangSuaTheLoai($id)
    {
       $theloai = DB::table('dm_the_loai')->where('id', $id)->first();

        // 2. Trả về đúng view 'admin.suatheloai' và truyền biến $theloai sang
        return view('admin.suatheloai', compact('theloai'));
    }

    // ==========================================
    // 11. CẬP NHẬT THỂ LOẠI
    // ==========================================
    public function capNhatTheLoai(Request $request, $id)
    {
        DB::table('dm_the_loai')->where('id', $id)->update([
            'ten_the_loai' => $request->ten_the_loai,
            'status' => $request->status
        ]);
        return redirect()->route('admin.theloai');
    }

    // ==========================================
    // 12. XÓA MỀM THỂ LOẠI
    // ==========================================
    public function xoaTheLoai($id)
    {
        // Chuyển status về 0 thay vì xóa hẳn khỏi database để tránh lỗi khóa ngoại với bảng Sách
        DB::table('dm_the_loai')->where('id', $id)->update(['status' => 0]);
        return redirect()->route('admin.theloai');
    }
}