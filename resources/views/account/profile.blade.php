<x-book-layout title="Thông tin tài khoản - Trạm Sách Online">
    <div class="row mb-5">
        <div class="col-md-3">
            @include('account.sidebar')
        </div>
        <div class="col-md-9">
            
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Cập nhật thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    @if(session('success_profile'))
                        <div class="alert alert-success">{{ session('success_profile') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    @if(!str_contains($error, 'password'))
                                        <li>{{ $error }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('account.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Họ và tên</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Số điện thoại liên hệ</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Địa chỉ nhận hàng</label>
                                <input type="text" name="dia_chi" class="form-control" value="{{ old('dia_chi', $user->dia_chi) }}">
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-primary font-weight-bold"><i class="fas fa-university"></i> Thông tin thanh toán liên kết</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Tên ngân hàng</label>
                                <select name="ten_ngan_hang" class="form-control">
                                    <option value="">-- Chọn ngân hàng --</option>
                                    <option value="Vietcombank" {{ old('ten_ngan_hang', $user->ten_ngan_hang) == 'Vietcombank' ? 'selected' : '' }}>Vietcombank (VCB)</option>
                                    <option value="MB Bank" {{ old('ten_ngan_hang', $user->ten_ngan_hang) == 'MB Bank' ? 'selected' : '' }}>Ngân hàng Quân đội (MB)</option>
                                    <option value="Techcombank" {{ old('ten_ngan_hang', $user->ten_ngan_hang) == 'Techcombank' ? 'selected' : '' }}>Techcombank</option>
                                    <option value="Agribank" {{ old('ten_ngan_hang', $user->ten_ngan_hang) == 'Agribank' ? 'selected' : '' }}>Agribank</option>
                                    <option value="VietinBank" {{ old('ten_ngan_hang', $user->ten_ngan_hang) == 'VietinBank' ? 'selected' : '' }}>VietinBank</option>
                                    <option value="ACB" {{ old('ten_ngan_hang', $user->ten_ngan_hang) == 'ACB' ? 'selected' : '' }}>Ngân hàng Á Châu (ACB)</option>
                                    <option value="TPBank" {{ old('ten_ngan_hang', $user->ten_ngan_hang) == 'TPBank' ? 'selected' : '' }}>TPBank</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Số tài khoản ngân hàng</label>
                                <input type="text" name="stk_ngan_hang" class="form-control" value="{{ old('stk_ngan_hang', $user->stk_ngan_hang) }}" placeholder="Nhập số tài khoản...">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Ví điện tử liên kết</label>
                                <select name="vi_dien_tu" class="form-control">
                                    <option value="">-- Chọn ví điện tử --</option>
                                    <option value="Momo" {{ old('vi_dien_tu', $user->vi_dien_tu) == 'Momo' ? 'selected' : '' }}>Ví Momo</option>
                                    <option value="ZaloPay" {{ old('vi_dien_tu', $user->vi_dien_tu) == 'ZaloPay' ? 'selected' : '' }}>ZaloPay</option>
                                    <option value="ShopeePay" {{ old('vi_dien_tu', $user->vi_dien_tu) == 'ShopeePay' ? 'selected' : '' }}>ShopeePay (AirPay)</option>
                                    <option value="VNPay" {{ old('vi_dien_tu', $user->vi_dien_tu) == 'VNPay' ? 'selected' : '' }}>VNPay</option>
                                    <option value="Viettel Money" {{ old('vi_dien_tu', $user->vi_dien_tu) == 'Viettel Money' ? 'selected' : '' }}>Viettel Money</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Số điện thoại liên kết ví</label>
                                <input type="text" name="vi_dien_tu_sdt" class="form-control" value="{{ old('vi_dien_tu_sdt', $user->vi_dien_tu_sdt) }}" placeholder="Nhập số điện thoại ví...">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-3">Lưu thay đổi</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark font-weight-bold">Đổi mật khẩu</div>
                <div class="card-body">
                    @if(session('success_password'))
                        <div class="alert alert-success">{{ session('success_password') }}</div>
                    @endif
                    
                    <form action="{{ route('account.password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Mật khẩu hiện tại</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Mật khẩu mới</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Xác nhận mật khẩu mới</label>
                                <input type="password" name="new_password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning">Xác nhận đổi mật khẩu</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-book-layout>