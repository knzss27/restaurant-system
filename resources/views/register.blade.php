<<<<<<< ours
@include('auth.register')
=======
<!DOCTYPE html>
<html lang="mn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Бүртгүүлэх</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
        }

        .card {
            max-width: 500px;
            margin: auto;
            margin-top: 60px;
            padding: 30px;
            border-radius: 10px;
        }

        .btn-custom {
            background: #ec8e12;
            color: white;
        }

        .btn-custom:hover {
            background: #ffa600;
        }
    </style>

</head>

<body>

    <div class="card shadow">

        <h4 class="text-center mb-4">Бүртгүүлэх</h4>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label>Овог, Нэр *</label>
                <input type="text" name="name" class="form-control" placeholder="Овог, Нэрээ бичнэ үү"
                    value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label>Утасны дугаар *</label>
                <div class="input-group">
                    <span class="input-group-text">976</span>
                    <input type="tel" name="phone" class="form-control" placeholder="Утасны дугаараа оруулна уу"
                        value="{{ old('phone') }}">
                </div>
            </div>

            <div class="mb-3">
                <label>И-Мэйл хаяг *</label>
                <input type="email" name="email" class="form-control" placeholder="И-Мэйл хаягаа оруулна уу"
                    value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label>Нууц үг *</label>
                <input type="password" name="password" class="form-control" placeholder="Нууц үг">
            </div>

            <div class="mb-3">
                <label>Нууц үг давтах *</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Нууц үг давтах">
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="terms" required>
                <label class="form-check-label" for="terms">
                    Үйлчилгээний нөхцөл зөвшөөрөх
                </label>
            </div>

            <button class="btn btn-custom w-100" type="submit">
                Бүртгүүлэх
            </button>
        </form>

        <p class="text-center mt-3">
            Хэрэв та бүртгэлтэй бол
            <a href="{{ route('login') }}" style="color:#ff9d01;">Нэвтрэх</a>
        </p>

    </div>

</body>

</html>
>>>>>>> theirs
