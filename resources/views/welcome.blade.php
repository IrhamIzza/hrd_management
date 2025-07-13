<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to HRD'S APP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">

        <div>
            <h1>Welcome to Our App</h1>
            <div class="logo-container">
                <img src="{{ asset('images/logohrmis.png') }}" alt="Logo HRMIS" class="logo-img">
            </div>
            <p>Please log in or register to start using the application.</p>

            <div class="btn-group">
                <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn btn-register">Register</a>
            </div>

            <div class="footer">
                &copy; {{ date('Y') }} Application by Adindarsp ❤️
            </div>
        </div>
    </div>
</body>


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: linear-gradient(to right, #CAF4FF, #005daf);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .logo-container {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
        /* bisa kurangin lagi kalau mau */
    }

    .logo-img {
        height: 150px;
    }

    .container {
        background: #ffffff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 500px;
    }

    .container h1 {
        font-size: 32px;
        color: #005daf;
        margin-bottom: 16px;
    }

    .container p {
        color: #333;
        margin-bottom: 32px;
        font-size: 16px;
    }

    .btn-group {
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    .btn {
        padding: 12px 30px;
        border-radius: 50px;
        border: none;
        text-decoration: none;
        color: #fff;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-login {
        background: #005daf;
    }

    .btn-login:hover {
        background: #CAF4FF;
        ;
        color: #000000;
    }

    .btn-register {
        background: #CAF4FF;
        color: #5AB2FF;
    }

    .btn-register:hover {
        background: #005daf;
        color: #fff;
    }

    .footer {
        margin-top: 30px;
        font-size: 14px;
        color: #555;
    }
</style>

</html>
