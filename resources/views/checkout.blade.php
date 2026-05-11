@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Захиалга баталгаажуулах</h4>
                    </div>
                    <div class="card-body">
                        <h5>Таны захиалсан бүтээгдэхүүн</h5>
                        <ul class="list-group mb-4">
                            @foreach ($cart as $productId => $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item['name'] }}
                                    <span class="badge bg-primary rounded-pill">{{ $item['quantity'] }} x
                                        {{ number_format($item['price']) }}₮</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mb-4">
                            <h5>Нийт дүн:
                                {{ number_format(array_sum(array_map(function ($item) {return $item['price'] * $item['quantity'];}, $cart))) }}₮
                            </h5>
                        </div>

                        <form action="{{ route('checkout.place') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="delivery_address" class="form-label">Хүргэлтийн хаяг</label>
                                <textarea class="form-control" id="delivery_address" name="delivery_address" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Утасны дугаар</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Нэмэлт тайлбар</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Захиалга өгөх</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
