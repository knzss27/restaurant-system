<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crust&Grill Mongolia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        /* 1. Ерөнхий тохиргоо */
        body { 
            background-color: #f8f9fa; 
            font-family: Arial, Helvetica, sans-serif; 
        }

        /* 2. Navbar болон Брэндинг */
        .navbar-brand img { width: 140px; }
        
        /* 3. Өнгөний тохиргоо */
        .btn-danger {
            background-color: #ff9d01 !important; 
            border-color: #ff9d01 !important;
            color: white !important;
        }
        .btn-outline-danger {
            color: #ff9d01 !important; 
            border-color: #ff9d01 !important;
        }
        .btn-outline-danger:hover {
            background-color: #ff9d01 !important;
            color: white !important;
        }
        .text-danger {
            color: #ff9d01 !important;
        }

        html { scroll-behavior: smooth; }
        section { scroll-margin-top: 80px; }
        .rounded-4 { border-radius: 1.5rem !important; }

        /* --- PRELOADER STYLE (Чиний тааруулсан хэмнэл) --- */
        #preloader {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.8s ease-in-out;
        }

        .loader-wrapper { text-align: center; }

        .loader-logo { 
            width: 180px; 
            margin-bottom: 5px; 
            display: block;
            margin-left: auto;
            margin-right: auto;
            animation: syncPulse 3s infinite ease-in-out; 
        }

        .pizza-loader {
            width: 70px; 
            height: 70px; 
            border-radius: 50%;
            border: 6px solid #d1914b; 
            box-sizing: border-box;
            --c: no-repeat radial-gradient(farthest-side, #d64123 94%, #0000);
            --b: no-repeat radial-gradient(farthest-side, #000 94%, #0000);
            background:
                var(--c) 10px 14px, var(--b) 5px 14px, var(--c) 32px 20px, var(--b) 26px 14px,
                var(--c) 10px 42px, var(--b) 10px 30px, var(--c) 32px 0px, var(--b) 46px 28px,
                var(--c) 42px 40px, var(--b) 28px 44px, #f6d353; 
            background-size: 14px 14px, 6px 6px;
            /* Чиний тааруулсан 5s хугацаа */
            animation: syncPulse 3s infinite ease-in-out, pizzaFill 5s infinite ease-in-out;
        }

        @keyframes syncPulse {
            0%, 100% { transform: scale(0.92); opacity: 0.4; }
            50% { transform: scale(1); opacity: 1; }
        }

        @keyframes pizzaFill {
            0% { -webkit-mask: conic-gradient(#0000 0, #000 0); }
            60%, 70% { -webkit-mask: conic-gradient(#0000 360deg, #000 0); }
            100% { -webkit-mask: conic-gradient(#0000 360deg, #000 0); }
        }

        .loader-hidden { 
            opacity: 0; 
            pointer-events: none; 
        }

        .loader-container { display: flex; justify-content: center; }

        /* --- ХӨВДӨГ САГС STYLE --- */
        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #ff9d01;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            text-decoration: none;
            transition: transform 0.2s;
        }
        .cart-count {
            position: absolute;
            top: -5px; right: -5px;
            background-color: #e31837;
            color: white; border-radius: 50%;
            padding: 2px 7px; font-size: 12px; font-weight: bold;
            border: 2px solid white;
        }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="loader-wrapper">
            <img src="{{ asset('images/crust_grill_logo.png') }}" alt="Logo" class="loader-logo">
            <div class="loader-container">
                <div class="pizza-loader"></div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/crust_grill_logo.png') }}" alt="Crust&Grill Logo">
            </a>
            <div class="d-flex align-items-center">
                <a href="{{ url('/') }}#about-section" class="me-3 d-none d-md-inline text-muted text-decoration-none small fw-normal">Бидний тухай</a>
                <a href="{{ url('/') }}#map-section" class="me-3 d-none d-md-inline text-muted text-decoration-none small fw-normal">Салбар сонгох</a>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-danger btn-sm rounded-pill px-4" onclick="window.location.href='{{ route('login') }}'">Нэвтрэх</button>
                    <button class="btn btn-danger btn-sm rounded-pill px-4" onclick="window.location.href='{{ route('register') }}'">Бүртгүүлэх</button>
                </div>
            </div>
        </div>
    </nav>

    <div style="min-height: 60vh;">
        @yield('content')
    </div>

    <a href="{{ route('cart.index') }}" class="floating-cart shadow">
        <i class="bi bi-cart3 fs-4"></i>
        @if(session('cart') && count(session('cart')) > 0)
            <span class="cart-count">
                @php 
                    $quantity = 0;
                    foreach(session('cart') as $item) { $quantity += $item['quantity']; }
                @endphp
                {{ $quantity }}
            </span>
        @endif
    </a>

    <footer class="text-white pt-5 pb-4 mt-5" style="background-color: #1a1a1a;">
        <div class="container text-center text-md-start">
            <hr class="mb-4 border-light opacity-25">
            <div class="text-center">
                <p class="mb-0 small text-light opacity-50">© 2026 Crust&Grill Mongolia. Бүх эрх хуулиар хамгаалагдав.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Preloader control
        window.addEventListener("load", function () {
            const loader = document.getElementById("preloader");
            setTimeout(() => {
                loader.classList.add("loader-hidden");
            }, 500); 
        });
    </script>

    @stack('scripts')
</body>
</html>