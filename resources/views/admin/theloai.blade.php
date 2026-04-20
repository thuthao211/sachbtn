<x-admin-layout title="Quản lý Thể loại">
    <style>
        /* Bê nguyên CSS từ trang Quản lý Sách sang */
        .hdr { background: #fff; padding: 15px 25px; border-bottom: 1px solid #e2e8f0; margin: -20px -20px 25px; display: flex; justify-content: space-between; align-items: center; }
        .crd { background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; padding: 25px; }

        .table-custom { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .table-custom th { text-align: left; padding: 15px 10px; border-bottom: 2px solid #f1f5f9; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .table-custom td { padding: 15px 10px; border-bottom: 1px solid #f8fafc; vertical-align: middle; color: #334155; font-size: 0.95rem; }
        .table-custom tr:hover { background-color: #f8fafc; }

        .btn-add { background: #0d6efd; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; text-decoration: none; transition: 0.2s; }
        .btn-add:hover { background: #0b5ed7; color: white; }
        
        .action-btn { border: none; padding: 8px; border-radius: 6px; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; }
        .btn-edit { background: #fff9e6; color: #d97706; }
        .btn-edit:hover { background: #fde68a; }
        .btn-delete { background: #fee2e2; color: #dc2626; margin-left: 5px; }
        .btn-delete:hover { background: #fecaca; }

        .pagination-container { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #f1f5f9; }
        
        /* Thêm style cho Badge Trạng thái */
        .badge-active { background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 50px; font-size: 0.85rem; font-weight: 500; display: inline-block;}
        .badge-inactive { background: #f1f5f9; color: #64748b; padding: 6px 12px; border-radius: 50px; font-size: 0.85rem; font-weight: 500; display: inline-block;}
    </style>

    <div class="hdr">
        <h2 style="margin: 0; font-size: 1.25rem; font-weight: 600; color: #1e293b;">Quản lý Thể loại</h2>
        <a href="{{ route('admin.theloai.create') }}" class="btn-add">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm thể loại mới
        </a>
    </div>

    <div class="crd">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="10%" style="text-align: center;">ID</th>
                    <th width="50%">TÊN THỂ LOẠI</th>
                    <th width="20%" style="text-align: center;">TRẠNG THÁI</th>
                    <th width="20%" style="text-align: center;">THAO TÁC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($theloais as $tl)
                <tr>
                    <td style="text-align: center; color: #64748b;">{{ $tl->id }}</td>
                    <td style="font-weight: 600; color: #0f172a;">{{ $tl->ten_the_loai }}</td>
                    <td style="text-align: center;">
                        @if($tl->status == 1)
                            <span class="badge-active">Hoạt động</span>
                        @else
                            <span class="badge-inactive">Đã ẩn</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.theloai.edit', $tl->id) }}" class="action-btn btn-edit" title="Sửa">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        
                        <a href="{{ route('admin.theloai.delete', $tl->id) }}" class="action-btn btn-delete" title="Xóa">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-container">
            <span style="color: #64748b; font-size: 0.9rem;">
                Hiển thị {{ $theloais->firstItem() ?? 0 }} - {{ $theloais->lastItem() ?? 0 }} / {{ $theloais->total() }} thể loại
            </span>
            
            <div style="display: flex; gap: 5px;">
                {{ $theloais->links('pagination::bootstrap-4') }} 
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Bắt sự kiện click vào nút có class "btn-delete"
            $('.btn-delete').on('click', function(e) {
                e.preventDefault(); // Chặn hành động chuyển trang lập tức
                
                let url = $(this).attr('href'); // Lấy cái link xóa
                
                // Hiện hộp thoại SweetAlert2
                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    text: "Thể loại này sẽ bị ẩn (Xóa mềm) khỏi danh sách!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', // Màu đỏ giống nút
                    cancelButtonColor: '#94a3b8',  // Màu xám nút hủy
                    confirmButtonText: 'Có, xóa ngay!',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Trình duyệt điều hướng tới đường link nếu bấm 'Có'
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
</x-admin-layout>