<!DOCTYPE html>
<html lang="mn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Бүртгүүлэх</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f5f5f5;
}

.card{
    max-width:500px;
    margin:auto;
    margin-top:60px;
    padding:30px;
    border-radius:10px;
}

.btn-custom{
    background:#ec8e12;
    color:white;
}

.btn-custom:hover{
    background:#ffa600;
}
</style>

</head>
<body>

<div class="card shadow">
    <h4 class="text-center mb-4">Бүртгүүлэх</h4>

    <!-- 1. action болон method-ийг заавал нэмнэ -->
    <form action="{{ route('register') }}" method="POST">
        <!-- 2. Laravel-д зориулсан хамгаалалтын код заавал байх ёстой -->
        @csrf 

        <div class="mb-3">
            <label>Овог, Нэр *</label>
            <!-- 3. name="name" нэмсэн -->
            <input type="text" name="name" class="form-control" placeholder="Овог, Нэрээ бичнэ үү" required>
        </div>

        <div class="mb-3">
            <label>Утасны дугаар *</label>
            <div class="input-group">
                <span class="input-group-text">976</span>
                <!-- 4. name="phone" нэмсэн -->
                <input type="text" name="phone" class="form-control" placeholder="Утасны дугаараа оруулна уу" required>
            </div>
        </div>

        <div class="mb-3">
            <label>И-Мэйл хаяг</label>
            <!-- 5. name="email" нэмсэн -->
            <input type="email" name="email" class="form-control" placeholder="И-Мэйл хаягаа оруулна уу" required>
        </div>

        <div class="mb-3">
            <label>Нууц үг </label>
            <!-- 6. name="password" нэмсэн -->
            <input type="password" name="password" class="form-control" placeholder="Нууц үг" required>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="terms" value="1" required>
            <label class="form-check-label">
                Үйлчилгээний нөхцөл зөвшөөрөх
            </label>
        </div>

        <!-- 7. type="submit" байх ёстой -->
        <button type="submit" class="btn btn-custom w-100">
            Бүртгүүлэх
        </button>
    </form>

    <p class="text-center mt-3" >
        Хэрэв та бүртгэлтэй бол 
        <a href="{{ route('login') }}" style="color:#ff9d01;">Нэвтрэх</a>
    </p>
</div>

</body>
</html>