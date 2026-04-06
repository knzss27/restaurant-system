<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нэвтрэх</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f3f3;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 420px;
            background: #fff;
            padding: 40px 35px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 34px;
            font-weight: bold;
            color: #222;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        .required {
            color: red;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 15px;
            box-sizing: border-box;
        }

        .links {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-top: 6px;
            margin-bottom: 18px;
        }

        .links a,
        .extra-link a,
        .register-text a {
            color: #b3002d;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            background: #c7002f;
            color: white;
            border: none;
            padding: 15px;
            font-size: 18px;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #a80028;
        }

        .divider {
            margin: 26px 0 18px;
            border: none;
            border-top: 1px solid #ddd;
        }

        .register-text {
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <h2>Нэвтрэх</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label>
                        И-мэйл эсвэл Утасны дугаар оруулах <span class="required">*</span>
                    </label>
                    <input type="text" name="login" placeholder="Э-мэйл эсвэл утасны дугаараа оруулна уу">
                </div>

                <div class="form-group">
                    <label>
                        Нууц үг
                        <a href="#" style="color:#b3002d;">Нэг удаагийн код илгээх</a>
                        <span class="required">*</span>
                    </label>
                    <input type="password" name="password" placeholder="Нууц үг">
                </div>

                <div class="extra-link" style="text-align:right; margin-bottom:20px;">
                    <a href="#">Нууц үг сэргээх</a>
                </div>

                <button type="submit" class="btn-login">Нэвтрэх</button>
            </form>

            <hr class="divider">

            <div class="register-text">
                Бүртгэлтэй хаяг байхгүй <a href="{{ route('register') }}">Бүртгүүлэх</a>
            </div>
        </div>
    </div>
</body>
</html>