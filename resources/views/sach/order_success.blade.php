<h2>Xác nhận đơn hàng thành công!</h2>
<table border="1" cellspacing="0" cellpadding="10" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">
    <thead>
        <tr style="background: #f2f2f2;">
            <th align="left">Tên Sách</th>
            <th align="center">Số lượng</th>
            <th align="right">Đơn giá</th>
            <th align="right">Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($mailData as $item)
            @php 
                $thanhTien = $item['so_luong'] * $item['don_gia'];
                $total += $thanhTien;
            @endphp
            <tr>
                <td>{{ $item['ten_sach'] }}</td>
                <td align="center">{{ $item['so_luong'] }}</td>
                <td align="right">{{ number_format($item['don_gia'], 0, ',', '.') }}đ</td>
                <td align="right">{{ number_format($thanhTien, 0, ',', '.') }}đ</td>
            </tr>
        @endforeach
        <tr style="background: #eee;">
            <td colspan="3" align="right"><b>Tổng thanh toán</b></td>
            <td align="right"><b><span style="color: red;">{{ number_format($total, 0, ',', '.') }}đ</span></b></td>
        </tr>
    </tbody>
</table>
<p>Chúng tôi sẽ liên hệ với bạn sớm nhất để giao hàng.</p>
<p>Cảm ơn bạn đã đặt hàng tại Trạm Sách Online</p>