<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống Quản trị Đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Arial, sans-serif; padding: 20px; }
        .main-card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); background: #fff; }
        .table thead { background-color: #f8f9fa; }
        .table th { font-size: 0.8rem; text-transform: uppercase; padding: 15px; color: #555; border-bottom: 1px solid #eee; }
        .filter-section { background: #fff; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); }
        .header-action { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    </style>
</head>
<body>

    <div class="container-fluid px-4">
        <div class="header-action">
            <h3 class="fw-bold text-dark m-0 text-uppercase">Hệ thống quản lý đơn hàng</h3>
            <a href="{{ url('admin/index') }}" class="btn btn-outline-dark shadow-sm">
                <i class="bi bi-arrow-left"></i> Quay về
            </a>
        </div>

        <div class="filter-section">
            <form action="{{ url('/admin/donhang') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="small fw-bold text-muted mb-1">Tìm kiếm khách/mã ĐH:</label>
                    <input type="text" name="search" class="form-control" placeholder="Nhập nội dung..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold text-muted mb-1">Ngày đặt hàng:</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100 fw-bold" type="submit" style="background-color: #6610f2; border: none; height: 38px;">Lọc ngay</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ url('/admin/donhang') }}" class="btn btn-outline-secondary w-100 fw-bold" style="height: 38px; display: flex; align-items: center; justify-content: center;">Xóa lọc</a>
                </div>
            </form>
        </div>

        <div class="card main-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Khách hàng</th>
                                <th>Thanh toán</th>
                                <th>Tổng tiền</th>
                                <th>Thời gian tạo</th>
                                <th class="text-center">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donhangs as $dh)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#{{ $dh->id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $dh->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $dh->user->email ?? '' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.7rem;">
                                        {{ strtoupper($dh->thanh_toan) }}
                                    </span>
                                </td>
                                <td><span class="text-danger fw-bold">{{ number_format($dh->tong_tien) }}đ</span></td>
                                <td>
                                    <div class="small"><i class="bi bi-calendar3"></i> {{ $dh->created_at->format('d/m/Y') }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">{{ $dh->created_at->format('H:i') }}</div>
                                </td>
                                <td class="text-center pe-4">
                                    <form action="{{ url('/admin/donhang/'.$dh->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="trang_thai" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="cho_xac_nhan" {{ $dh->trang_thai == 'cho_xac_nhan' ? 'selected' : '' }}>Chờ xác nhận</option>
                                            <option value="dang_giao" {{ $dh->trang_thai == 'dang_giao' ? 'selected' : '' }}>Đang giao</option>
                                            <option value="da_giao" {{ $dh->trang_thai == 'da_giao' ? 'selected' : '' }}>Đã giao</option>
                                            <option value="da_huy" {{ $dh->trang_thai == 'da_huy' ? 'selected' : '' }}>Đã hủy</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-5">Không có dữ liệu.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="py-3 d-flex justify-content-center border-top">
                    {{ $donhangs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>