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
@endsection