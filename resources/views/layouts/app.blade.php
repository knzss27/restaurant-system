<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crust&Grill Mongolia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* 1. Ерөнхий тохиргоо */
        body { 
            background-color: #f8f9fa; 
            font-family: Arial, Helvetica, sans-serif; 
        }

        /* 2. Navbar болон Брэндинг */
        .navbar-brand img { width: 140px; }
        
        .nav-custom-link {
            font-family: Arial, sans-serif;
            font-weight: 400 !important;
            color: #4a4a4a !important; 
            font-size: 14px;
            text-decoration: none;
        }

        /* 3. Шар өнгөтэй товчлуурууд */
        .btn-danger {
            background-color: #ff9d01 !important; 
            border-color: #ff9d01 !important;
            font-family: Arial, sans-serif;
            font-weight: 400 !important;
            font-size: 14px;
            color: white !important;
        }

        .btn-outline-danger {
            color: #ff9d01 !important; 
            border-color: #ff9d01 !important;
            font-family: Arial, sans-serif;
            font-weight: 400 !important;
            font-size: 14px;
        }

        .btn-outline-danger:hover {
            background-color: #ff9d01 !important;
            color: white !important;
        }

        /* 4. Бусад текст болон эффектүүд */
        .text-danger {
            color: #ff9d01 !important;
        }

        html { scroll-behavior: smooth; }
        section { scroll-margin-top: 80px; }

        /* Баннерын дугуй буланг тохируулах */
        .rounded-4 { border-radius: 1.5rem !important; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/crust_grill_logo.png') }}" alt="Crust&Grill Logo">
            </a>
            <div class="d-flex align-items-center">
                <a href="{{ url('/') }}#about-section" class="me-3 d-none d-md-inline text-muted text-decoration-none small fw-normal">Бидний тухай</a>
                <a href="{{ url('/') }}#map-section" class="me-3 d-none d-md-inline text-muted text-decoration-none small fw-normal">Салбар сонгох</a>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-danger btn-sm rounded-pill px-4" onclick="window.location.href='{{ route('login') }}'">
                        Нэвтрэх
                    </button>
                    <button class="btn btn-danger btn-sm rounded-pill px-4" onclick="window.location.href='{{ route('register') }}'">
                        Бүртгүүлэх
                    </button>
                </div>
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
                    <h5 class="text-uppercase mb-4 fw-bold text-danger">Crust&Grill</h5>
                    <p class="text-light opacity-75">Дэлхийд алдартай, хамгийн амттай пицца болон бургерийг танд хүргэж байна. Халуун бас шинэхнээр нь, хурдан хугацаанд!</p>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Цэс</h5>
                    <p><a href="{{ url('/menu') }}?section=bagts" class="text-white text-decoration-none">Онцлох багц</a></p>
                    <p><a href="{{ url('/menu') }}?section=pizza" class="text-white text-decoration-none">Пицца</a></p>
                    <p><a href="{{ url('/menu') }}?section=burger" class="text-white text-decoration-none">Бургер</a></p>
                    <p><a href="{{ url('/menu') }}?section=undaa" class="text-white text-decoration-none">Ундаа, Шүүс</a></p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Холбоо барих</h5>
                    <p>📞 Утас: 8888-8888</p>
                    <p>📧 И-мэйл: info@crustandgrill.mn</p>
                    <p>📍 Хаяг: Эрдэнэт хот, Баян-Өндөр сум</p>
                </div>
            </div>
            <hr class="mb-4 border-light opacity-25">
            <div class="text-center">
                <p class="mb-0 small text-light opacity-50">© 2026 Crust&Grill Mongolia. Бүх эрх хуулиар хамгаалагдав.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>