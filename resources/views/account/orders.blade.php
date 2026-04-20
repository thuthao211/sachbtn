<x-book-layout title="Lịch sử đơn hàng - Trạm Sách Online">
    <div class="row mb-5">
        <div class="col-md-3">
            @include('account.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-history mr-2"></i> Danh sách đơn hàng đã đặt</h5>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Mã ĐH</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                                    <td class="text-danger font-weight-bold">{{ number_format($order->tong_tien, 0, ',', '.') }} đ</td>
                                    <td><span class="badge badge-light border">{{ strtoupper($order->thanh_toan) }}</span></td>
                                    <td>
                                        @if($order->trang_thai == 'cho_xac_nhan') 
                                            <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                                        @elseif($order->trang_thai == 'dang_giao') 
                                            <span class="badge bg-primary text-white">Đang giao</span>
                                        @elseif($order->trang_thai == 'da_giao') 
                                            <span class="badge bg-success text-white">Đã giao</span>
                                        @else 
                                            <span class="badge bg-danger text-white">Đã hủy</span>
                                        @endif
                                    </td>
                                    <td class="text-center">

                                        <a href="{{ route('account.order_detail', $order->id) }}" class="btn btn-sm btn-info">
                                            Xem
                                        </a>

                                        @if($order->trang_thai == 'cho_xac_nhan')
                                            <form action="{{ route('account.order_cancel', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc muốn hủy đơn này?')">
                                                    Hủy
                                                </button>
                                            </form>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                            <a href="{{ url('/') }}" class="btn btn-danger">Tiếp tục mua sắm</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-book-layout>