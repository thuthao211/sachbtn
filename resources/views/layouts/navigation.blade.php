<nav class="navbar navbar-expand-sm" style="background:#8B4513;">
    <div class="container-fluid">

        <!-- Danh mục -->
        <ul class="navbar-nav">
            @isset($categories)
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link text-white"
                           href="{{ url('sach/theloai/'.$category->id) }}">
                            {{ $category->ten_the_loai }}
                        </a>
                    </li>
                @endforeach
            @endisset
        </ul>

        <!-- Search -->
        <form class="d-flex" method="GET" action="{{ url('/timkiem') }}">
            <input class="form-control me-2"
                   type="text"
                   name="keyword"
                   placeholder="Tìm sách...">
            <button class="btn btn-light" type="submit">🔍</button>
        </form>

        <!-- User -->
        <div class="d-flex align-items-center">

            <!-- Cart -->
            <a href="{{ url('/giohang') }}" class="me-3 text-white">
                🛒
            </a>

            @auth
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle"
                            data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                Tài khoản
                            </a>
                        </li>

                        @if(Auth::user()->role === 'admin')
                            <li>
                                <a class="dropdown-item" href="/admin">
                                    Trang admin
                                </a>
                            </li>
                        @endif

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm me-1">
                    Đăng nhập
                </a>
                <a href="{{ route('register') }}" class="btn btn-success btn-sm">
                    Đăng ký
                </a>
            @endauth

        </div>
    </div>
</nav>