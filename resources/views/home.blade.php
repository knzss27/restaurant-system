@extends('layouts.app') @section('content')
<div class="container mt-5 mb-5 text-center">
    <div class="p-5 mb-4 rounded-3 shadow" style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);">
        <div class="container-fluid py-5">
            <h1 class="display-4 fw-bold text-danger mb-4">Хамгийн амттай пиццаг эндээс!</h1>
            <p class="col-md-8 mx-auto fs-5 text-muted mb-5">
                Найз нөхөд, гэр бүлээрээ хуваалцах дурсамж дүүрэн мөчүүдийг Pizza Hut-тай хамт өнгөрүүлээрэй.
            </p>
            <a href="{{ url('/menu') }}" class="btn btn-danger btn-lg rounded-pill px-5 py-3 fw-bold shadow">
                🍽 Цэс харах болон Захиалах
            </a>
        </div>
    </div>
</div>
<section id="about-section" class="py-5 bg-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4 text-danger">Бидний тухай</h2>
        <p class="lead">Pizza Hut бол дэлхийн хамгийн алдартай пиццаны сүлжээ бөгөөд бид хамгийн шинэхэн орцоор танд үйлчилдэг.</p>
    </div>
</section>

<section id="map-section" class="py-5 bg-white">
    <div class="container">
        <h2 class="fw-bold text-center mb-4">Салбарын байршил</h2>
        <div class="rounded-4 overflow-hidden shadow-sm">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2673.5!2d104.0!3d49.0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDnCsDAwJzAwLjAiTiAxMDTCsDAwJzAwLjAiRQ!5e0!3m2!1smn!2smn!4v123456789" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>
@endsection