<x-admin-layout title="Tổng quan hệ thống">
    <style>
        .dashboard-wrapper { padding: 20px 10px; }
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .page-title { color: #333; font-weight: bold; font-size: 1.5rem; margin: 0; }
        .filter-box { 
            background: #fff; padding: 12px 15px; border-radius: 8px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e3e6f0;
            display: flex; align-items: center; gap: 10px;
        }
        .filter-input { 
            border: 1px solid #d1d3e2; padding: 6px 12px; 
            border-radius: 4px; outline: none; font-size: 0.9rem;
        }
        .btn-filter { 
            background: #4e73df; color: white; border: none; 
            padding: 6px 15px; border-radius: 4px; cursor: pointer; font-weight: bold; transition: 0.2s;
        }
        .btn-filter:hover { background: #2e59d9; }
        .stats-grid { 
            display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); 
            gap: 20px; margin-bottom: 30px; 
        }
        .stat-card { 
            background: #fff; padding: 20px; border-radius: 8px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.2s; 
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-card h3 { font-size: 0.9rem; color: #858796; margin-bottom: 10px; text-transform: uppercase; font-weight: bold;}
        .stat-card .number { font-size: 1.8rem; font-weight: bold; color: #5a5c69; }
        .c-revenue { border-left: 4px solid #1cc88a; }
        .c-revenue .number, .c-revenue i { color: #1cc88a; }
        
        .c-orders { border-left: 4px solid #4e73df; }
        .c-orders i { color: #4e73df; }
        
        .c-users { border-left: 4px solid #6f42c1; }
        .c-users i { color: #6f42c1; }
        
        .c-books { border-left: 4px solid #f6c23e; }
        .c-books i { color: #f6c23e; }

        .data-card { 
            background: #fff; border-radius: 8px; padding: 20px; 
            margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e3e6f0;
        }
        .card-title { font-weight: bold; margin-bottom: 20px; color: #4e73df; font-size: 1.1rem; }
        .book-table { width: 100%; border-collapse: collapse; }
        .book-table th { background: #f8f9fc; color: #4e73df; padding: 12px; text-align: left; border-bottom: 2px solid #e3e6f0; }
        .book-table td { padding: 12px; border-bottom: 1px solid #e3e6f0; vertical-align: middle; }
        .book-table tr:hover { background-color: #f8f9fa; }
        
        .book-img { width: 45px; height: 60px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .book-name { font-weight: bold; color: #333; display: block; margin-bottom: 3px; }
        .book-price { color: #858796; font-size: 0.85em; }
        
        .badge-top { background: #eaecf4; border: 1px solid #d1d3e2; padding: 4px 10px; border-radius: 12px; font-weight: bold; color: #5a5c69;}
        .badge-sales { background: #1cc88a; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85em; font-weight: bold;}
        .align-right { text-align: right; }

        .list-item { 
            display: flex; justify-content: space-between; align-items: center; 
            padding: 12px 0; border-bottom: 1px solid #eaecf4; 
        }
        .list-item:last-child { border-bottom: none; padding-bottom: 0; }
        .item-name { color: #5a5c69; font-weight: 500; }
        .item-val-info { font-weight: bold; color: #36b9cc; }
        .item-val-danger { font-weight: bold; color: #e74a3b; }
    </style>

    <div class="dashboard-wrapper">
        
        <div class="header-actions">
            <h2 class="page-title">Báo cáo thống kê</h2>
            
            <form method="GET" class="filter-box">
                <select name="filter_type" id="filter_type" class="filter-input" onchange="toggleDateInput()">
                    <option value="all" {{ $filterType == 'all' ? 'selected' : '' }}>Tất cả thời gian</option>
                    <option value="day" {{ $filterType == 'day' ? 'selected' : '' }}>Theo ngày</option>
                    <option value="month" {{ $filterType == 'month' ? 'selected' : '' }}>Theo tháng</option>
                    <option value="quarter" {{ $filterType == 'quarter' ? 'selected' : '' }}>Theo quý</option>
                    <option value="year" {{ $filterType == 'year' ? 'selected' : '' }}>Theo năm</option>
                </select>
                
                <input type="date" name="filter_value" id="filter_value" class="filter-input" 
                       value="{{ $filterValue }}" {{ $filterType == 'all' ? 'disabled' : '' }}>
                
                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i> Lọc
                </button>
            </form>
        </div>

        <div class="stats-grid">
            <div class="stat-card c-revenue">
                <h3><i class="fas fa-money-bill-wave"></i> Doanh thu</h3>
                <div class="number">{{ number_format($stats['doanh_thu']) }}đ</div>
            </div>
            <div class="stat-card c-orders">
                <h3><i class="fas fa-shopping-bag"></i> Đơn đã giao</h3>
                <div class="number">{{ number_format($stats['count_don']) }}</div>
            </div>
            <div class="stat-card c-users">
                <h3><i class="fas fa-user-friends"></i> Khách hàng</h3>
                <div class="number">{{ number_format($stats['count_khach']) }}</div>
            </div>
            <div class="stat-card c-books">
                <h3><i class="fas fa-book-open"></i> Sách đang bán</h3>
                <div class="number">{{ number_format($stats['count_sach']) }}</div>
            </div>
        </div>

        <div class="row">
            
            <div class="col-lg-8">
                <div class="data-card">
                    <h5 class="card-title"><i class="fas fa-fire text-danger"></i> Top 5 Sách bán chạy nhất</h5>
                    <div class="table-responsive">
                        <table class="book-table">
                            <thead>
                                <tr>
                                    <th>Top</th>
                                    <th>Ảnh</th>
                                    <th>Thông tin sách</th>
                                    <th class="align-right">Đã bán</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topSach as $index => $sach)
                                <tr>
                                    <td><span class="badge-top">{{ $index + 1 }}</span></td>
                                    <td><img src="{{ asset('image/' . $sach->anh_bia) }}" class="book-img" alt="{{ $sach->ten_sach }}"></td>
                                    <td>
                                        <span class="book-name">{{ $sach->ten_sach }}</span>
                                        <span class="book-price">{{ number_format($sach->gia_ban) }}đ</span>
                                    </td>
                                    <td class="align-right"><span class="badge-sales">{{ $sach->da_ban }} cuốn</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                
                <div class="data-card">
                    <h5 class="card-title"><i class="fas fa-layer-group text-primary"></i> Top Thể loại</h5>
                    <div>
                        @foreach($topDanhMuc as $dm)
                        <div class="list-item">
                            <span class="item-name">{{ $dm->ten_danh_muc }}</span>
                            <span class="item-val-info">{{ number_format($dm->tong_da_ban) }} cuốn</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="data-card">
                    <h5 class="card-title"><i class="fas fa-trophy text-warning"></i> Khách hàng thân thiết</h5>
                    <div>
                        @foreach($topKhachHang ?? [] as $kh)
                        <div class="list-item">
                            <span class="item-name">{{ $kh->ho_ten }}</span>
                            <span class="item-val-danger">{{ number_format($kh->tong_chi) }}đ</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleDateInput(){
            let type = document.getElementById('filter_type').value;
            let dateInput = document.getElementById('filter_value');
            dateInput.disabled = (type === 'all');
        }
    </script>
</x-admin-layout>