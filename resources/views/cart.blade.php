@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Таны сагс</h1>

        @if (empty($cart))
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" class="img-fluid mb-3 px-4 opacity-50"
                    alt="Empty Cart" style="max-width: 200px;">
                <h4>Сагс хоосон байна</h4>
                <p class="text-muted">Бүтээгдэхүүн нэмэхийн тулд <a href="{{ route('menu') }}">цэс</a> руу очно уу.</p>
            </div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    @foreach ($cart as $productId => $item)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ $item['image'] }}" class="img-fluid rounded" alt="{{ $item['name'] }}">
                                    </div>
                                    <div class="col-md-4">
                                        <h5>{{ $item['name'] }}</h5>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="mb-0">{{ number_format($item['price']) }}₮</p>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control quantity-input"
                                            data-product-id="{{ $productId }}" value="{{ $item['quantity'] }}"
                                            min="1">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-danger btn-sm remove-item"
                                            data-product-id="{{ $productId }}">Хасах</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Захиалгын дэлгэрэнгүй</h5>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>Нийт:</span>
                                <span
                                    id="total-amount">{{ number_format(array_sum(array_map(function ($item) {return $item['price'] * $item['quantity'];}, $cart))) }}₮</span>
                            </div>
                            <a href="{{ route('checkout') }}" class="btn btn-success w-100 mt-3">Захиалах</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update quantity
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const productId = this.getAttribute('data-product-id');
                    const quantity = this.value;
                    fetch(`/cart/update/${productId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload(); // Simple reload to update total
                            }
                        });
                });
            });

            // Remove item
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    fetch(`/cart/remove/${productId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            }
                        });
                });
            });
        });
    </script>
@endsection
