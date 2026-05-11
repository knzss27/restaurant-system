@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h4>Захиалга #{{ $order->id }} - Дэлгэрэнгүй</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Захиалгын мэдээлэл</h5>
                                <p><strong>Статус:</strong>
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
                                    </span>
                                </p>
                                <p><strong>Нийт дүн:</strong> {{ number_format($order->total_amount) }}₮</p>
                                <p><strong>Огноо:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Хүргэлтийн мэдээлэл</h5>
                                <p><strong>Хаяг:</strong> {{ $order->delivery_address }}</p>
                                <p><strong>Утас:</strong> {{ $order->phone }}</p>
                                @if ($order->notes)
                                    <p><strong>Тайлбар:</strong> {{ $order->notes }}</p>
                                @endif
                            </div>
                        </div>

                        <h5>Захиалсан бүтээгдэхүүн</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Бүтээгдэхүүн</th>
                                        <th>Тоо ширхэг</th>
                                        <th>Үнэ</th>
                                        <th>Дэд дүн</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price) }}₮</td>
                                            <td>{{ number_format($item->subtotal) }}₮</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
