@extends('layouts.app')

@section('content')
<style>
    /* Ерөнхий тохиргоо */
    .nav-link { color: #555; font-weight: 600; cursor: pointer; border-bottom: 3px solid transparent; }
    .nav-link:hover { color: #ff9d01; }
    .nav-link.active { color: #ff9d01 !important; border-bottom: 3px solid #ff9d01; }

    .product-card { 
        transition: transform 0.3s ease; 
        border: none; border-radius: 1.5rem; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
        overflow: hidden; height: 100%;
    }
    .product-card:hover { transform: translateY(-5px); }
    .product-card img { height: 180px; object-fit: contain; padding: 1rem; }
    
    .menu-section { display: none; }
    .menu-section.active { display: block; animation: fadeIn 0.4s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* WARP & STEPPER EFFECT */
    .cart-action-container {
        position: relative;
        height: 42px;
        width: 100%;
        perspective: 1000px;
    }

    .main-cart-btn {
        background-color: transparent;
        border: 2px solid #ff9d01;
        color: #ff9d01;
        width: 100%;
        height: 100%;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stepper-warp {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: #ff9d01;
        border-radius: 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 5px;
        opacity: 0;
        transform: scale(0.5) rotateX(90deg);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        pointer-events: none;
    }

    /* Hover хийхэд Warp эффект */
    .cart-action-container:hover .main-cart-btn {
        opacity: 0;
        transform: scale(1.2) rotateX(-90deg);
    }

    .cart-action-container:hover .stepper-warp {
        opacity: 1;
        transform: scale(1) rotateX(0deg);
        pointer-events: auto;
    }

    /* Segmented Stepper Style */
    .step-btn {
        width: 32px; height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    .step-btn:hover { background: rgba(255, 255, 255, 0.4); }

    .qty-display {
        color: white;
        font-weight: bold;
        font-size: 1.1rem;
        min-width: 30px;
    }

    .add-final-btn {
        background: white;
        color: #ff9d01;
        border: none;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.8rem;
        margin-left: 5px;
    }
</style>

<div class="container mt-4">
    <ul class="nav justify-content-center mb-4 border-bottom">
        <li class="nav-item"><a class="nav-link tab-link active" onclick="openMenu(event, 'bagts')">ОНЦЛОХ БАГЦ</a></li>
        <li class="nav-item"><a class="nav-link tab-link" onclick="openMenu(event, 'pizza')">ПИЦЦА</a></li>
        <li class="nav-item"><a class="nav-link tab-link" onclick="openMenu(event, 'burger')">БУРГЕР</a></li>
        <li class="nav-item"><a class="nav-link tab-link" onclick="openMenu(event, 'undaa')">УНДАА</a></li>
    </ul>

    @php $categories = ['bagts' => 'Онцлох багц', 'pizza' => 'Пицца', 'burger' => 'Бургер', 'undaa' => 'Ундаа']; @endphp

    @foreach($categories as $key => $title)
        <div id="{{ $key }}" class="menu-section {{ $loop->first ? 'active' : '' }}">
            <div class="row g-4">
                @foreach($products->where('category', $key) as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card product-card">
                            <img src="{{ asset($product->image) }}" class="card-img-top">
                            <div class="card-body text-center">
                                <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                                <p class="text-danger fw-bold mb-3">{{ number_format($product->price) }}₮</p>
                                
                                <div class="cart-action-container">
                                    <div class="main-cart-btn shadow-sm">Сагслах</div>
                                    
                                    <div class="stepper-warp">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="step-btn" onclick="updateQty(this, -1)">-</button>
                                            <span class="qty-display mx-2">1</span>
                                            <button type="button" class="step-btn" onclick="updateQty(this, 1)">+</button>
                                        </div>
                                        <form action="{{ route('cart.add', $product->id) }}" method="GET">
                                            <input type="hidden" name="quantity" value="1" class="hidden-qty">
                                            <input type="hidden" name="section" value="{{ $key }}">
                                            <button type="submit" class="add-final-btn shadow-sm">Нэмэх</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
    function updateQty(btn, change) {
        const container = btn.closest('.stepper-warp');
        const display = container.querySelector('.qty-display');
        const input = container.querySelector('.hidden-qty');
        let current = parseInt(display.innerText);
        current += change;
        if (current < 1) current = 1;
        display.innerText = current;
        input.value = current;
    }

    function openMenu(evt, sectionName) {
        document.querySelectorAll(".menu-section").forEach(s => s.classList.remove("active"));
        document.querySelectorAll(".tab-link").forEach(l => l.classList.remove("active"));
        document.getElementById(sectionName).classList.add("active");
        if (evt) evt.currentTarget.classList.add("active");
    }

    window.onload = function() {
        const section = new URLSearchParams(window.location.search).get('section');
        if (section) openMenu(null, section);
    }
</script>
@endpush