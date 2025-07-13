<x-guest-layout>
    <div class="auth-container">
        <div class="card">
            <div class="logo-container">
                <center>
                    <img src="{{ asset('images/logohrmis.png') }}" alt="Logo HRMIS" class="logo-img">
                </center>
            </div>

            <div class="text-center">
                <h2 class="mb-4">Menunggu Persetujuan</h2>
                <div class="alert alert-info">
                    <p>Registrasi Anda telah berhasil!</p>
                    <p>Silakan tunggu persetujuan dari HRD untuk dapat mengakses sistem.</p>
                    <p>Anda akan diberitahu melalui email setelah akun Anda disetujui.</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn btn-primary">Kembali ke Login</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background: linear-gradient(to right, #CAF4FF, #005daf);
        }
        .auth-container {
            background: unset !important;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 30px;
            margin: 0 auto;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-img {
            max-width: 150px;
            height: auto;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-info {
            background-color: #e3f2fd;
            border: 1px solid #90caf9;
            color: #0d47a1;
        }
        .btn-primary {
            background: #5AB2FF;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary:hover {
            background: #4098D7;
        }
    </style>
</x-guest-layout> 