@extends('layouts.app')

@section('content')
<style>
    /* Цэсний идэвхтэй төлөв - Menu.blade-тэй ижил */
    .nav-link { color: #555; font-weight: 600; cursor: pointer; border-bottom: 3px solid transparent; }
    .nav-link:hover { color: #ff9d01; }
    .nav-link.active { color: #ff9d01 !important; border-bottom: 3px solid #ff9d01; }

    /* Бүтээгдэхүүний карт - Menu.blade-тэй ижил */
    .product-card { 
        transition: transform 0.3s ease; 
        border: none; 
        border-radius: 1.5rem; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
        overflow: hidden;
        background: #fff;
    }
    .product-card:hover { transform: translateY(-5px); }
    .product-card img { height: 160px; object-fit: contain; padding: 1rem; }
    
    /* Секшнүүдийг нуух/харуулах */
    .menu-section { display: none; }
    .menu-section.active { display: block; animation: fadeIn 0.4s ease-in-out; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); } 
        to { opacity: 1; transform: translateY(0); }
    }

    .admin-sidebar { position: sticky; top: 100px; border-radius: 1.5rem; }
    .category-badge { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: #ff9d01; fw-bold; }
</style>

<!-- ADMIN NAVIGATION TABS -->
<div class="bg-white border-bottom mb-4 shadow-sm">
    <div class="container">
        <ul class="nav nav-justified nav-underline py-2">
            <li class="nav-item">
                <a class="nav-link tab-link active" onclick="openMenu(event, 'add-new')"> Шинэ хоол нэмэх</a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-link" onclick="openMenu(event, 'manage-all')"> Жагсаалт удирдах</a>
            </li>
        </ul>
    </div>
</div>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <main class="col-lg-9">
            
            <!-- SECTION: ШИНЭ ХООЛ НЭМЭХ -->
            <section id="add-new" class="menu-section active">
                <h4 class="fw-bold mb-4"> Шинэ бүтээгдэхүүн бүртгэх</h4>
                <div class="card product-card p-4">
                    <form action="{{ route('product.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Хоолны нэр</label>
                                <input type="text" name="name" class="form-control rounded-pill border-0 bg-light px-3 py-2" placeholder="Жишээ: Пепперони пицца" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Үнэ (₮)</label>
                                <input type="number" name="price" class="form-control rounded-pill border-0 bg-light px-3 py-2" placeholder="28000" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Ангилал</label>
                                <select name="category" class="form-select rounded-pill border-0 bg-light px-3 py-2">
                                    <option value="bagts">Багц</option>
                                    <option value="pizza">Пицца</option>
                                    <option value="burger">Бургер</option>
                                    <option value="undaa">Ундаа</option>
                                    <option value="nemelt">Нэмэлт</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Зургийн URL (asset эсвэл link)</label>
                                <input type="text" name="image" class="form-control rounded-pill border-0 bg-light px-3 py-2" placeholder="images/menu/pepperoni.svg" required>
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-warning text-white fw-bold px-5 rounded-pill shadow-sm" style="background-color: #ff9d01;">
                                    DATABASE-Д ХАДГАЛАХ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <!-- SECTION: ЖАГСААЛТ УДИРДАХ (Динамик) -->
            <section id="manage-all" class="menu-section">
                <h4 class="fw-bold mb-4"> Бүх бүтээгдэхүүнүүд</h4>
                <div class="row g-4">
                    @forelse($products as $product)
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100">
                            <!-- Зургийг asset() ашиглах эсвэл шууд URL байхаар тохируулсан -->
                            @php 
                                $imagePath = str_starts_with($product->image, 'http') ? $product->image : asset($product->image);
                            @endphp
                            <img src="{{ $imagePath }}" class="card-img-top" alt="{{ $product->name }}">
                            
                            <div class="card-body text-center d-flex flex-column pt-0">
                                <span class="category-badge mb-1">{{ $product->category }}</span>
                                <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                                
                                <div class="mt-auto">
                                    <p class="text-danger fw-bold mb-3">{{ number_format($product->price) }}₮</p>
                                    
                                    <!-- Устгах форм -->
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Та устгахдаа итгэлтэй байна уу?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100 rounded-pill btn-sm">Устгах</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Одоогоор бүтээгдэхүүн бүртгэгдээгүй байна.</p>
                    </div>
                    @endforelse
                </div>
            </section>

        </main>

        <!-- SIDEBAR: АДМИН ТАЙЛАН -->
        <aside class="col-lg-3">
            <div class="card admin-sidebar border-0 shadow-sm bg-white">
                <div class="card-body text-center py-5">
                    <h5 class="fw-bold mb-4">Админ мэдээлэл</h5>
                    <div class="display-5 fw-bold text-warning mb-1" style="color: #ff9d01 !important;">{{ $products->count() }}</div>
                    <p class="text-muted small">Нийт бүтээгдэхүүн</p>
                    <hr class="my-4 opacity-25">
                    
                    <div class="text-start px-2">
                        @foreach(['bagts' => 'Багц', 'pizza' => 'Пицца', 'burger' => 'Бургер', 'undaa' => 'Ундаа'] as $key => $label)
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">{{ $label }}:</span>
                            <span class="fw-bold">{{ $products->where('category', $key)->count() }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <a href="{{ route('menu') }}" class="btn btn-outline-dark w-100 rounded-pill mt-4">Сайт харах</a>
                </div>
            </div>
        </aside>
    </div>
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
        document.getElementById(sectionName).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>
@endpush