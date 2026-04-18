<x-book-layout>
<div class="container py-4">

    <!-- TITLE -->
    <div class="mb-4">
        <h2 class="fw-bold">
            📚 {{ $category->ten_the_loai ?? 'Danh mục sách' }}
        </h2>
    </div>

    <!-- GRID -->
    <div class="row g-4">
        @foreach($books as $book)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card book-card h-100 border-0 shadow-sm">

                    <!-- IMAGE -->
                    <a href="{{ url('/chitietsach/'.$book->id) }}">
                        <div class="book-img-wrapper">
                            <img src="{{ asset('storage/image/'.$book->hinh_anh) }}"
                                 class="book-img"
                                 alt="{{ $book->ten_sach }}">
                        </div>
                    </a>

                    <!-- BODY -->
                    <div class="card-body d-flex flex-column py-2">
                        <h6 class="book-title mb-1">
                            {{ $book->ten_sach }}
                        </h6>

                        <div class="mb-1">
                            <span class="book-price">
                                {{ number_format($book->gia) }} đ
                            </span>
                        </div>

                        <small class="text-muted mb-2">
                            📦 Đã bán: {{ $book->da_ban }}
                        </small>

                        <a href="{{ url('/chitietsach/'.$book->id) }}"
                           class="btn btn-danger btn-sm mt-auto w-100 fw-bold">
                            Xem chi tiết
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center mt-5">
        {{ $books->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

</div>

<style>
    .book-card {
        border-radius: 14px;
        overflow: hidden;
        transition: 0.25s ease;
        background: #fff;
    }

    .book-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    }

    .book-img-wrapper {
        height: 220px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .book-img {
        width: 80%;
        height: 85%;
        object-fit: contain;
    }

    .book-title {
        font-size: 14px;
        font-weight: 700;
        color: #222;
        min-height: 40px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-price {
        font-size: 16px;
        font-weight: 600;
        color: #e60023;
    }

    /* FIX PAGINATION */
    .pagination {
        margin: 0;
        gap: 8px;
    }

    .pagination .page-link {
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 14px;
        color: #dc3545;
        border: 1px solid #ddd;
    }

    .pagination .page-item.active .page-link {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .pagination svg {
        width: 16px !important;
        height: 16px !important;
    }
</style>
</x-book-layout>