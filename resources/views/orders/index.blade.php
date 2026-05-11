@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Миний захиалгууд</h1>

        @if ($orders->isEmpty())
            <div class="text-center py-5">
                <h4>Одоогоор захиалга байхгүй байна</h4>
                <a href="{{ route('menu') }}" class="btn btn-primary">Цэс үзэх</a>
            </div>
        @else
            <div class="row">
                @foreach ($orders as $order)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Захиалга #{{ $order->id }}</h5>
                                <p class="card-text">
                                    <strong>Нийт дүн:</strong> {{ number_format($order->total_amount) }}₮<br>
                                    <strong>Статус:</strong>
                                    <span
                                        class="badge 
                                    @if ($order->status == 'pending') bg-warning
                                    @elseif($order->status == 'confirmed') bg-info
                                    @elseif($order->status == 'preparing') bg-primary
                                    @elseif($order->status == 'ready') bg-success
                                    @elseif($order->status == 'delivered') bg-success
                                    @else bg-danger @endif">
                                        @switch($order->status)
                                            @case('pending')
                                                Хүлээгдэж байна
                                            @break

                                            @case('confirmed')
                                                Баталгаажсан
                                            @break

                                            @case('preparing')
                                                Бэлтгэж байна
                                            @break

                                            @case('ready')
                                                Бэлэн болсон
                                            @break

                                            @case('delivered')
                                                Хүргэгдсэн
                                            @break

                                            @case('cancelled')
                                                Цуцлагдсан
                                            @break
                                        @endswitch
                                    </span><br>
                                    <strong>Огноо:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
                                </p>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">Дэлгэрэнгүй
                                    үзэх</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
