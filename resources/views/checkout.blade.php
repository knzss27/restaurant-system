@extends('layouts.app')

@section('content')
    <style>
        .qpay-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .qpay-modal-content {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            transform: scale(0.8);
            opacity: 0;
            animation: qpayZoomIn 0.3s forwards cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes qpayZoomIn {
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .qr-container img {
            width: 200px;
            height: 200px;
        }

        #card-details-section {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .checkout-card,
        .checkout-summary {
            border: 0;
            border-radius: 8px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.07);
        }

        .checkout-kicker,
        .text-brand {
            color: #ff9d01 !important;
        }

        .checkout-kicker {
            font-weight: 900;
            text-transform: uppercase;
            font-size: 0.78rem;
        }

        .checkout-input,
        .checkout-textarea {
            border-color: #ead8bf;
            border-radius: 8px;
            padding: 12px 14px;
        }

        .checkout-input:focus,
        .checkout-textarea:focus {
            border-color: #ff9d01;
            box-shadow: 0 0 0 0.2rem rgba(255, 157, 1, 0.18);
        }

        .btn-brand {
            background: #ff9d01;
            border-color: #ff9d01;
            color: #fff;
            border-radius: 999px;
            font-weight: 900;
            padding: 13px 18px;
        }

        .btn-brand:hover {
            background: #e28500;
            border-color: #e28500;
            color: #fff;
        }

        .checkout-item {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 0;
            border-bottom: 1px solid #f0e4d4;
        }

        .checkout-item:last-child {
            border-bottom: 0;
        }

        .mode-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff8ed;
            color: #b96b00;
            border-radius: 999px;
            padding: 8px 13px;
            font-weight: 800;
        }

        .payment-options {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .payment-option {
            cursor: pointer;
            display: block;
        }

        .payment-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .payment-card {
            min-height: 96px;
            border: 2px solid #f0e4d4;
            border-radius: 8px;
            background: #fff;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
        }

        .payment-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff8ed;
            color: #ff9d01;
            font-size: 1.25rem;
            flex: 0 0 auto;
        }

        .payment-option input:checked+.payment-card {
            border-color: #ff9d01;
            background: #fff8ed;
            box-shadow: 0 10px 24px rgba(255, 157, 1, 0.18);
        }

        .payment-option input:focus+.payment-card {
            box-shadow: 0 0 0 0.2rem rgba(255, 157, 1, 0.18);
        }

        @media (max-width: 576px) {
            .payment-options {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @php
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $fulfillmentType = $fulfillment['type'] ?? 'delivery';
        $savedAddress = $fulfillment['address'] ?? '';
        $selectedPayment = old('payment_method', 'null');
    @endphp

    <div class="container my-5">
        <div class="row g-4 align-items-start">
            <div class="col-lg-7">
                <div class="checkout-card bg-white">
                    <div class="card-body p-4 p-md-5">
                        <div class="checkout-kicker mb-2">Checkout</div>
                        <h1 class="h3 fw-bold mb-2">Захиалга баталгаажуулах</h1>
                        <p class="text-muted mb-4">Мэдээллээ шалгаад төлбөрийн хэлбэрээ сонгоно уу.</p>

                        <div class="mode-pill mb-4">
                            <i class="bi {{ $fulfillmentType === 'pickup' ? 'bi-shop' : 'bi-truck' }}"></i>
                            {{ $fulfillmentType === 'pickup' ? 'Очиж авах' : 'Хүргэлтээр авах' }}
                        </div>

                        <form action="{{ route('checkout.place') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="delivery_address" class="form-label fw-bold">Хүргэлтийн хаяг</label>
                                <textarea class="form-control checkout-textarea" id="delivery_address" name="delivery_address" rows="3" required>{{ old('delivery_address', $fulfillmentType === 'pickup' ? 'Crust&Grill салбар дээрээс авна' : $savedAddress) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label fw-bold">Утасны дугаар</label>
                                <input type="text" class="form-control checkout-input" id="phone" name="phone"
                                    value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Төлбөрийн хэлбэр</label>
                                <div class="payment-options">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="qpay" required
                                            {{ $selectedPayment === 'qpay' ? 'checked' : '' }}>
                                        <span class="payment-card">
                                            <span class="payment-icon"><i class="bi bi-qr-code"></i></span>
                                            <span>
                                                <strong class="d-block">QPay</strong>
                                                <small class="text-muted">QR уншуулж төлөх</small>
                                            </span>
                                        </span>
                                    </label>

                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="card" required
                                            {{ $selectedPayment === 'card' ? 'checked' : '' }}>
                                        <span class="payment-card">
                                            <span class="payment-icon"><i class="bi bi-credit-card-2-front"></i></span>
                                            <span>
                                                <strong class="d-block">Картаар</strong>
                                                <small class="text-muted">Банкны картаар төлөх</small>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div id="card-details-section" style="display: none;" class="mt-4">
                                    <div class="card checkout-card border-0 bg-light p-4">
                                        <h6 class="fw-bold mb-3"><i class="bi bi-shield-lock me-2 text-brand"></i>Картын
                                            мэдээлэл</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="small fw-bold text-muted">Картын эзэмшигчийн нэр</label>
                                                <input type="text" name="card_name" id="card_holder_name"
                                                    class="form-control checkout-input" placeholder="NAME SURNAME"
                                                    style="text-transform: uppercase;">
                                            </div>
                                            <div class="col-12">
                                                <label class="small fw-bold text-muted">Картын дугаар</label>
                                                <input type="text" name="card_number" class="form-control checkout-input"
                                                    placeholder="0000 0000 0000 0000">
                                            </div>
                                            <div class="col-6">
                                                <label class="small fw-bold text-muted">Хугацаа</label>
                                                <input type="text" name="card_expiry" class="form-control checkout-input"
                                                    placeholder="MM/YY">
                                            </div>
                                            <div class="col-6">
                                                <label class="small fw-bold text-muted">CVV</label>
                                                <input type="password" name="card_cvv" class="form-control checkout-input"
                                                    placeholder="***">
                                            </div>
                                        </div>
                                        <small class="text-muted mt-2 d-block" style="font-size: 0.7rem;">
                                            <i class="bi bi-info-circle me-1"></i> Таны картын мэдээлэл манай сервер дээр
                                            хадгалагдахгүй.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label fw-bold">Нэмэлт тайлбар</label>
                                <textarea class="form-control checkout-textarea" id="notes" name="notes" rows="2"
                                    placeholder="Жишээ: Орцны код, давхар, халуун ногоо багасгах гэх мэт">{{ old('notes') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-brand w-100">
                                <i class="bi bi-check2-circle me-1"></i> Захиалга өгөх
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="checkout-summary bg-white sticky-top" style="top: 96px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Таны захиалга</h5>

                        @foreach ($cart as $item)
                            <div class="checkout-item">
                                <div>
                                    <div class="fw-bold">{{ $item['name'] }}</div>
                                    <div class="text-muted small">{{ $item['quantity'] }} x
                                        {{ number_format($item['price']) }}₮</div>
                                </div>
                                <div class="fw-bold text-nowrap">{{ number_format($item['price'] * $item['quantity']) }}₮
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between pt-4">
                            <span class="text-muted">Дүн</span>
                            <strong>{{ number_format($subtotal) }}₮</strong>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="text-muted">Хүргэлт</span>
                            <strong>Дараа тооцно</strong>
                        </div>
                        <div class="d-flex justify-content-between border-top mt-4 pt-4 fs-5">
                            <span class="fw-bold">Нийт</span>
                            <strong class="text-brand">{{ number_format($subtotal) }}₮</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="qpay-modal" class="qpay-overlay" style="display: none;">
        <div class="qpay-modal-content">
            <div class="card checkout-card text-center p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">QPay-ээр төлөх</h5>
                    <button type="button" class="btn-close" onclick="closeQPayModal()"></button>
                </div>
                <div class="qr-container bg-light p-3 rounded mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=CrustAndGrillPayment" 
                         alt="QPay QR" class="img-fluid rounded shadow-sm">
                </div>
                <p class="text-muted small mb-3">Гүйлгээний утга дээр <strong>Утасны дугаараа</strong> заавал бичээрэй.</p>
                <button type="button" class="btn btn-brand w-100" onclick="closeQPayModal()">
                    Би төлбөрөө төлсөн
                </button>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach((input) => {
            input.addEventListener('change', function() {
                const cardSection = document.getElementById('card-details-section');
                const qpayModal = document.getElementById('qpay-modal');
                const holderNameInput = document.getElementById('card_holder_name');

                if (this.value === 'card') {
                    // Карт сонгогдвол харуулна
                    cardSection.style.display = 'block';
                    qpayModal.style.display = 'none';
                    
                    cardSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });

                    setTimeout(() => {
                        holderNameInput.focus();
                    }, 400);

                } else if (this.value === 'qpay') {
                    // QPay сонгогдвол модал гаргана
                    cardSection.style.display = 'none';
                    qpayModal.style.display = 'flex';
                }
            });
        });

        function closeQPayModal() {
            document.getElementById('qpay-modal').style.display = 'none';
        }

        // Хуудас ачаалахад Card сонгогдсон байвал харуулах
        window.addEventListener('load', function() {
            const checkedPayment = document.querySelector('input[name="payment_method"]:checked');
            if (checkedPayment && checkedPayment.value === 'card') {
                document.getElementById('card-details-section').style.display = 'block';
            }
        });
    </script>
@endsection