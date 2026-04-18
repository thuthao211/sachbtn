<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
{
    $books = DB::table('sach')
                ->orderBy('da_ban', 'desc')   
                ->limit(16)                  
                ->get();

    return view('sach.index', compact('books'));
}

public function theLoai($id)
{
    $books = DB::table('sach')
        ->where('dm_the_loai_id', $id)
        ->paginate(12);

    $category = DB::table('dm_the_loai')
        ->where('id', $id)
        ->first();

    return view('sach.theloai', compact('books', 'category'));
}
public function search(Request $request)
    {
        $keyword = $request->keyword;

        $books = DB::table('sach')
            ->where('ten_sach', 'like', '%' . $keyword . '%')
            ->orWhere('tac_gia', 'like', '%' . $keyword . '%')
            ->paginate(12);

        return view('sach.timkiem', compact('books', 'keyword'));
    }
}
