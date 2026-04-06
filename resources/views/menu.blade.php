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
    }
    .product-card:hover { transform: translateY(-5px); }
    
    /* Зургийг харуулах тохиргоо */
    .product-card img { 
        height: 160px; 
        object-fit: contain; 
        padding: 1rem; 
    }
    
    /* Секшнүүдийг нуух/харуулах */
    .menu-section { display: none; }
    .menu-section.active { display: block; animation: fadeIn 0.4s ease-in-out; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); } 
        to { opacity: 1; transform: translateY(0); }
    }

    .cart-sidebar { position: sticky; top: 100px; border-radius: 1.5rem; }
</style>

<div class="bg-white border-bottom mb-4 shadow-sm">
    <div class="container">
        <ul class="nav nav-justified nav-underline py-2">
            <li class="nav-item"><a class="nav-link tab-link active" onclick="openMenu(event, 'bagts')">Багц</a></li>
            <li class="nav-item"><a class="nav-link tab-link" onclick="openMenu(event, 'pizza')">Пицца</a></li>
            <li class="nav-item"><a class="nav-link tab-link" onclick="openMenu(event, 'burger')">Бургер</a></li>
            <li class="nav-item"><a class="nav-link tab-link" onclick="openMenu(event, 'undaa')">Ундаа</a></li>
            <li class="nav-item"><a class="nav-link tab-link" onclick="openMenu(event, 'nemelt')">Нэмэлт</a></li>
        </ul>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        <main class="col-lg-9">
            
            <section id="bagts" class="menu-section active">
                <h4 class="fw-bold mb-4">Онцлох багцууд</h4>
                <div class="row g-4">
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/couple_set.svg') }}" class="card-img-top" alt="Хосын багц">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Хосын багц</h6>
                                <p class="text-muted small mb-2">Дунд пицца, 2 Бургер, 2 Ундаа</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">55,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/friends_set.svg') }}" class="card-img-top" alt="Найзуудын багц">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Найзууд багц</h6>
                                <p class="text-muted small mb-2">Том пицца, Тахианы далавч, 4 Ундаа</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">85,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/family_set.svg') }}" class="card-img-top" alt="Гэр бүлийн багц">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Гэр бүлийн багц</h6>
                                <p class="text-muted small mb-2">Том пицца, 3 Бургер, Шарсан төмс, 2л Ундаа</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">95,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pizza" class="menu-section">
                <h4 class="fw-bold mb-4">Пицца</h4>
                <div class="row g-4">
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/pepperoni.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Пепперони Пицца</h6>
                                <p class="text-muted small mb-2">Сонгодог итали пепперони</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">28,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/margherita.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Маргарита Пицца</h6>
                                <p class="text-muted small mb-2">Шинэхэн бяслаг, лооль</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">24,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/meat_lovers.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Махны цуглуулга</h6>
                                <p class="text-muted small mb-2">Үхэр, гахай, тахианы мах</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">32,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/hawaiian.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Хавайн Пицца</h6>
                                <p class="text-muted small mb-2">Хан боргоцой, утсан мах</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">29,500₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/vegan.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Веган Пицца</h6>
                                <p class="text-muted small mb-2">Шинэхэн ногооны холимог</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">26,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="burger" class="menu-section">
                <h4 class="fw-bold mb-4">Амтлаг Бургер</h4>
                <div class="row g-4">
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/standart_burger.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Сонгодог Бургер</h6>
                                <p class="text-muted small mb-2">Үхрийн мах, бяслаг</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">12,500₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/double_cheese.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Чизбургер</h6>
                                <p class="text-muted small mb-2">Давхар чеддар бяслагтай</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">13,500₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/tusgai_burger.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">BBQ Бургер</h6>
                                <p class="text-muted small mb-2">Утсан соус, шарсан сонгино</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">15,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/chicken_burger.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Тахиан махтай</h6>
                                <p class="text-muted small mb-2">Шаржигнуур тахиа, майонез</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">11,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/double_burger.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Double Tower</h6>
                                <p class="text-muted small mb-2">Хоёр давхар мах, өндөг</p>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">19,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="undaa" class="menu-section">
                <h4 class="fw-bold mb-4">Ундаа, Шүүс</h4>
                <div class="row g-4">
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/cola_1.5L.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Coca Cola 1.5L</h6>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">4,500₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/cola_0.5L.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Coca Cola 0.5L</h6>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">2,500₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/lemonade.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Orange Juice</h6>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">3,500₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/icedtea.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Lipton Iced Tea</h6>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">3,000₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <img src="{{ asset('images/menu/water.svg') }}" class="card-img-top">
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <h6 class="fw-bold mb-1">Цэвэр ус 0.5L</h6>
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">1,500₮</p>
                                    <button class="btn btn-outline-danger w-100 rounded-pill btn-sm">Нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="nemelt" class="menu-section">
                <h4 class="fw-bold mb-4">Нэмэлт бүтээгдэхүүн</h4>
                <div class="alert alert-warning border-0 shadow-sm rounded-4 text-center py-4">
                    Одоогоор нэмэлт бүтээгдэхүүн оруулаагүй байна.
                </div>
            </section>

        </main>

        <aside class="col-lg-3">
            <div class="card cart-sidebar border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <h5 class="fw-bold mb-4">Таны сагс</h5>
                    <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" class="img-fluid mb-3 px-4 opacity-50" alt="Empty Cart">
                    <p class="text-muted small">Сагс одоогоор хоосон байна.</p>
                    <hr class="my-4 opacity-25">
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Нийт дүн:</span>
                        <span class="fw-bold text-danger fs-5">0₮</span>
                    </div>
                    <button class="btn btn-secondary w-100 py-2 rounded-pill disabled">Захиалах</button>
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
            var btn = document.querySelector(`[onclick*="'${sectionName}'"]`);
            if (btn) btn.classList.add("active");
        }
    }

    // Хуудас ачаалагдахад URL шалгах
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        
        if (section) {
            openMenu(null, section);
            setTimeout(() => {
                const el = document.getElementById(section);
                if(el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    };
</script>
@endpush