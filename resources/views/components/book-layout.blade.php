@props(['title' => 'Trạm Sách Online'])
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>

    <link rel="stylesheet" href="{{asset('library/bootstrap.min.css')}}">
    <script src="{{asset('library/jquery.slim.min.js')}}"></script>
    <script src="{{asset('library/popper.min.js')}}"></script>
    <script src="{{asset('library/bootstrap.bundle.min.js')}}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f9;
        }

        /* HEADER */
        .header {
            background-color: #D32F2F;
            color: white;
            padding: 12px 0;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: auto;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #FFEB3B;
            text-decoration: none;
        }

        .menu {
            display: flex;
            gap: 20px;
        }

        .menu a {
            color: white;
            text-decoration: none;
        }

        .menu a:hover {
            color: #FFEB3B;
        }

        /* DROPDOWN */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #D32F2F;
            min-width: 200px;
            z-index: 1000;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            display: block;
            padding: 10px;
            color: white;
        }

        .dropdown-content a:hover {
            background-color: #FF5722;
        }

        /* SEARCH */
        .search-bar input {
            padding: 8px;
            border-radius: 20px 0 0 20px;
            border: none;
        }

        .search-bar button {
            border-radius: 0 20px 20px 0;
            border: none;
            background: #f88664;
            color: white;
            padding: 8px 15px;
        }

        /* FOOTER */
        footer {
            background-color: #D32F2F;
            color: white;
            margin-top: 50px;
            padding: 30px 0;
        }

        footer h3 {
            color: #FFEB3B;
        }
    </style>
</head>

<body>

<!-- BANNER -->
<div>
    <img src="{{asset('images/bannersach')}}" width="100%">
</div>
@if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    </div>
@endif

<!-- HEADER -->
<header class="header">
    <div class="header-container">

        <!-- LOGO -->
        <a href="{{url('/')}}" class="logo">📚 Trạm Sách Online</a>

        <!-- MENU -->
        <nav class="menu">
            <a href="{{url('/')}}">🏠 Trang chủ</a>

            <div class="dropdown">
                <a href="#">📚 Danh mục ▾</a>
                <div class="dropdown-content">
                    @foreach($categories as $category)
                        <a href="{{url('sach/theloai/'.$category->id)}}">
                            › {{$category->ten_the_loai}}
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>

        <!-- SEARCH -->
        <div class="search-bar">
            <form action="{{url('/timkiem')}}" method="GET">
                <input type="text" name="keyword" placeholder="Tìm sách...">
                <button type="submit">🔍</button>
            </form>
        </div>

        <!-- USER + CART -->
        <div class="d-flex align-items-center">

            <a href="{{url('/giohang')}}" class="text-white mr-3">
                <i class="fas fa-shopping-cart"></i>
            </a>

            @auth
                <span> <a href="/user/taikhoan" class="text-white text-decoration-none">
                            👤 {{ Auth::user()->name }}
                        </a></span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-danger">Đăng xuất</button>
                </form>
            @else
                <a href="{{ route('login') }}">
                    <button class="btn btn-sm btn-success mr-2">Đăng nhập</button>
                </a>
                <a href="{{ route('register') }}">
                    <button class="btn btn-sm btn-primary">Đăng ký</button>
                </a>
            @endauth
        </div>

    </div>
</header>

<!-- CONTENT -->
<main class="container mt-4">
    {{$slot}}
</main>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <h3>💼 Liên hệ</h3>
                <p>Email: support@bookstore.vn</p>
                <p>Hotline: 1900 1234</p>
            </div>

            <div class="col-md-4">
                <h3>📚 Danh mục</h3>
                @foreach($categories->take(4) as $category)
                    <p>
                        <a href="{{url('sach/theloai/'.$category->id)}}">
                            › {{$category->ten_the_loai}}
                        </a>
                    </p>
                @endforeach
            </div>

            <div class="col-md-4">
                <h3>🛡️ Hỗ trợ</h3>
                <p>Hướng dẫn mua hàng</p>
                <p>Chính sách đổi trả</p>
            </div>

        </div>

        <div class="text-center mt-3">
            © 2026 Trạm Sách Online
        </div>
    </div>
</footer>

</body>
</html>