@extends('layouts.app')

@section('content')
<style>
    /* Цэсний идэвхтэй төлөв */
    .nav-link { color: #555; font-weight: 600; cursor: pointer; border-bottom: 3px solid transparent; }
    .nav-link:hover { color: #ff9d01; }
    .nav-link.active { color: #ff9d01 !important; border-bottom: 3px solid #ff9d01; }

    /* Бүтээгдэхүүний карт */
    .product-card { 
        transition: transform 0.3s ease; 
        border: none; 
        border-radius: 1.5rem; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
        overflow: hidden;
        height: 100%;
    }
    .product-card:hover { transform: translateY(-5px); }
    
    .product-card img { 
        height: 180px; 
        object-fit: contain; 
        padding: 1rem; 
    }
    
    .menu-section { display: none; }
    .menu-section.active { display: block; animation: fadeIn 0.4s ease-in-out; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container mt-4">
    <ul class="nav justify-content-center mb-4 border-bottom">
        <li class="nav-item">
            <a class="nav-link tab-link active" onclick="openMenu(event, 'bagts')">ОНЦЛОХ БАГЦ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-link" onclick="openMenu(event, 'pizza')">ПИЦЦА</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-link" onclick="openMenu(event, 'burger')">БУРГЕР</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-link" onclick="openMenu(event, 'undaa')">УНДАА, ШҮҮС</a>
        </li>
    </ul>

    @php
        $categories = ['bagts' => 'Онцлох багц', 'pizza' => 'Пицца', 'burger' => 'Бургер', 'undaa' => 'Ундаа, Шүүс'];
    @endphp

    @foreach($categories as $key => $title)
        <div id="{{ $key }}" class="menu-section {{ $loop->first ? 'active' : '' }}">
            <h3 class="fw-bold mb-4">{{ $title }}</h3>
            <div class="row g-4">
                @forelse($products->where('category', $key) as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card product-card">
                            <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body text-center">
                                <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                                <p class="text-danger fw-bold mb-3">{{ number_format($product->price) }}₮</p>
                                <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагслах</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Энэ ангилалд одоогоор хоол байхгүй байна.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
    function openMenu(evt, sectionName) {
        var sections = document.getElementsByClassName("menu-section");
        for (var i = 0; i < sections.length; i++) {
            sections[i].classList.remove("active");
        }

        var tabLinks = document.getElementsByClassName("tab-link");
        for (var i = 0; i < tabLinks.length; i++) {
            tabLinks[i].classList.remove("active");
        }

        var targetSection = document.getElementById(sectionName);
        if (targetSection) {
            targetSection.classList.add("active");
        }

        if (evt) {
            evt.currentTarget.classList.add("active");
        }
    }

    // URL-аас section параметрийг шалгах (жишээ нь: /menu?section=pizza)
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        if (section) {
            openMenu(null, section);
            // Линкүүдийг бас идэвхжүүлэх
            const links = document.querySelectorAll('.tab-link');
            links.forEach(link => {
                if(link.getAttribute('onclick').includes(section)) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        }
    }
</script>
@endpush