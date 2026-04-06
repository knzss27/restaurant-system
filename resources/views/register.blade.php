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
    background:#db182c;
    color:white;
}

.btn-custom:hover{
    background:#da3044;
}
</style>

</head>
<body>

<div class="card shadow">

<h4 class="text-center mb-4">Бүртгүүлэх</h4>

<form>

<div class="mb-3">
<label>Овог, Нэр *</label>
<input type="text" class="form-control" placeholder="Овог, Нэрээ бичнэ үү">
</div>

<div class="mb-3">
<label>Утасны дугаар *</label>

<div class="input-group">
<span class="input-group-text">976</span>
<input type="text" class="form-control" placeholder="Утасны дугаараа оруулна уу">
</div>

</div>

<div class="mb-3">
<label>И-Мэйл хаяг</label>
<input type="email" class="form-control" placeholder="И-Мэйл хаягаа оруулна уу">
</div>

<div class="mb-3">
<label>Нууц үг </label>
<input type="password" class="form-control" placeholder="Нууц үг">
</div>

<div class="form-check mb-3">
<input class="form-check-input" type="checkbox">
<label class="form-check-label">
Үйлчилгээний нөхцөл зөвшөөрөх
</label>
</div>

<button class="btn btn-custom w-100">
Бүртгүүлэх
</button>

</form>

<p class="text-center mt-3" >
    Хэрэв та бүртгэлтэй бол 
    <a href="{{ route('login') }}" style="color:#b3002d;">Нэвтрэх</a>
</p>

</div>

</body>
</html>