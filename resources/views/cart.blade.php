@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold mb-4">Миний сагс</h2>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
                @if(session('cart') && count(session('cart')) > 0)
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Хоол</th>
                                    <th>Үнэ</th>
                                    <th>Тоо</th>
                                    <th>Нийт</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity']; @endphp
                                    <tr data-id="{{ $id }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($details['image']) }}" width="50" class="rounded me-3">
                                                <span class="fw-bold">{{ $details['name'] }}</span>
                                            </div>
                                        </td>
                                        <td>{{ number_format($details['price']) }}₮</td>
                                        <td><span class="badge bg-light text-dark p-2">{{ $details['quantity'] }} ш</span></td>
                                        <td class="fw-bold text-danger">{{ number_format($details['price'] * $details['quantity']) }}₮</td>
                                        <td>
                                            <button class="btn btn-sm btn-link text-muted remove-from-cart">
                                                <i class="bi bi-x-circle"></i> Устгах
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <h5>Таны сагс хоосон байна.</h5>
                        <a href="{{ url('/menu') }}" class="btn btn-danger rounded-pill mt-3">Цэс рүү буцах</a>
                    </div>
                @endif
            </div>

            @if(isset($recommendations) && count($recommendations) > 0)
            <div class="recommendation-container mt-5">
                <h5 class="fw-bold mb-4">Танд санал болгох</h5>
                <div class="carousel-wrapper position-relative">
                    <div id="recSlider" class="d-flex overflow-hidden" style="scroll-behavior: smooth;">
                        @foreach($recommendations as $product)
                            <div class="rec-item p-2">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                                    <img src="{{ asset($product->image) }}" class="mx-auto mb-2" style="height: 100px; object-fit: contain; width: 100%;">
                                    <h6 class="fw-bold small mb-1">{{ $product->name }}</h6>
                                    <p class="text-danger fw-bold small mb-2">{{ number_format($product->price) }}₮</p>
                                    <a href="{{ route('cart.add', $product->id) }}" class="btn btn-outline-danger btn-sm rounded-pill w-100">
                                        + Нэмэх
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="slider-btn prev" onclick="scrollSlider(-1)"><i class="bi bi-chevron-left"></i></button>
                    <button class="slider-btn next" onclick="scrollSlider(1)"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>
            @endif
        </div>

        @if(session('cart') && count(session('cart')) > 0)
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-4">Төлбөрийн мэдээлэл</h5>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fs-5 fw-bold">Нийт дүн:</span>
                    <span class="fs-5 fw-bold text-danger">{{ number_format($total) }}₮</span>
                </div>
                <a href="#" class="btn btn-danger w-100 py-3 rounded-pill fw-bold">Захиалга өгөх</a>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .carousel-wrapper { padding: 0 40px; }
    #recSlider { display: flex; gap: 15px; scroll-snap-type: x mandatory; overflow-x: hidden; }
    .rec-item { flex: 0 0 calc(25% - 12px); min-width: 180px; }
    .slider-btn {
        position: absolute; top: 50%; transform: translateY(-50%);
        width: 40px; height: 40px; background: white; border: 1px solid #ddd;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        z-index: 10; cursor: pointer;
    }
    .slider-btn.prev { left: 0; }
    .slider-btn.next { right: 0; }
</style>

{{-- Устгах үйлдлийн Script-ийг энд нэмэв --}}
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        
        // УСТГАХ ҮЙЛДЭЛ
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            if(confirm("Та энэ хоолыг сагснаас устгахдаа итгэлтэй байна уу?")) {
                $.ajax({
                    url: '{{ route("cart.remove") }}', // Энэ route зөв эсэхийг шалгаарай
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    },
                    error: function (xhr) {
                        alert("Алдаа гарлаа. Дахин оролдоно уу.");
                    }
                });
            }
        });

        // Carousel Slider функц
        window.scrollSlider = function(direction) {
            const slider = document.getElementById('recSlider');
            const scrollAmount = slider.offsetWidth / 2;
            slider.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
        }
    });
</script>
@endpush
@endsection