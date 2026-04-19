<x-admin-layout title="Thêm Thể Loại">
    <style>
        .hdr { background: #fff; padding: 15px 25px; border-bottom: 1px solid #e2e8f0; margin: -20px -20px 25px; }
        .crd { background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; padding: 30px; max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-weight: 600; color: #334155; margin-bottom: 8px; font-size: 14px; }
        .form-control { width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; transition: 0.3s; font-size: 15px; box-sizing: border-box; }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .btn-submit { background: #0f172a; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s; width: 100%; margin-top: 10px;}
        .btn-submit:hover { background: #3b82f6; }
        .btn-back { display: inline-flex; align-items: center; gap: 5px; color: #64748b; text-decoration: none; font-size: 14px; font-weight: 500; margin-bottom: 15px;}
        .btn-back:hover { color: #0f172a; }
    </style>

    <div class="hdr">
        <h2 style="margin: 0; font-size: 1.25rem; font-weight: 600; color: #1e293b;">Thêm Thể Loại Mới</h2>
    </div>

    <div class="crd">
        <a href="{{ route('admin.theloai') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
        
        <form action="{{ route('admin.theloai.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Tên thể loại</label>
                <input type="text" name="ten_the_loai" class="form-control" placeholder="Nhập tên thể loại..." required>
            </div>

            <div class="form-group">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="1">Hoạt động</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Lưu Thể Loại</button>
        </form>
    </div>
</x-admin-layout>