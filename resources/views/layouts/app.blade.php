<!DOCTYPE html>
<html lang="mn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crust&Grill Mongolia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, Helvetica, sans-serif;
        }

        .navbar-brand img {
            width: 140px;
        }

        .btn-danger {
            background-color: #ff9d01 !important;
            border-color: #ff9d01 !important;
            color: #fff !important;
        }

        .btn-outline-danger {
            color: #ff9d01 !important;
            border-color: #ff9d01 !important;
        }

        .btn-outline-danger:hover {
            background-color: #ff9d01 !important;
            color: #fff !important;
        }

        .text-danger {
            color: #ff9d01 !important;
        }

        html {
            scroll-behavior: smooth;
        }

        section {
            scroll-margin-top: 80px;
        }

        .rounded-4 {
            border-radius: 1.5rem !important;
        }

        #preloader {
            position: fixed;
            inset: 0;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.8s ease-in-out;
        }

        .loader-wrapper {
            text-align: center;
        }

        .loader-logo {
            width: 180px;
            margin: 0 auto 5px;
            display: block;
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
                var(--c) 10px 42px, var(--b) 10px 30px, var(--c) 32px 0, var(--b) 46px 28px,
                var(--c) 42px 40px, var(--b) 28px 44px, #f6d353;
            background-size: 14px 14px, 6px 6px;
            animation: syncPulse 3s infinite ease-in-out, pizzaFill 5s infinite ease-in-out;
        }

        @keyframes syncPulse {
            0%, 100% {
                transform: scale(0.92);
                opacity: 0.4;
            }

            50% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes pizzaFill {
            0% {
                -webkit-mask: conic-gradient(#0000 0, #000 0);
            }

            60%, 100% {
                -webkit-mask: conic-gradient(#0000 360deg, #000 0);
            }
        }

        .loader-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loader-container {
            display: flex;
            justify-content: center;
        }

        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #ff9d01;
            color: #fff;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #e31837;
            color: #fff;
            border-radius: 50%;
            padding: 2px 7px;
            font-size: 12px;
            font-weight: bold;
            border: 2px solid #fff;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="loader-wrapper">
            <img src="{{ asset('images/crust_grill_logo.png') }}" alt="Crust&Grill Logo" class="loader-logo">
            <div class="loader-container">
                <div class="pizza-loader"></div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/crust_grill_logo.png') }}" alt="Crust&Grill Logo">
            </a>

            <div class="d-flex align-items-center">
                <a href="{{ route('home') }}#about-section" class="me-3 d-none d-md-inline text-muted text-decoration-none small fw-normal">Бидний тухай</a>
                <a href="{{ route('home') }}#map-section" class="me-3 d-none d-md-inline text-muted text-decoration-none small fw-normal">Салбар сонгох</a>

                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-danger btn-sm rounded-pill px-4">Захиалгууд</a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4">Гарах</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm rounded-pill px-4">Нэвтрэх</a>
                        <a href="{{ route('register') }}" class="btn btn-danger btn-sm rounded-pill px-4">Бүртгүүлэх</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div style="min-height: 60vh;">
        @yield('content')
    </div>

    @auth
        <a href="{{ route('cart.index') }}" class="floating-cart shadow">
            <i class="bi bi-cart3 fs-4"></i>
            @if(session('cart') && count(session('cart')) > 0)
                <span class="cart-count">
                    @php
                        $quantity = 0;
                        foreach (session('cart') as $item) {
                            $quantity += $item['quantity'];
                        }
                    @endphp
                    {{ $quantity }}
                </span>
            @endif
        </a>
    @endauth

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
        window.addEventListener('load', function () {
            const loader = document.getElementById('preloader');
            setTimeout(() => {
                loader.classList.add('loader-hidden');
            }, 500);
        });
    </script>

    @stack('scripts')
</body>

</html>
