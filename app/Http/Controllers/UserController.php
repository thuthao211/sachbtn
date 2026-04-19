<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // 1. Khởi tạo query từ model User
        $query = User::query();

        // 2. Lọc theo Tên hoặc Email 
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 3. Lọc theo Ngày tham gia 
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // 4. Lọc theo Vai trò (role)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // 5. Lấy danh sách: Sắp xếp mới nhất và phân trang
        $users = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.quan-ly-nguoi-dung', compact('users'));
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('thongbao', 'Xóa người dùng thành công');
    }
}