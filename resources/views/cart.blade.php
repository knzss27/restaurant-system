@extends('layouts.app')

@section('content')
    <style>
        .cart-page-title {
            font-weight: 800;
            color: #202020;
        }

        .cart-item-card,
        .order-summary-card,
        .empty-cart-card {
            border: 0;
            border-radius: 8px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.07);
        }

        .cart-item-image {
            width: 92px;
            height: 92px;
            object-fit: contain;
            background: #fff8ed;
            border-radius: 8px;
            padding: 10px;
        }

        .quantity-input {
            max-width: 88px;
            border-radius: 999px;
            border-color: #ead8bf;
            text-align: center;
            font-weight: 700;
        }

        .btn-brand {
            background: #ff9d01;
            border-color: #ff9d01;
            color: #fff;
            border-radius: 999px;
            font-weight: 800;
            padding: 12px 18px;
        }

        .btn-brand:hover {
            background: #e28500;
            border-color: #e28500;
            color: #fff;
        }

        .text-brand {
            color: #ff9d01 !important;
        }

        .btn-soft-brand {
            background: #fff8ed;
            border: 1px solid #f1d6ad;
            color: #b96b00;
            border-radius: 999px;
            font-weight: 700;
        }

        .btn-soft-brand:hover {
            background: #ffefd6;
            color: #8f5200;
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 12px;
            color: #6c6f75;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            border-top: 1px dashed #ead8bf;
            padding-top: 18px;
            margin-top: 18px;
            font-size: 1.15rem;
            font-weight: 900;
        }
    </style>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h1 class="cart-page-title mb-1">Таны сагс</h1>
                <p class="text-muted mb-0">Захиалгаа шалгаад үргэлжлүүлнэ үү.</p>
            </div>
            <a href="{{ route('menu') }}" class="btn btn-outline-danger rounded-pill px-4">Цэс рүү буцах</a>
        </div>

        @if (empty($cart))
            <div class="empty-cart-card bg-white text-center py-5 px-4">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" class="img-fluid mb-3 px-4 opacity-50"
                    alt="Empty Cart" style="max-width: 190px;">
                <h4 class="fw-bold">Сагс хоосон байна</h4>
                <p class="text-muted">Амтат хоолноосоо сонгоод сагсандаа нэмээрэй.</p>
                <a href="{{ route('menu') }}" class="btn btn-brand px-5">Цэс харах</a>
            </div>
        @else
            @php
                $subtotal = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));
                $deliveryFee = 0;
                $total = $subtotal + $deliveryFee;
            @endphp

            <div class="row g-4 align-items-start">
                <div class="col-lg-8">
                    @foreach ($cart as $productId => $item)
                        <div class="cart-item-card bg-white mb-3">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
                                    <img src="{{ $item['image'] }}" class="cart-item-image" alt="{{ $item['name'] }}">

                                    <div class="flex-grow-1">
                                        <h5 class="fw-bold mb-1">{{ $item['name'] }}</h5>
                                        <p class="text-brand fw-bold mb-0">{{ number_format($item['price']) }}₮</p>
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <input type="number" class="form-control quantity-input"
                                            data-product-id="{{ $productId }}" value="{{ $item['quantity'] }}"
                                            min="1">
                                        <div class="fw-bold text-nowrap">
                                            {{ number_format($item['price'] * $item['quantity']) }}₮
                                        </div>
                                    </div>

                                    <button class="btn btn-soft-brand btn-sm remove-item"
                                        data-product-id="{{ $productId }}">
                                        <i class="bi bi-x-circle me-1"></i> Хасах
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="order-summary-card bg-white sticky-top" style="top: 96px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Захиалгын дэлгэрэнгүй</h5>

                            <div class="summary-line">
                                <span>Бүтээгдэхүүн</span>
                                <span>{{ count($cart) }}</span>
                            </div>
                            <div class="summary-line">
                                <span>Дүн</span>
                                <span>{{ number_format($subtotal) }}₮</span>
                            </div>
                            <div class="summary-line">
                                <span>Хүргэлт</span>
                                <span>Дараа тооцно</span>
                            </div>

                            <div class="summary-total">
                                <span>Нийт</span>
                                <span class="text-brand" id="total-amount">{{ number_format($total) }}₮</span>
                            </div>

                            <a href="{{ route('checkout') }}" class="btn btn-brand w-100 mt-4">
                                Захиалах
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const productId = this.getAttribute('data-product-id');
                    const quantity = Math.max(1, parseInt(this.value || '1', 10));

                    fetch(`/cart/update/${productId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ quantity })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) location.reload();
                        });
                });
            });

            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    fetch(`/cart/remove/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) location.reload();
                        });
                });
            });
        });
    </script>
@endsection
