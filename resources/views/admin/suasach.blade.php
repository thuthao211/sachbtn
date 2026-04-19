<x-admin-layout title="Cập Nhật Sách">
    {{-- CSS cục bộ tái hiện phong cách cũ --}}
    <style>
        .old-style-header {
            background: #fff;
            padding: 15px 20px;
            border-bottom: 1px solid #d2d6de;
            margin: -20px -20px 20px -20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .old-style-header h1 { font-size: 24px; margin: 0; font-weight: 500; }
        
        .box-warning {
            border-top: 3px solid #f39c12; /* Màu cam đặc trưng của trang Edit cũ */
            border-radius: 3px;
            background: #ffffff;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            padding: 15px;
        }
        
        .form-label { font-weight: bold; font-size: 14px; color: #333; }
        
        .image-preview-box {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            background: #f9f9f9;
            margin-bottom: 10px;
        }
        .image-preview-box img {
            max-width: 100%;
            height: 150px;
            object-fit: contain;
            border: 1px solid #eee;
        }
        
        .box-title {
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 14px;
            color: #3c8dbc;
        }

        .btn-flat { border-radius: 0; }
    </style>

    {{-- Content Header --}}
    <div class="old-style-header">
        <h1>
            Cập nhật Sách
            <small class="text-muted" style="font-size: 15px;">Chỉnh sửa thông tin</small>
        </h1>
        <ol class="breadcrumb mb-0 bg-transparent" style="font-size: 12px;">
            <li><a href="#"><i class="fas fa-dashboard"></i> Trang chủ</a></li>
            <li class="ms-2"> > Quản trị > Sửa sách</li>
        </ol>
    </div>

    <div class="box-warning">
        <form action="{{ route('admin.sach.update', $sach->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Cột bên trái: Thông tin cơ bản --}}
                <div class="col-md-8 border-end pe-4">
                    <div class="box-title"><i class="fas fa-info-circle"></i> Thông tin cơ bản</div>
                    
                    <div class="row mb-3 align-items-center">
                        <label class="col-sm-3 col-form-label text-end form-label">Tên Sách <span class="text-danger">*</span>:</label>
                        <div class="col-sm-9">
                            <input type="text" name="ten_sach" value="{{ $sach->ten_sach }}" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3 align-items-center">
                        <label class="col-sm-3 col-form-label text-end form-label">Tác giả:</label>
                        <div class="col-sm-9">
                            <input type="text" name="tac_gia" value="{{ $sach->tac_gia }}" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-sm-3 col-form-label text-end form-label">Nhà xuất bản:</label>
                        <div class="col-sm-9">
                            <input type="text" name="nha_xuat_ban" value="{{ $sach->nha_xuat_ban }}" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label text-end form-label">Mô tả nội dung:</label>
                        <div class="col-sm-9">
                            <textarea name="mo_ta" class="form-control" rows="8">{{ $sach->mo_ta }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Cột bên phải: Thông số & Ảnh --}}
                <div class="col-md-4 ps-4">
                    <div class="box-title"><i class="fas fa-cogs"></i> Thông số & Hình ảnh</div>
                    
                    <div class="mb-3">
                        <label class="form-label d-block text-center">Bìa sách hiện tại:</label>
                        <div class="image-preview-box">
                            @php
                                $imgSrc = $sach->hinh_anh ? asset('storage/image/' . $sach->hinh_anh) : 'https://via.placeholder.com/150x200?text=No+Image';
                            @endphp
                            <img src="{{ $imgSrc }}" alt="Bìa sách" onerror="this.src='https://via.placeholder.com/150x200?text=Loi+Anh'">
                        </div>
                        <label class="form-label d-block text-center text-muted small">Thay đổi ảnh mới:</label>
                        <input type="file" name="hinh_anh" class="form-control form-control-sm" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục (Thể loại):</label>
                        <select name="dm_the_loai_id" class="form-select form-select-sm">
                            <option value="">-- Chọn thể loại --</option>
                            @foreach($danh_sach_the_loai as $tl)
                                <option value="{{ $tl->id }}" {{ $sach->dm_the_loai_id == $tl->id ? 'selected' : '' }}>
                                    {{ $tl->ten_the_loai }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Giá bán (VNĐ) <span class="text-danger">*</span>:</label>
                            <input type="number" name="gia" value="{{ $sach->gia }}" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Số lượng:</label>
                            <input type="number" name="so_luong" value="{{ $sach->so_luong }}" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái:</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="1" {{ $sach->status == 1 ? 'selected' : '' }}>Hiển thị (Đang bán)</option>
                            <option value="0" {{ $sach->status == 0 ? 'selected' : '' }}>Ẩn (Ngừng bán)</option>
                        </select>
                    </div>

                    <div class="text-end mt-4 border-top pt-3">
                        <a href="{{ route('admin.sach') }}" class="btn btn-default btn-sm btn-flat border me-2"> Hủy bỏ</a>
                        <button type="submit" class="btn btn-warning btn-sm btn-flat text-white px-4">
                            <i class="fas fa-save"></i> Cập nhật ngay
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>