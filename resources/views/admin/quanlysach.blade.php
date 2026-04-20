<x-admin-layout title="Quản lý Sách">
    <style>
        /* CSS Giao diện hiện đại - Tối giản */
        .hdr { background: #fff; padding: 15px 25px; border-bottom: 1px solid #e2e8f0; margin: -20px -20px 25px; display: flex; justify-content: space-between; align-items: center; }
        .crd { background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; padding: 25px; }
        
        /* --- KHU VỰC HEADER CỦA BẢNG --- */
        .crd-header { display: flex; justify-content: space-between; align-items: center; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9; margin-bottom: 20px; }
        .crd-title { font-size: 18px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 12px; margin: 0; }
        .icon-box { background: #eff6ff; color: #3b82f6; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 10px; font-size: 16px; }
        
        /* Table */
        .tbl { width: 100%; border-collapse: collapse; }
        .tbl th { background: #f8fafc; color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase; padding: 14px 12px; border-bottom: 1px solid #e2e8f0; }
        .tbl td { padding: 16px 12px; vertical-align: middle; border-bottom: 1px solid #f8fafc; color: #334155; }
        .tbl tr:hover td { background: #f8fafc; }
        
        /* Sách & Chữ */
        .b-img { width: 50px; height: 72px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); transition: 0.3s; }
        .b-img:hover { transform: scale(1.08); }
        .b-title { font-size: 15px; font-weight: 600; color: #0f172a; text-decoration: none; display: block; transition: 0.2s; }
        .b-title:hover { color: #3b82f6; }
        .price { font-weight: 700; color: #10b981; }
        .year { background: #f1f5f9; color: #64748b; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        
        /* Nút Bấm */
        .btn-add { background: #0f172a; color: #fff; border-radius: 10px; padding: 10px 20px; font-size: 14px; font-weight: 500; text-decoration: none; transition: 0.2s; box-shadow: 0 4px 6px rgba(15, 23, 42, 0.2); }
        .btn-add:hover { background: #3b82f6; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3); }
        .actions { display: flex; gap: 8px; justify-content: center; flex-wrap: nowrap; }
        .btn-act { width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: 0.2s; text-decoration: none; border: none; font-size: 14px;}
        .b-edit { background: #fef3c7; color: #d97706; } .b-edit:hover { background: #d97706; color: #fff; }
        .b-del { background: #fee2e2; color: #ef4444; } .b-del:hover { background: #ef4444; color: #fff; }

        /* DataTables Controls (Tìm kiếm & Hiển thị) */
        .dataTables_wrapper .row { align-items: center; margin-bottom: 15px; }
        .dataTables_filter { text-align: right; }
        .dataTables_filter input { border: 1px solid #e2e8f0; border-radius: 20px; padding: 8px 18px; width: 280px !important; background: #f8fafc; outline: none; transition: 0.3s; font-size: 14px; }
        .dataTables_filter input:focus { border-color: #3b82f6; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .dataTables_length label { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #64748b; font-weight: 500; margin: 0; }
        .dataTables_length select { border: 1px solid #e2e8f0; border-radius: 8px; padding: 5px 12px; outline: none; background: #f8fafc; font-weight: 600; color: #0f172a; cursor: pointer; }
    </style>

    <div class="hdr">
        <div>
            <h1 class="m-0 fw-bold" style="font-size: 22px; color: #0f172a;">QUẢN LÝ SÁCH</h1>
        </div>
        <div class="text-muted text-sm"><i class="fas fa-home me-1"></i> Admin / <b class="text-dark">Kho Sách</b></div>
    </div>

    <div class="crd">
        <div class="crd-header">
            <h5 class="crd-title">
                <span class="icon-box"><i class="fas fa-book-open"></i></span>
                Danh Sách Ấn Phẩm
            </h5>
            <a href="{{ route('admin.themsach') }}" class="btn-add"><i class="fas fa-plus me-1"></i> Thêm Sách</a>
        </div>

        <div class="table-responsive">
            <table id="tbl-sach" class="tbl">
                <thead>
                    <tr>
                        <th width="70px" class="text-center">Bìa</th>
                        <th width="300px" class="text-start">Tên Sách</th>
                        <th class="text-start">Mô tả tóm tắt</th>
                        <th width="90px" class="text-center">Năm XB</th>
                        <th width="140px" class="text-end">Giá bán</th>
                        <th width="90px" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($danh_sach_sach as $sach)
                    <tr>
                        <td class="text-center">
                            <a href="{{ url('/chitietsach/' . $sach->id) }}">
                                <img src="{{ $sach->hinh_anh ? asset('storage/image/' . $sach->hinh_anh) : 'https://via.placeholder.com/150x200?text=No+Img' }}" class="b-img" onerror="this.src='https://via.placeholder.com/50x70?text=Lỗi'">
                            </a>
                        </td>
                        <td>
                            <a href="{{ url('/chitietsach/' . $sach->id) }}" class="b-title">{{ $sach->ten_sach }}</a>
                        </td>
                        <td><p class="m-0 text-muted" style="font-size: 13.5px; max-width: 280px;">{{ \Illuminate\Support\Str::limit($sach->mo_ta, 70) }}</p></td>
                        <td class="text-center"><span class="year">{{ $sach->nam_xuat_ban }}</span></td>
                        <td class="text-end price">{{ number_format($sach->gia, 0, ',', '.') }} đ</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.sach.edit', $sach->id) }}" class="btn-act b-edit"><i class="fas fa-pen"></i></a>
                                <a href="{{ route('admin.sach.delete', $sach->id) }}" class="btn-act b-del btn-delete"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#tbl-sach').DataTable({
                pageLength: 5, lengthMenu: [[5, 10, -1], [5, 10, "Tất cả"]],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json',
                    search: "", searchPlaceholder: " Tìm tên sách, mô tả...",
                    lengthMenu: "Hiển thị _MENU_ sách",
                    info: "_START_ - _END_ / _TOTAL_ ấn phẩm",
                    paginate: { next: '>', previous: '<' }
                },
                columnDefs: [{ orderable: false, targets: [0, 5] }],
                dom: "<'row align-items-center mb-4'<'col-md-6'l><'col-md-6 text-end'f>>" +
                     "t" +
                     "<'row mt-4'<'col-md-5'i><'col-md-7 text-end'p>>",
            });

            // Xác nhận xóa bằng SweetAlert
            $('#tbl-sach').on('click', '.btn-delete', function(e) {
                e.preventDefault(); let url = $(this).attr('href');
                Swal.fire({
                    title: 'Bạn chắc chắn?', text: "Dữ liệu sẽ bị xóa !", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Xóa ngay', cancelButtonText: 'Hủy'
                }).then((r) => { if (r.isConfirmed) window.location.href = url; });
            });
        });
    </script>
</x-admin-layout>