<div class="list-group">
    <a href="{{ route('account.profile') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.profile') ? 'active' : '' }}">
        Thông tin tài khoản
    </a>
    <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.orders*') ? 'active' : '' }}">
        Lịch sử đơn hàng
    </a>
</div>