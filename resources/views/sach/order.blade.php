<x-book-layout>
    <x-slot name="title">
        Giỏ hàng & Thanh toán
    </x-slot>
    @if(session('status'))
        <div class="alert alert-success" style="text-align:center; margin:10px;">
            {{ session('status') }}
        </div>
    @endif
    <h3 class="text-center text-primary mb-4">DANH SÁCH SẢN PHẨM TRONG GIỎ HÀNG</h3>
    
    <table class="table table-hover table-bordered shadow-sm">
        <thead class="thead-light text-center">
            <tr>
                <th>Tên sách</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
                <th>Xoá</th>
            </tr>
        </thead>
        <tbody>
            @php $tongTien = 0; @endphp
            @foreach($data as $row)
                @php 
                    $thanhTien = $row->gia * $quantity[$row->id];
                    $tongTien += $thanhTien;
                @endphp
                <tr>
                    <td>{{ $row->ten_sach }}</td>
                    <td class="text-center">{{ $quantity[$row->id] }}</td>
                    <td class="text-right">{{ number_format($row->gia, 0, ',', '.') }}đ</td>
                    <td class="text-right font-weight-bold">{{ number_format($thanhTien, 0, ',', '.') }}đ</td>
                    <td class="text-center">
                        <form method="post" action="{{ route('cartdelete') }}">
                            @csrf
                            <input type="hidden" value="{{ $row->id }}" name="id">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="table-info">
                <td colspan="3" class="text-right"><b>TỔNG CỘNG:</b></td>
                <td class="text-right text-danger font-weight-bold" colspan="2">
                    {{ number_format($tongTien, 0, ',', '.') }}đ
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-5 justify-content-center">
        <div class="col-md-6 card p-4 shadow-sm border-primary">
            <h4 class="text-center mb-3">Thông tin đặt hàng</h4>
            <form action="{{ route('ordercreate') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Hình thức thanh toán</label>
                    <select name="hinh_thuc_thanh_toan" class="form-control">
                        <option value="1">Tiền mặt khi nhận hàng (COD)</option>
                        <option value="2">Chuyển khoản ngân hàng</option>
                        <option value="3">Ví điện tử (VNPay/Momo)</option>
                    </select>
                </div>
                <div class="alert alert-secondary small">
                    <i class="fa fa-info-circle"></i> Một email xác nhận sẽ được gửi sau khi bạn bấm đặt hàng.
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">XÁC NHẬN ĐẶT HÀNG</button>
            </form>
        </div>
    </div>
</x-book-layout>