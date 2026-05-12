@extends('layouts.app')

@section('content')
<style>
    /* Ерөнхий тохиргоо */
    .nav-link { color: #555; font-weight: 600; cursor: pointer; border-bottom: 3px solid transparent; }
    .nav-link:hover { color: #ff9d01; }
    .nav-link.active { color: #ff9d01 !important; border-bottom: 3px solid #ff9d01; }

    .product-card { 
        transition: transform 0.3s ease; 
        border: none; border-radius: 1.5rem; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
        overflow: hidden; height: 100%;
    }
    .product-card:hover { transform: translateY(-5px); }
    .product-card img { height: 180px; object-fit: contain; padding: 1rem; }
    
    .menu-section { display: none; }
    .menu-section.active { display: block; animation: fadeIn 0.4s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* WARP & STEPPER EFFECT */
    .cart-action-container {
        position: relative;
        height: 42px;
        width: 100%;
        perspective: 1000px;
    }

    .main-cart-btn {
        background-color: transparent;
        border: 2px solid #ff9d01;
        color: #ff9d01;
        width: 100%;
        height: 100%;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stepper-warp {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: #ff9d01;
        border-radius: 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 5px;
        opacity: 0;
        transform: scale(0.5) rotateX(90deg);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        pointer-events: none;
    }

    /* Hover хийхэд Warp эффект */
    .cart-action-container:hover .main-cart-btn {
        opacity: 0;
        transform: scale(1.2) rotateX(-90deg);
    }

    .cart-action-container:hover .stepper-warp {
        opacity: 1;
        transform: scale(1) rotateX(0deg);
        pointer-events: auto;
    }

    /* Segmented Stepper Style */
    .step-btn {
        width: 32px; height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    .step-btn:hover { background: rgba(255, 255, 255, 0.4); }

    .qty-display {
        color: white;
        font-weight: bold;
        font-size: 1.1rem;
        min-width: 30px;
    }

    .add-final-btn {
        background: white;
        color: #ff9d01;
        border: none;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.8rem;
        margin-left: 5px;
    }

    .order-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.72);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px 16px;
        z-index: 2000;
    }

    .order-modal-backdrop.show {
        display: flex;
    }

    .order-modal {
        width: min(100%, 560px);
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.32);
        position: relative;
        overflow: visible;
    }

    .order-modal-close {
        position: absolute;
        top: -14px;
        right: -14px;
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 50%;
        background: #242424;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        line-height: 1;
        z-index: 2;
    }

    .order-tabs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-bottom: 1px solid #ececec;
    }

    .order-tab {
        min-height: 64px;
        border: 0;
        background: #f1f2f4;
        color: #6c6f75;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .order-tab.active {
        background: #fff;
        color: #ff9d01;
    }

    .order-tab-icon {
        width: 30px;
        height: 30px;
        border: 1px solid currentColor;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }

    .order-modal-body {
        padding: 28px 32px 32px;
    }

    .order-modal-title {
        color: #242424;
        font-size: 1rem;
        line-height: 1.65;
    }

    .order-address-row {
        display: grid;
        grid-template-columns: 1fr auto;
        border: 1px solid #d9dde5;
        border-radius: 5px;
        overflow: hidden;
    }

    .order-address-row input {
        border: 0;
        min-width: 0;
        padding: 13px 16px;
        outline: 0;
    }

    .order-location-btn {
        border: 0;
        background: #ff9d01;
        color: #fff;
        padding: 0 18px;
        font-weight: 800;
        white-space: nowrap;
    }

    .order-location-btn:hover {
        background: #ff9d01;
    }

    .order-confirm-btn {
        background: #ff9d01;
        border: 0;
        color: #fff;
        border-radius: 999px;
        padding: 12px 22px;
        font-weight: 800;
        min-width: 150px;
    }

    .order-confirm-btn:hover {
        background: #e28500;
    }

    .pickup-panel {
        display: none;
        border: 1px solid #ececec;
        border-radius: 6px;
        padding: 14px 16px;
        background: #fafafa;
    }

    .pickup-panel.show {
        display: block;
    }

    .erdenet-suggestions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: -2px 0 18px;
    }

    .place-chip {
        border: 1px solid #f1d6ad;
        background: #fff8ed;
        color: #9a5a00;
        border-radius: 999px;
        padding: 7px 12px;
        font-size: 0.86rem;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .place-chip:hover {
        background: #ff9d01;
        border-color: #ff9d01;
        color: #fff;
    }

    @media (max-width: 576px) {
        .order-modal-body {
            padding: 22px 18px 24px;
        }

        .order-address-row {
            grid-template-columns: 1fr;
        }

        .order-location-btn {
            min-height: 46px;
        }
    }
</style>

<div class="container mt-4">
    <ul class="nav justify-content-center mb-4 border-bottom">
        <li class="nav-item"><a class="nav-link tab-link active" onclick="openMenu(event, 'bagts')">ОНЦЛОХ БАГЦ</a></li>
        <li class="nav-item"><a class="nav-link tab-link" onclick="openMenu(event, 'pizza')">ПИЦЦА</a></li>
        <li class="nav-item"><a class="nav-link tab-link" onclick="openMenu(event, 'burger')">БУРГЕР</a></li>
        <li class="nav-item"><a class="nav-link tab-link" onclick="openMenu(event, 'undaa')">УНДАА</a></li>
    </ul>

    @php $categories = ['bagts' => 'Онцлох багц', 'pizza' => 'Пицца', 'burger' => 'Бургер', 'undaa' => 'Ундаа']; @endphp

    @foreach(['bagts' => 1, 'pizza' => 2, 'burger' => 3, 'undaa' => 4] as $key => $categoryId)
        <div id="{{ $key }}" class="menu-section {{ $loop->first ? 'active' : '' }}">
            <div class="row g-4">
                @foreach($products->where('category_id', $categoryId) as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card product-card">
                            <img src="{{ asset($product->image) }}" class="card-img-top">
                            <div class="card-body text-center">
                                <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                                <p class="text-danger fw-bold mb-3">{{ number_format($product->price) }}₮</p>
                                
                                <div class="cart-action-container">
                                    <div class="main-cart-btn shadow-sm">Сагслах</div>
                                    
                                    <div class="stepper-warp">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="step-btn" onclick="updateQty(this, -1)">-</button>
                                            <span class="qty-display mx-2">1</span>
                                            <button type="button" class="step-btn" onclick="updateQty(this, 1)">+</button>
                                        </div>
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1" class="hidden-qty">
                                            <input type="hidden" name="section" value="{{ $key }}">
                                            <button type="submit" class="add-final-btn shadow-sm">Нэмэх</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<div class="order-modal-backdrop" id="orderModal" aria-hidden="true">
    <div class="order-modal" role="dialog" aria-modal="true" aria-labelledby="orderModalTitle">
        <button type="button" class="order-modal-close" id="closeOrderModal" aria-label="Хаах">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="order-tabs">
            <button type="button" class="order-tab active" data-fulfillment="delivery">
                <span class="order-tab-icon"><i class="bi bi-truck"></i></span>
                Хүргэлтээр авах
            </button>
            <button type="button" class="order-tab" data-fulfillment="pickup">
                <span class="order-tab-icon"><i class="bi bi-shop"></i></span>
                Очих авах
            </button>
        </div>

        <div class="order-modal-body">
            <p class="order-modal-title mb-3" id="orderModalTitle">
                Бид танд амтат пиццагаар үйлчлэхэд бэлэн байна!
            </p>
            <p class="text-muted mb-3" id="deliveryHelp">
                Хаяг оруулж захиалга эхлүүлэх. Жич: Та сайтар шалгаж зөв хаяг оруулна уу
            </p>

            <div class="order-address-row mb-3" id="addressPanel">
                <input type="text" id="deliveryAddress" list="erdenetPlaceOptions" placeholder="Эрдэнэт хотын хаяг эсвэл газар оруулах">
                <button type="button" class="order-location-btn" id="locateMeBtn">
                    <i class="bi bi-geo-alt-fill"></i> Байршил олох
                </button>
            </div>

            <datalist id="erdenetPlaceOptions">
                <option value="Эрдэнэт үйлдвэр">
                <option value="Баян-Өндөр зах">
                <option value="Номин их дэлгүүр, Эрдэнэт">
                <option value="Орхон молл">
                <option value="Хангарьд палас">
                <option value="Эрдэнэт хотын төв талбай">
                <option value="Эрдэнэт автобусны буудал">
                <option value="Уурхайчин соёлын ордон">
                <option value="Мэдээлэл холбооны сүлжээ, Эрдэнэт">
                <option value="Орхон аймгийн Нэгдсэн эмнэлэг">
            </datalist>

            <div class="erdenet-suggestions" id="erdenetSuggestions">
                <button type="button" class="place-chip" data-address="Эрдэнэт үйлдвэр">Эрдэнэт үйлдвэр</button>
                <button type="button" class="place-chip" data-address="Баян-Өндөр зах">Баян-Өндөр зах</button>
                <button type="button" class="place-chip" data-address="Номин их дэлгүүр, Эрдэнэт">Номин</button>
                <button type="button" class="place-chip" data-address="Орхон молл">Орхон молл</button>
                <button type="button" class="place-chip" data-address="Хангарьд палас">Хангарьд палас</button>
                <button type="button" class="place-chip" data-address="Эрдэнэт хотын төв талбай">Төв талбай</button>
            </div>

            <div class="pickup-panel mb-3" id="pickupPanel">
                <strong>Crust&Grill салбар дээрээс авах</strong>
                <p class="text-muted small mb-0">Захиалгаа баталгаажуулаад, бэлтгэгдсэний дараа салбараас очиж аваарай.</p>
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" class="order-confirm-btn" id="confirmOrderMode">Сагсанд нэмэх</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let pendingCartForm = null;
    let selectedFulfillment = 'delivery';

    function updateQty(btn, change) {
        const container = btn.closest('.stepper-warp');
        const display = container.querySelector('.qty-display');
        const input = container.querySelector('.hidden-qty');
        let current = parseInt(display.innerText);
        current += change;
        if (current < 1) current = 1;
        display.innerText = current;
        input.value = current;
    }

    function openMenu(evt, sectionName) {
        document.querySelectorAll(".menu-section").forEach(s => s.classList.remove("active"));
        document.querySelectorAll(".tab-link").forEach(l => l.classList.remove("active"));
        document.getElementById(sectionName).classList.add("active");
        if (evt) evt.currentTarget.classList.add("active");
    }

    window.onload = function() {
        const section = new URLSearchParams(window.location.search).get('section');
        if (section) openMenu(null, section);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('orderModal');
        const closeBtn = document.getElementById('closeOrderModal');
        const confirmBtn = document.getElementById('confirmOrderMode');
        const addressInput = document.getElementById('deliveryAddress');
        const addressPanel = document.getElementById('addressPanel');
        const pickupPanel = document.getElementById('pickupPanel');
        const deliveryHelp = document.getElementById('deliveryHelp');
        const locateBtn = document.getElementById('locateMeBtn');
        const erdenetSuggestions = document.getElementById('erdenetSuggestions');

        document.querySelectorAll('.stepper-warp form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                pendingCartForm = form;
                modal.classList.add('show');
                modal.setAttribute('aria-hidden', 'false');
                addressInput.focus();
            });
        });

        document.querySelectorAll('.order-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                selectedFulfillment = this.dataset.fulfillment;

                document.querySelectorAll('.order-tab').forEach(item => item.classList.remove('active'));
                this.classList.add('active');

                const isPickup = selectedFulfillment === 'pickup';
                addressPanel.style.display = isPickup ? 'none' : 'grid';
                deliveryHelp.style.display = isPickup ? 'none' : 'block';
                erdenetSuggestions.style.display = isPickup ? 'none' : 'flex';
                pickupPanel.classList.toggle('show', isPickup);
            });
        });

        document.querySelectorAll('.place-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                addressInput.value = this.dataset.address;
                addressInput.classList.remove('is-invalid');
            });
        });

        closeBtn.addEventListener('click', closeOrderModal);
        modal.addEventListener('click', function(event) {
            if (event.target === modal) closeOrderModal();
        });

        locateBtn.addEventListener('click', function() {
            if (!navigator.geolocation) {
                addressInput.value = 'Таны төхөөрөмж байршил олох боломжгүй байна.';
                return;
            }

            locateBtn.disabled = true;
            locateBtn.innerHTML = '<i class="bi bi-geo-alt-fill"></i> Олж байна...';

            navigator.geolocation.getCurrentPosition(
                position => {
                    addressInput.value = `${position.coords.latitude.toFixed(6)}, ${position.coords.longitude.toFixed(6)}`;
                    locateBtn.disabled = false;
                    locateBtn.innerHTML = '<i class="bi bi-geo-alt-fill"></i> Байршил олох';
                },
                () => {
                    addressInput.value = 'Байршил авах боломжгүй байна. Хаягаа гараар оруулна уу.';
                    locateBtn.disabled = false;
                    locateBtn.innerHTML = '<i class="bi bi-geo-alt-fill"></i> Байршил олох';
                }
            );
        });

        confirmBtn.addEventListener('click', function() {
            if (!pendingCartForm) return;

            if (selectedFulfillment === 'delivery' && !addressInput.value.trim()) {
                addressInput.focus();
                addressInput.classList.add('is-invalid');
                return;
            }

            const formData = new FormData(pendingCartForm);
            formData.set('fulfillment_type', selectedFulfillment);
            formData.set('delivery_address', selectedFulfillment === 'delivery' ? addressInput.value.trim() : 'pickup');

            confirmBtn.disabled = true;
            confirmBtn.textContent = 'Нэмж байна...';

            fetch(pendingCartForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': pendingCartForm.querySelector('input[name="_token"]').value,
                },
                body: formData,
            })
                .then(response => {
                    if (!response.ok) throw new Error('Cart request failed');
                    return response.json();
                })
                .then(() => {
                    window.location.href = '{{ route('cart.index') }}';
                })
                .catch(() => {
                    pendingCartForm.submit();
                });
        });

        addressInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });

        function closeOrderModal() {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
            pendingCartForm = null;
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Сагсанд нэмэх';
        }
    });
</script>
@endpush
