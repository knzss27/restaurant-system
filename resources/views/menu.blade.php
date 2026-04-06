@extends('layouts.app')

@section('content')
<style>
    /* Цэсний идэвхтэй төлөв */
    .nav-link { color: #555; font-weight: 600; cursor: pointer; border-bottom: 3px solid transparent; }
    .nav-link:hover { color: #e31837; }
    .nav-link.active { color: #e31837 !important; border-bottom: 3px solid #e31837; }

    /* Бүтээгдэхүүний карт */
    .product-card { 
        transition: transform 0.2s; 
        border: none; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
    }
    .product-card:hover { transform: translateY(-5px); }
    .product-card img { height: 160px; object-fit: cover; }
    
    /* Секшнүүдийг нуух/харуулах */
    .menu-section { display: none; }
    .menu-section.active { display: block; animation: fadeIn 0.5s; }

    @keyframes fadeIn {
        from { opacity: 0; } to { opacity: 1; }
    }

    .cart-sidebar { position: sticky; top: 100px; }
</style>

<div class="bg-white border-bottom mb-4">
    <div class="container">
        <ul class="nav nav-justified nav-underline">
            <li class="nav-item">
                <a class="nav-link tab-link active" onclick="openMenu(event, 'bagts')">Багц</a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-link" onclick="openMenu(event, 'pizza')">Пицца</a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-link" onclick="openMenu(event, 'burger')">Бургер</a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-link" onclick="openMenu(event, 'undaa')">Ундаа</a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-link" onclick="openMenu(event, 'nemelt')">Нэмэлт</a>
            </li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="row">
        <main class="col-lg-9">
            
            <section id="bagts" class="menu-section active">
                <h4 class="fw-bold mb-4">🎁 Онцлох багцууд</h4>
                <div class="row g-4">
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/kimchi-pork-combo5245.png') }}" class="card-img-top" alt="Kimchi">
                            <div class="card-body text-center">
                                <h6 class="fw-bold">Кимчи Порк Багц</h6>
                                <p class="text-danger fw-bold mb-3">55,000₮</p>
                                <button class="btn btn-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/little-hutters-combo7691.png') }}" class="card-img-top" alt="Little Hutters">
                            <div class="card-body text-center">
                                <h6 class="fw-bold">Little Hutters Combo</h6>
                                <p class="text-danger fw-bold mb-3">30,000₮</p>
                                <button class="btn btn-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pizza" class="menu-section">
                <h4 class="fw-bold mb-4">🍕 Пиццанууд</h4>
                <div class="row g-4">
                    @foreach($products->where('category', 'pizza') as $product)
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ $product->image }}" class="card-img-top">
                            <div class="card-body text-center">
                                <h6 class="fw-bold">{{ $product->name }}</h6>
                                <p class="text-danger fw-bold mb-3">{{ number_format($product->price) }}₮</p>
                                <button class="btn btn-danger w-100 rounded-pill btn-sm">Сонгох</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            <section id="burger" class="menu-section">
                <h4 class="fw-bold mb-4">🍔 Амтлаг Бургерүүд</h4>
                <div class="row g-4">

                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/burger.png') }}" class="card-img-top" alt="Бургер">
                            <div class="card-body text-center">
                                <h6 class="fw-bold">Classic Beef Burger</h6>
                                <p class="text-danger fw-bold mb-3">12,500₮</p>
                                <button class="btn btn-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="undaa" class="menu-section">
                <h4 class="fw-bold mb-4">🥤 Ундаа, Шүүс</h4>
                <div class="row g-4">
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/pepsi-bottle-1500ml_800x.webp') }}" class="card-img-top" alt="Pepsi 1.5L">
                            <div class="card-body text-center">
                                <h6 class="fw-bold">Pepsi 1.5L</h6>
                                <p class="text-danger fw-bold mb-3">4,500₮</p>
                                <button class="btn btn-danger w-100 rounded-pill btn-sm">Нэмэх</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="nemelt" class="menu-section">
                <h4 class="fw-bold mb-4">🍟 Нэмэлт бүтээгдэхүүн</h4>
                <div class="alert alert-info">Одоогоор нэмэлт бүтээгдэхүүн байхгүй байна.</div>
            </section>

        </main>

        <aside class="col-lg-3">
            <div class="card cart-sidebar border-0 shadow-sm rounded-3">
                <div class="card-body text-center py-5">
                    <h5 class="fw-bold mb-3">Таны сагс</h5>
                    <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" class="img-fluid mb-3 px-4 opacity-50" alt="Empty Cart">
                    <p class="text-muted small">Сагс одоогоор хоосон байна.</p>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Нийт:</span>
                        <span class="fw-bold text-danger">0₮</span>
                    </div>
                    <button class="btn btn-secondary w-100 py-2 disabled">Захиалах</button>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openMenu(evt, sectionName) {
        // 1. Бүх секшнийг нуух
        var sections = document.getElementsByClassName("menu-section");
        for (var i = 0; i < sections.length; i++) {
            sections[i].classList.remove("active");
        }

        // 2. Бүх линкээс active классыг хасах
        var tabLinks = document.getElementsByClassName("tab-link");
        for (var i = 0; i < tabLinks.length; i++) {
            tabLinks[i].classList.remove("active");
        }

        // 3. Сонгосныг харуулах
        var targetSection = document.getElementById(sectionName);
        if (targetSection) {
            targetSection.classList.add("active");
        }

        // 4. Товчлуурыг идэвхтэй болгох
        if (evt) {
            evt.currentTarget.classList.add("active");
        } else {
            // Хэрэв URL-аас орж ирвэл тохирох товчлуурыг олоод active болгоно
            var btn = document.querySelector(`[onclick*="'${sectionName}'"]`);
            if (btn) btn.classList.add("active");
        }
    }

    // Хуудас ачаалагдахад URL-д байгаа section-ийг шалгах "Ухаалаг" хэсэг
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        
        if (section) {
            openMenu(null, section);
            // Хэрэв дэлгэц дээр харагдахгүй байвал тийшээ гүйлгэх (Scroll)
            document.getElementById(section).scrollIntoView();
        }
    };
</script>
@endpush