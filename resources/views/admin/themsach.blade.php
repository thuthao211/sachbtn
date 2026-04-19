<x-admin-layout title="Thêm Sách Mới">
    {{-- CSS cục bộ tái hiện phong cách cũ chuyên cho trang Thêm mới --}}
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
        
        .box-primary-add {
            border-top: 3px solid #3c8dbc;
            border-radius: 3px;
            background: #ffffff;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            padding: 15px;
        }
        
        .form-label { font-weight: bold; font-size: 14px; color: #333; }
        
        .image-box-add {
            border: 1px dashed #ccc;
            padding: 30px 10px;
            text-align: center;
            background: #f9f9f9;
            cursor: pointer;
            margin-bottom: 10px;
            transition: 0.3s;
        }
        .image-box-add:hover { border-color: #3c8dbc; background: #f0f7fd; }
        .image-box-add i { font-size: 40px; color: #ccc; margin-bottom: 10px; }
        
        .box-title-add {
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
            Thêm Sách Mới
            <small class="text-muted" style="font-size: 15px;">Khởi tạo dữ liệu</small>
        </h1>
        <ol class="breadcrumb mb-0 bg-transparent" style="font-size: 12px;">
            <li><a href="#"><i class="fas fa-dashboard"></i> Trang chủ</a></li>
            <li class="ms-2"> > Quản trị > Thêm mới</li>
        </ol>
    </div>

    <div class="box-primary-add">
        <form action="{{ route('admin.themsach.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Cột bên trái: Thông tin chính --}}
                <div class="col-md-8 border-end pe-4">
                    <div class="box-title-add"><i class="fas fa-info-circle"></i> Thông tin cơ bản</div>
                    
                    <div class="row mb-3 align-items-center">
                        <label class="col-sm-3 col-form-label text-end form-label">Tên Sách <span class="text-danger">*</span>:</label>
                        <div class="col-sm-9">
                            <input type="text" name="ten_sach" class="form-control form-control-sm" required placeholder="Nhập tên sách...">
                        </div>
                    </div>
                    
                    <div class="row mb-3 align-items-center">
                        <label class="col-sm-3 col-form-label text-end form-label">Tác giả:</label>
                        <div class="col-sm-9">
                            <input type="text" name="tac_gia" class="form-control form-control-sm" placeholder="Tên tác giả...">
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-sm-3 col-form-label text-end form-label">Nhà xuất bản:</label>
                        <div class="col-sm-9">
                            <input type="text" name="nha_xuat_ban" class="form-control form-control-sm" placeholder="VD: NXB Kim Đồng">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label text-end form-label">Mô tả nội dung:</label>
                        <div class="col-sm-9">
                            <textarea name="mo_ta" class="form-control" rows="8" placeholder="Nhập tóm tắt nội dung sách..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- Cột bên phải: Cấu hình và Bìa --}}
                <div class="col-md-4 ps-4">
                    <div class="box-title-add"><i class="fas fa-cogs"></i> Thông số & Hình ảnh</div>
                    
                    <div class="mb-3">
                        <label class="form-label d-block text-center">Hình ảnh bìa sách <span class="text-danger">*</span>:</label>
                        <div class="image-box-add">
                            <i class="fas fa-cloud-upload-alt"></i><br>
                            <small class="text-muted">Chọn ảnh bìa phù hợp</small>
                        </div>
                        <input type="file" name="hinh_anh" class="form-control form-control-sm" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục (Thể loại):</label>
                        <select name="dm_the_loai_id" class="form-select form-select-sm" required>
                            <option value="">-- Chọn thể loại --</option>
                            @foreach($danh_sach_the_loai as $tl)
                                <option value="{{ $tl->id }}">{{ $tl->ten_the_loai }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Giá bán (VNĐ) <span class="text-danger">*</span>:</label>
                            <input type="number" name="gia" class="form-control form-control-sm" required placeholder="50.000">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Số lượng:</label>
                            <input type="number" name="so_luong" class="form-control form-control-sm" value="0">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Số trang:</label>
                            <input type="number" name="so_trang" class="form-control form-control-sm" placeholder="120">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Năm XB:</label>
                            <input type="number" name="nam_xuat_ban" class="form-control form-control-sm" placeholder="2023">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái:</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="1">Hiển thị (Đang bán)</option>
                            <option value="0">Ẩn (Ngừng bán)</option>
                        </select>
                    </div>

                    <div class="text-end mt-4 border-top pt-3">
                        <a href="{{ route('admin.sach') }}" class="btn btn-default btn-sm btn-flat border me-2"> Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary btn-sm btn-flat px-4 shadow-sm" style="background-color: #3c8dbc; border-color: #367fa9;">
                            <i class="fas fa-save"></i> Lưu dữ liệu
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>