<x-book-layout>

    <div class="container py-4">

        <div class="mb-4">
            <h2 class="fw-bold">🔥 Top sách bán chạy</h2>
        </div>

        <div class="row g-4 gy-5">

            @foreach($books as $book)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                    <div class="card book-card h-100 border-0 shadow-sm">

                        <!-- IMAGE (CLICKABLE) -->
                        <a href="{{ url('/chitietsach/' . $book->id) }}" class="text-decoration-none">
                            <div class="book-img-wrapper">
                                <img src="{{ asset('storage/image/' . $book->hinh_anh) }}"
                                     class="book-img"
                                     alt="{{ $book->ten_sach }}">
                            </div>
                        </a>

                        <!-- BODY -->
                        <div class="card-body d-flex flex-column py-2">

                            <!-- TITLE -->
                            <h6 class="book-title mb-1">
                                {{ $book->ten_sach }}
                            </h6>

                            <!-- PRICE -->
                            <div class="mb-1">
                                <span class="book-price">
                                    {{ number_format($book->gia) }} đ
                                </span>
                            </div>

                            <!-- SOLD -->
                            <small class="text-muted mb-2">
                                📦 Đã bán: {{ $book->da_ban }}
                            </small>

                            <!-- BUTTON -->
                            <a href="{{ url('/chitietsach/' . $book->id) }}"
                               class="btn btn-danger btn-sm mt-auto w-100 fw-bold py-1">
                                Xem chi tiết
                            </a>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

    <style>
        .book-card {
            border-radius: 14px;
            overflow: hidden;
            transition: 0.25s ease;
            background: #fff;
            margin-bottom: 10px;
        }

        .book-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.18);
        }

        .book-img-wrapper {
            height: 220px;
            background: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .book-img {
            width: 80%;
            height: 85%;
            object-fit: contain;
            transition: 0.3s ease;
        }

        .book-card:hover .book-img {
            transform: scale(1.05);
        }

        .book-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #222;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 42px;
        }

        .book-price {
            font-size: 17px;
            font-weight: 500;
            color: #e60023;
        }

        .row {
            row-gap: 32px;
        }

        .col-12, .col-sm-6, .col-md-4, .col-lg-3 {
            padding-left: 14px;
            padding-right: 14px;
        }
    </style>

</x-book-layout>