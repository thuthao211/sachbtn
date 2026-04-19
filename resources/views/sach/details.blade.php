<x-book-layout>
    <x-slot name="title">
        Chi tiết sách: {{ $sach->ten_sach }}
    </x-slot>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-5">
            <img src="{{ asset('hinh/image/'.$sach->hinh_anh) }}" width="100%" class="img-thumbnail">
        </div>
        <div class="col-md-7">
            <h3>{{ $sach->ten_sach }}</h3>
            <p>Tác giả: <b>{{ $sach->tac_gia }}</b></p>
            <p>Nhà xuất bản: <b>{{ $sach->nha_xuat_ban }}</b></p>
            <h4 class="text-danger">{{ number_format($sach->gia, 0, ',', '.') }}đ</h4>
            
            <form action="{{ route('cartadd') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="id" value="{{ $sach->id }}">
                <div class="input-group mb-3" style="width: 200px;">
                    <span class="input-group-text">Số lượng</span>
                    <input type="number" name="num" value="1" min="1" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-shopping-cart"></i> THÊM VÀO GIỎ HÀNG
                </button>
            </form>
        </div>
    </div>

    <hr>
    <div class="mt-4">
        <h5>Nội dung sách</h5>
        <p>{{ $sach->mo_ta }}</p>
    </div>

    <div class="mt-5 border-top pt-4">
        <h4>Đánh giá từ độc giả</h4>
        @forelse($reviews as $rev)
            <div class="mb-3 p-2 bg-light rounded">
                <span class="text-primary font-weight-bold">{{ $rev->name }}</span> 
                <span class="text-warning ml-2">{{ str_repeat('⭐', $rev->diem) }}</span>
                <p class="mb-0 italic">"{{ $rev->noi_dung }}"</p>
                <small class="text-muted">{{ $rev->created_at }}</small>
            </div>
        @empty
            <p class="text-muted">Chưa có đánh giá nào cho cuốn sách này.</p>
        @endforelse

        @if($canRate)
            <div class="card mt-4 p-3 shadow-sm">
                <h5>Gửi đánh giá của bạn</h5>
                <form action="{{ route('book.rate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="sach_id" value="{{ $sach->id }}">
                    <div class="form-group">
                        <label>Số sao:</label>
                        <select name="so_sao" class="form-control" style="width: 120px;">
                            <option value="5">5 Sao (Tuyệt vời)</option>
                            <option value="4">4 Sao (Tốt)</option>
                            <option value="3">3 Sao (Tạm được)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nội dung nhận xét:</label>
                        <textarea name="nhan_xet" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                </form>
            </div>
        @endif
    </div>
</x-book-layout>