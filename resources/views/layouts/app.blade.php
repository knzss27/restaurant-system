<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Hut Mongolia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand img { width: 140px; }
        /* Чиний нэмсэн бусад ерөнхий CSS-үүд энд байж болно */
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/Pizza Hut_logo_desktop.svg') }}" alt="Pizza Hut Logo">
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-md-inline text-muted">Салбар сонгох</span>
                <button class="btn btn-outline-danger btn-sm rounded-pill px-4">Нэвтрэх</button>
            </div>
        </div>
    </nav>

    <div style="min-height: 60vh;">
        @yield('content')
    </div>

    <footer class="text-white pt-5 pb-4 mt-5" style="background-color: #1a1a1a;">
        <div class="container text-center text-md-start">
            <div class="row text-center text-md-start">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-danger">Pizza Hut</h5>
                    <p class="text-light opacity-75">Дэлхийд алдартай, хамгийн амттай пиццаг танд хүргэж байна. Халуунаар нь, хурдан хугацаанд!</p>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Цэс</h5>
                    <p><a href="{{ url('/menu') }}" class="text-white text-decoration-none">Онцлох багц</a></p>
                    <p><a href="{{ url('/menu') }}" class="text-white text-decoration-none">Пицца</a></p>
                    <p><a href="{{ url('/menu') }}" class="text-white text-decoration-none">Ундаа, Шүүс</a></p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Холбоо барих</h5>
                    <p>📞 Утас: 7555-5555</p>
                    <p>📧 И-мэйл: info@pizzahut.mn</p>
                    <p>📍 Хаяг: Эрдэнэт хот, Баян-Өндөр сум</p>
                </div>
            </div>
            <hr class="mb-4 border-light opacity-25">
            <div class="text-center">
                <p class="mb-0 small text-light opacity-50">© 2026 Pizza Hut Mongolia. Бүх эрх хуулиар хамгаалагдсан.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>