<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Arial, sans-serif; padding: 20px; }
        .main-card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); background: #fff; }
        .table thead { background-color: #343a40; color: white; }
        .table th { font-size: 0.8rem; text-transform: uppercase; padding: 15px; border: none; }
        .badge-role { padding: 5px 10px; border-radius: 5px; font-size: 11px; font-weight: bold; }
        .text-address { max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .header-action { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        
        /* Section tìm kiếm */
        .filter-section { background: #fff; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); }
        .time-text { font-size: 12px; color: #6c757d; display: block; }
        .time-label { font-size: 10px; font-weight: bold; color: #adb5bd; text-transform: uppercase; margin-bottom: 2px; }
    </style>
</head>
<body>

    <div class="container-fluid px-4">
        <div class="header-action">
            <h3 class="fw-bold text-dark m-0">HỆ THỐNG QUẢN LÝ NGƯỜI DÙNG</h3>
            <a href="{{ url('admin/index') }}" class="btn btn-outline-dark shadow-sm">
                <i class="bi bi-arrow-left"></i> Quay về
            </a>
        </div>

        <div class="filter-section" style="background: #fff; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
    <form action="{{ url('/admin/user') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="small fw-bold text-muted mb-1">Tìm kiếm tên/email:</label>
            <input type="text" name="search" class="form-control form-control-sm" 
                   placeholder="Nhập nội dung..." value="{{ request('search') }}">
        </div>

        <div class="col-md-2">
            <label class="small fw-bold text-muted mb-1">Ngày đăng ký:</label>
            <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
        </div>

        <div class="col-md-2">
            <label class="small fw-bold text-muted mb-1">Vai trò:</label>
            <select name="role" class="form-select form-select-sm">
                <option value="">Tất cả</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-primary flex-grow-1">Lọc ngay</button>
            <a href="{{ url('/admin/user') }}" class="btn btn-sm btn-outline-secondary">Xóa lọc</a>
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
                                <th>Thành viên</th>
                                <th>Liên hệ</th>
                                <th>Địa chỉ</th>
                                <th>Vai trò</th>
                                <th>Thời gian tham gia</th>
                                <th>Cập nhật cuối</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td class="text-muted fw-bold ps-4">#{{ $user->id }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </td>
                                <td>{{ $user->phone ?? '---' }}</td>
                                <td>
                                    <div class="text-address text-muted" title="{{ $user->dia_chi }}">
                                        {{ $user->dia_chi ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge bg-danger badge-role">ADMIN</span>
                                    @else
                                        <span class="badge bg-primary badge-role">USER</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="time-text">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : '---' }}
                                    </span>
                                    <span class="time-text" style="font-size: 10px;">
                                        {{ $user->created_at ? $user->created_at->format('H:i') : '' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="time-text">
                                        <i class="bi bi-clock-history me-1"></i>
                                        {{ $user->updated_at ? $user->updated_at->format('d/m/Y') : '---' }}
                                    </span>
                                    <span class="time-text" style="font-size: 10px;">
                                        {{ $user->updated_at ? $user->updated_at->format('H:i') : '' }}
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <form action="{{ url('/admin/user/'.$user->id) }}" method="POST" onsubmit="return confirm('Xóa tài khoản này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">Không tìm thấy dữ liệu.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="py-3 d-flex justify-content-center border-top">
                    {{ $users->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>

</body>
</html>