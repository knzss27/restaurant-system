@extends('layouts.app') 
@section('content')
<!-- Hero Section -->
<div class="container mt-4 mb-5">
    <div class="shadow-sm rounded-4 overflow-hidden">
        <img src="{{ asset('images/crust_grill_banner.png') }}" 
             alt="Crust&Grill Banner" 
             class="w-100 h-auto d-block">
    </div>
</div>

<!-- ШИНЭЧЛЭГДСЭН: Цэс section (Зурагтай хувилбар) -->
<section id="menu-section" class="py-5 bg-white">
    <div class="container">
        <!-- Толгой хэсэг: Гарчиг болон Бүгдийг харах линк -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="position-relative">
                <h2 class="fw-bold fs-4 mb-0" style="color: #333;">Меню харах</h2>
                <div style="width: 50px; height: 3px; background-color: #e31837; margin-top: 8px;"></div>
            </div>
            <a href="{{ url('/menu') }}" class="text-danger fw-bold text-decoration-none">
                Бүгдийг харуулах <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <!-- Цэсний дугуй зургууд -->
        <div class="row text-center g-4">
            <!-- Багц -->
            <div class="col-6 col-md-3">
                <a href="{{ url('/menu') }}?section=bagts" class="text-decoration-none group-item">
                    <div class="menu-circle-wrapper mx-auto mb-3">
                        <img src="{{ asset('images/menu/bagts.png') }}" alt="Багц" class="img-fluid">
                    </div>
                    <h6 class="fw-bold text-dark">Багц</h6>
                </a>
            </div>

            <!-- Пицца -->
            <div class="col-6 col-md-3">
                <a href="{{ url('/menu') }}?section=pizza" class="text-decoration-none group-item">
                    <div class="menu-circle-wrapper mx-auto mb-3">
                        <img src="{{ asset('images/menu/pizza.png') }}" alt="Пицца" class="img-fluid">
                    </div>
                    <h6 class="fw-bold text-dark">Пицца</h6>
                </a>
            </div>

            <!-- Бургер/Нэмэлт -->
            <div class="col-6 col-md-3">
                <a href="{{ url('/menu') }}?section=burger" class="text-decoration-none group-item">
                    <div class="menu-circle-wrapper mx-auto mb-3">
                        <img src="{{ asset('images/menu/burger.png') }}" alt="Бургер" class="img-fluid">
                    </div>
                    <h6 class="fw-bold text-dark">Бургер</h6>
                </a>
            </div>

            <!-- Ундаа -->
            <div class="col-6 col-md-3">
                <a href="{{ url('/menu') }}?section=undaa" class="text-decoration-none group-item">
                    <div class="menu-circle-wrapper mx-auto mb-3">
                        <img src="{{ asset('images/menu/drink.png') }}" alt="Ундаа" class="img-fluid">
                    </div>
                    <h6 class="fw-bold text-dark">Ундаа</h6>
                </a>
            </div>
        </div>
    </div>
</section>


<section id="about-section" class="py-5 bg-white border-top">
    <div class="container text-center py-4">
         <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/crust_grill_logo.png') }}" alt="Crust&Grill Logo" style="width: 500px; height: auto;">
            </a>
        <h2 class="fw-bold mb-4 text-danger text-uppercase">Бидний тухай</h2>
        
        <p class="lead text-muted mx-auto" style="max-width: 800px
            font-family:'Poppins', sans-serif;
            color:#e63946;
            font-weight:500;">
            Crust&Grill = Сайхан амт + Сайхан mood 
            Бид пиццаг шаржигнуулж, бургерыг шүүслэг болгож, 
            таны өдрийг илүү амттай болгоно. Найзуудтайгаа инээж, амттай хоол идэж, кайфтай цагийг өнгөрүүлэх хамгийн зөв газар бол Crust&Grill!
        </p>
    </div>
</section>


<!-- Газрын зураг section -->
<section id="map-section" class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-4">Салбарын байршил</h2>
        <div class="rounded-4 overflow-hidden shadow">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2673.5!2d104.0!3d49.0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDnCsDAwJzAwLjAiTiAxMDTCsDAwJzAwLjAiRQ!5e0!3m2!1smn!2smn!4v123456789" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

<!-- CSS Styles -->
<style>
    /* Дугуй хүрээний загвар */
    .menu-circle-wrapper {
        width: 160px;
        height: 160px;
        background-color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08); /* Зөөлөн сүүдэр */
        transition: all 0.3s ease;
        padding: 15px;
    }

    .menu-circle-wrapper img {
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    /* Хулгана дээгүүр очиход харагдах эффект */
    .group-item:hover .menu-circle-wrapper {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(227, 24, 55, 0.15);
    }

    .group-item:hover h6 {
        color: #e31837 !important;
    }

    /* Мобайл дээрх хэмжээг тохируулах */
    @media (max-width: 768px) {
        .menu-circle-wrapper {
            width: 120px;
            height: 120px;
        }
    }
</style>
@endsection