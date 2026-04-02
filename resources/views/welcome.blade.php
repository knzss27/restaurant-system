<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Hut Mongolia - Laravel System</title>
    
    <!-- 1. Bootstrap CSS холбох -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Чиний бичсэн стилийг маш багасгаж, Bootstrap-тэй хослууллаа */
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .navbar-brand img { width: 80px; }
        
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
</head>
<body>

    <!-- HEADER / NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://upload.wikimedia.org/wikipedia/sco/thumb/d/d2/Pizza_Hut_logo.svg/1088px-Pizza_Hut_logo.svg.png" alt="Logo">
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-md-inline text-muted">Салбар сонгох</span>
                <button class="btn btn-outline-danger btn-sm rounded-pill px-4">Нэвтрэх</button>
            </div>
        </div>
    </nav>

    <!-- MENU NAVIGATION -->
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
                    <a class="nav-link tab-link" onclick="openMenu(event, 'undaa')">Ундаа</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-link" onclick="openMenu(event, 'nemelt')">Нэмэлт</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container">
        <div class="row">
            <main class="col-lg-9">
                
                <!-- БАГЦ ХЭСЭГ -->
                <section id="bagts" class="menu-section active">
                    <h4 class="fw-bold mb-4">🎁 Онцлох багцууд</h4>
                    <div class="row g-4">
                        <div class="col-md-4 col-6">
                            <div class="card product-card h-100">
                                <img src="https://via.placeholder.com/300x150" class="card-img-top" alt="Kimchi">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold">Кимчи Порк Багц</h6>
                                    <p class="text-danger fw-bold mb-3">55,000₮</p>
                                    <button class="btn btn-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="card product-card h-100">
                                <img src="https://via.placeholder.com/300x150" class="card-img-top" alt="Little Hutters">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold">Little Hutters Combo</h6>
                                    <p class="text-danger fw-bold mb-3">30,000₮</p>
                                    <button class="btn btn-danger w-100 rounded-pill btn-sm">Сагсанд нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ПИЦЦА ХЭСЭГ -->
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

                <!-- УНДАА ХЭСЭГ -->
                <section id="undaa" class="menu-section">
                    <h4 class="fw-bold mb-4">🥤 Ундаа, Шүүс</h4>
                    <div class="row g-4">
                        <div class="col-md-4 col-6">
                            <div class="card product-card h-100">
                                <img src="https://via.placeholder.com/300x150" class="card-img-top" alt="Pepsi">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold">Pepsi 1.5L</h6>
                                    <p class="text-danger fw-bold mb-3">4,500₮</p>
                                    <button class="btn btn-danger w-100 rounded-pill btn-sm">Нэмэх</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- НЭМЭЛТ ХЭСЭГ -->
                <section id="nemelt" class="menu-section">
                    <h4 class="fw-bold mb-4">🍟 Нэмэлт бүтээгдэхүүн</h4>
                    <div class="alert alert-info">Одоогоор нэмэлт бүтээгдэхүүн байхгүй байна.</div>
                </section>

            </main>

            <!-- SIDEBAR / CART -->
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

    <!-- 2. Bootstrap JS холбох -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function openMenu(evt, sectionName) {
            // Бүх секшнийг нуух
            var sections = document.getElementsByClassName("menu-section");
            for (var i = 0; i < sections.length; i++) {
                sections[i].classList.remove("active");
            }

            // Бүх линкээс active классыг хасах
            var tabLinks = document.getElementsByClassName("tab-link");
            for (var i = 0; i < tabLinks.length; i++) {
                tabLinks[i].classList.remove("active");
            }

            // Сонгосныг харуулах
            document.getElementById(sectionName).classList.add("active");
            evt.currentTarget.classList.add("active");
        }
    </script>
</body>
</html>