<x-admin-layout title="Quản lý đánh giá">
    <style>       
        .page-wrapper {
            margin-top: 30px; 
            background: #ffffff; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .page-title {
            color: #ff5850;
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 25px;
        }
        
        .review-table th, 
        .review-table td {
            vertical-align: middle !important;
        }
        .review-table th {
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
            border: none;
        }

        .col-book { text-align: left; font-weight: bold; }
        .col-customer { text-align: center; }
        .col-customer .name { font-weight: bold; display: block; }
        .col-customer .date { color: #6c757d; font-size: 0.85em; }
        
        .col-score { text-align: center; font-weight: bold; color: #ffc107; }
        .col-content { text-align: left; font-style: italic; }
        .col-status { text-align: center; }
        .col-actions { text-align: center; }

        .status-badge {
            display: inline-block; 
            white-space: nowrap;   
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
        }
        .badge-pending { background-color: #ffc107; color: #212529; }
        .badge-approved { background-color: #28a745; }
        .badge-rejected { background-color: #6c757d; }

        .action-btn {
            display: inline-block;
            padding: 5px 10px;
            margin-bottom: 4px;
            color: white;
            font-size: 13px;
            border-radius: 4px;
            text-decoration: none;
            transition: transform 0.2s;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
        .btn-approve { background-color: #28a745; }
        .btn-reject, .btn-delete { background-color: #dc3545; }
        
        .empty-row { text-align: center; color: #6c757d; padding: 2rem 0; }
    </style>

    <div class="container-fluid">
        <div class="container page-wrapper">
            <h2 class="page-title">Quản lý đánh giá</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover review-table">                
                    <thead>
                        <tr>
                            <th width="20%">Sách</th>
                            <th width="15%">Khách hàng</th>
                            <th width="10%">Điểm</th>
                            <th width="30%">Nội dung</th>
                            <th width="10%">Trạng thái</th>
                            <th width="15%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($danhgia as $item)
                            <tr>
                                <td class="col-book">
                                    {{ $item->ten_sach }}
                                </td>

                                <td class="col-customer">
                                    <span class="name">{{ $item->ho_ten }}</span>
                                    <span class="date">{{ \Carbon\Carbon::parse($item->ngay_tao)->format('d/m/Y') }}</span>
                                </td>

                                <td class="col-score">
                                    {{ $item->diem_so }} <i class="fas fa-star"></i>
                                </td>

                                <td class="col-content">
                                    "{{ $item->noi_dung }}"
                                </td>

                                <td class="col-status">
                                    @if ($item->trang_thai === 'cho_duyet')
                                        <span class="status-badge badge-pending">Chờ duyệt</span>
                                    @elseif ($item->trang_thai === 'da_duyet')
                                        <span class="status-badge badge-approved">Đã duyệt</span>
                                    @else
                                        <span class="status-badge badge-rejected">Từ chối</span>
                                    @endif
                                </td>

                                <td class="col-actions">
                                    @if ($item->trang_thai === 'cho_duyet')
                                        <a href="{{ route('admin.danhgia.duyet', $item->id) }}" class="action-btn btn-approve">
                                            <i class="fas fa-check"></i> Duyệt
                                        </a>
                                        <a href="{{ route('admin.danhgia.tuchoi', $item->id) }}" class="action-btn btn-reject" onclick="return confirm('Từ chối đánh giá này?');">
                                            <i class="fas fa-times"></i> Từ chối
                                        </a>
                                    @else
                                        <a href="{{ route('admin.danhgia.xoa', $item->id) }}" class="action-btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa đánh giá này?');">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-row">Chưa có đánh giá nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>