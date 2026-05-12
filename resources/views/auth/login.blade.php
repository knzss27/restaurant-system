<!DOCTYPE html>
<html lang="mn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нэвтрэх | Crust&Grill</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --brand: #ff9d01;
            --brand-dark: #e28500;
            --ink: #202020;
            --muted: #6f6f6f;
        }

        body {
            min-height: 100vh;
            background:
                linear-gradient(rgba(255, 255, 255, 0.86), rgba(255, 255, 255, 0.86)),
                url("{{ asset('images/crust_grill_banner.png') }}") center/cover no-repeat;
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
        }

        .auth-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .auth-card {
            width: 100%;
            max-width: 460px;
            background: #fff;
            border: 0;
            border-radius: 8px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.14);
            overflow: hidden;
        }

        .brand-strip {
            padding: 28px 32px 18px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .brand-strip img {
            width: 150px;
            max-width: 70%;
        }

        .form-wrap {
            padding: 28px 32px 32px;
        }

        .form-label {
            color: var(--ink);
            font-weight: 700;
            font-size: 0.9rem;
        }

        .form-control {
            border-radius: 999px;
            border: 1px solid #e4e4e4;
            padding: 12px 18px;
        }

        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 0.2rem rgba(255, 157, 1, 0.18);
        }

        .btn-auth {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
            border-radius: 999px;
            font-weight: 700;
            padding: 12px 18px;
        }

        .btn-auth:hover {
            background: var(--brand-dark);
            border-color: var(--brand-dark);
            color: #fff;
        }

        .auth-link {
            color: var(--brand);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-link:hover {
            color: var(--brand-dark);
        }
    </style>
</head>

<body>
    <main class="auth-shell">
        <section class="auth-card">
            <div class="brand-strip">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/crust_grill_logo.png') }}" alt="Crust&Grill">
                </a>
                <h1 class="h4 fw-bold mt-4 mb-1">Нэвтрэх</h1>
                <p class="text-muted mb-0">Захиалгаа үргэлжлүүлэхийн тулд нэвтэрнэ үү.</p>
            </div>

            <div class="form-wrap">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">И-мэйл хаяг</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}"
                            placeholder="example@email.com" required autofocus autocomplete="username">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Нууц үг</label>
                        <input id="password" type="password" name="password" class="form-control"
                            placeholder="Нууц үгээ оруулна уу" required autocomplete="current-password">
                    </div>

                    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label class="form-check-label text-muted" for="remember_me">Сануулах</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="auth-link small" href="{{ route('password.request') }}">Нууц үг мартсан?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-auth w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Нэвтрэх
                    </button>
                </form>

                <p class="text-center text-muted mt-4 mb-0">
                    Бүртгэлгүй юу?
                    <a href="{{ route('register') }}" class="auth-link">Бүртгүүлэх</a>
                </p>
            </div>
        </section>
    </main>
</body>

</html>
