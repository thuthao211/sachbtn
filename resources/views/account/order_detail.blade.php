<x-book-layout title="Chi tiết đơn hàng - Trạm Sách Online">
    <div class="row mb-5">
        <div class="col-md-3">
            @include('account.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    Chi tiết đơn hàng #{{ $order->id }}
                    <a href="{{ route('account.orders') }}" class="float-right text-white text-decoration-none" style="float: right;">← Quay lại</a>
                </div>
                <div class="card-body">
                    <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái:</strong> {{ $order->trang_thai }}</p>
                    <p><strong>Phương thức thanh toán:</strong> {{ strtoupper($order->thanh_toan) }}</p>
                    
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sách</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $item)
                            <tr>
                                <td>
                                    @if($item->sach && $item->sach->hinh_anh)
                                        <img src="{{ asset('images/' . $item->sach->hinh_anh) }}" alt="" width="50">
                                    @endif
                                </td>
                                <td>{{ $item->sach ? $item->sach->ten_sach : 'Sách không tồn tại' }}</td>
                                <td>{{ number_format($item->don_gia, 0, ',', '.') }} đ</td>
                                <td>{{ $item->so_luong }}</td>
                                <td>{{ number_format($item->don_gia * $item->so_luong, 0, ',', '.') }} đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right" style="text-align: right;"><strong>Tổng cộng:</strong></td>
                                <td><strong class="text-danger">{{ number_format($order->tong_tien, 0, ',', '.') }} đ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-book-layout>