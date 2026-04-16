<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class BookLayout extends Component
{
    public $categories;

    public function __construct()
    {
        // lấy danh mục sách
        $this->categories = DB::table("dm_the_loai")->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.book-layout');
    }
}