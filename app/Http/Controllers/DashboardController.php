<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sach;
use App\Models\DonHang;
use App\Models\NguoiDung;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filterType = $request->get('filter_type', 'all');
        $filterValue = $request->get('filter_value', date('Y-m-d'));
        
        try {
            $date = Carbon::parse($filterValue);
        } catch (\Exception $e) {
            $date = Carbon::now();
        }

        $query = DonHang::where('trang_thai', 'da_giao');

        if ($filterType !== 'all') {
            switch ($filterType) {
                case 'day':
                    $query->whereDate('created_at', $filterValue);
                    break;
                case 'month':
                    $query->whereYear('created_at', $date->year)
                          ->whereMonth('created_at', $date->month);
                    break;
                case 'quarter':
                    $quarter = ceil($date->month / 3);
                    $query->whereYear('created_at', $date->year)
                          ->whereRaw('QUARTER(created_at) = ?', [$quarter]);
                    break;
                case 'year':
                    $query->whereYear('created_at', $date->year);
                    break;
            }
        }

        $stats = [
            'count_sach'  => Sach::count(),
            'count_don'   => (clone $query)->count(),
            'doanh_thu'   => (clone $query)->sum('tong_tien'),
            'count_khach' => NguoiDung::where('role', '!=', 'admin')->count(),
        ];

        $topSach = DB::table('chi_tiet_don_hang as ct')
            ->join('don_hang as dh', 'ct.don_hang_id', '=', 'dh.id')
            ->join('sach as s', 'ct.sach_id', '=', 's.id')
            ->select('s.ten_sach', 's.hinh_anh as anh_bia', 's.gia as gia_ban', DB::raw('SUM(ct.so_luong) as da_ban'))
            ->where('dh.trang_thai', 'da_giao')
            ->groupBy('s.id', 's.ten_sach', 's.hinh_anh', 's.gia')
            ->orderByDesc('da_ban')
            ->limit(5)
            ->get();

        $topDanhMuc = DB::table('dm_the_loai as dm')
            ->join('sach as s', 's.dm_the_loai_id', '=', 'dm.id')
            ->join('chi_tiet_don_hang as ct', 'ct.sach_id', '=', 's.id')
            ->join('don_hang as dh', 'dh.id', '=', 'ct.don_hang_id')
            ->select('dm.ten_the_loai as ten_danh_muc', DB::raw('SUM(ct.so_luong) as tong_da_ban'))
            ->where('dh.trang_thai', 'da_giao')
            ->groupBy('dm.id', 'dm.ten_the_loai')
            ->orderByDesc('tong_da_ban')
            ->limit(3)
            ->get();

        $topKhachHang = DB::table('don_hang as dh')
            ->join('users as u', 'dh.user_id', '=', 'u.id')
            ->select('u.name as ho_ten', DB::raw('SUM(dh.tong_tien) as tong_chi'))
            ->where('dh.trang_thai', 'da_giao')
            ->groupBy('u.id', 'u.name')
            ->orderByDesc('tong_chi')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'topSach', 'topDanhMuc', 'topKhachHang', 'filterType', 'filterValue'));
    }

    private function applyFilterRaw($query, $column, $type, $date, $value) {
        if($type == 'day') return $query->whereDate($column, $value);
        if($type == 'month') return $query->whereYear($column, $date->year)->whereMonth($column, $date->month);
        if($type == 'year') return $query->whereYear($column, $date->year);
        return $query;
    }
}