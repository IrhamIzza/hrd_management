<x-guest-layout>
    <div class="auth-container">
        <div class="card">
            <div class="logo-container">
                <img src="{{ asset('images/logohrmis.png') }}" alt="Logo HRMIS" class="logo-img">
            </div>



            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                </div>

                <div class="remember-me">
                    <label for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                </div>

                <div class="form-actions">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">Forget your password?</a>
                    @endif

                    <button type="submit" class="btn-login">
                        Log in
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-primary hover:underline">Daftar di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>



    <style>

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
            /* bisa kurangin lagi kalau mau */
        }

        .logo-img {
            height: 250px;
        }

        body {
            background: linear-gradient(to right, #CAF4FF, #005daf);
            font-family: 'Poppins', sans-serif;
        }

        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* .card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        } */
        .card {
            background: #fff;
            padding: 20px 30px;
            /* dari 40px jadi 20px */
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }


        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 14px;
        }

        .form-group input:focus {
            border-color: #5AB2FF;
            outline: none;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 14px;
        }

        .remember-me input {
            margin-right: 10px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .forgot-password {
            font-size: 13px;
            color: #5AB2FF;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-login {
            background: #5AB2FF;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-login:hover {
            background: #4098D7;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: left;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: left;
        }

        .text-primary {
            color: #5AB2FF;
            text-decoration: none;
        }
        .text-primary:hover {
            text-decoration: underline;
        }
    </style>
</x-guest-layout>
