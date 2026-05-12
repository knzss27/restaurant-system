@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 fw-bold">Таны сагс</h1>

    @if (empty($cart))
        @else
        <div class="row">
            <div class="col-lg-8">
                @foreach ($cart as $productId => $item)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ asset($item['image']) }}" class="img-fluid rounded" alt="{{ $item['name'] }}">
                                </div>
                                <div class="col-md-4">
                                    <h5 class="fw-bold">{{ $item['name'] }}</h5>
                                </div>
                                <div class="col-md-2 text-danger fw-bold">
                                    {{ number_format($item['price']) }}₮
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control quantity-input rounded-pill text-center"
                                        data-product-id="{{ $productId }}" value="{{ $item['quantity'] }}" min="1">
                                </div>
                                <div class="col-md-2 text-end">
                                    <button class="btn btn-danger btn-sm remove-item rounded-pill px-3"
                                        data-product-id="{{ $productId }}">
                                        <i class="bi bi-trash"></i> Хасах
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if(isset($recommendations) && count($recommendations) > 0)
                    <h4 class="mt-5 mb-4 fw-bold">Танд санал болгох нэмэлт амт</h4>
                    <div class="row g-3">
                        @foreach($recommendations as $rec)
                            <div class="col-md-3">
                                <div class="card h-100 border-0 shadow-sm text-center p-2">
                                    <img src="{{ asset($rec->image) }}" class="card-img p-2 mx-auto" style="height: 80px; width: auto; object-fit: contain;">
                                    <div class="card-body p-1">
                                        <h6 class="small fw-bold">{{ $rec->name }}</h6>
                                        <form action="{{ route('cart.add', $rec->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill w-100">Нэмэх</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Захиалгын дэлгэрэнгүй</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Нийт дүн:</span>
                            <span class="h4 fw-bold text-danger" id="total-amount">
                                {{ number_format(array_sum(array_map(function ($item) {return $item['price'] * $item['quantity'];}, $cart))) }}₮
                            </span>
                        </div>
                        <hr>
                        <a href="{{ route('checkout') }}" class="btn btn-danger w-100 py-3 rounded-pill fw-bold shadow-sm">
                            ЗАХИАЛАХ <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection