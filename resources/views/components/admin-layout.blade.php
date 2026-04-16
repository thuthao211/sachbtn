@props(['title' => 'Admin Dashboard'])
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{$title ?? 'Admin Dashboard'}}</title>

    <link rel="stylesheet" href="{{asset('library/bootstrap.min.css')}}">
    <script src="{{asset('library/jquery.slim.min.js')}}"></script>
    <script src="{{asset('library/popper.min.js')}}"></script>
    <script src="{{asset('library/bootstrap.bundle.min.js')}}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { margin: 0; background:#f4f6f9; font-family: Arial; }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
        }

        .sidebar h3 {
            text-align: center;
            padding: 15px;
            background: #212529;
            margin: 0;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .topbar {
            background: white;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
        }

        .badge-admin {
            background: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3>📚 ADMIN</h3>

    <a href="/admin/index"><i class="fas fa-home"></i> Dashboard</a>
    <a href="/admin/sach"><i class="fas fa-book"></i> Quản lý sách</a>
    <a href="/admin/theloai"><i class="fas fa-list"></i> Thể loại</a>

    <a href="/admin/user"><i class="fas fa-users"></i> Quản lý user</a>
    <a href="/admin/danhgia"><i class="fas fa-star"></i> Quản lý đánh giá</a>
    <a href="/admin/donhang"><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</a>

    <a href="/"><i class="fas fa-store"></i> Trang user</a>
</div>

<!-- CONTENT -->
<div class="content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            Xin chào 👋 <b>{{auth()->user()->name}}</b>
        </div>

        <div>
            <a href="{{ url('/admin/taikhoan') }}"  class="badge-admin">ADMIN</a>

            <form method="POST" action="{{route('logout')}}" style="display:inline;">
                @csrf
                <button class="btn btn-sm btn-danger">Đăng xuất</button>
            </form>
        </div>
    </div>

    <!-- ERROR MESSAGE -->
    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{session('error')}}
        </div>
    @endif

    <!-- CONTENT SLOT -->
    <div class="mt-3">
        {{$slot}}
    </div>

</div>

</body>
</html>