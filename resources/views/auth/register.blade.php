<style>
    body {
        background: linear-gradient(to right, #CAF4FF, #005daf);
    }
    .auth-container {
        background: unset !important;
    }
</style>

<x-guest-layout>
    <div class="auth-container">
        <div class="card">
            <div class="logo-container">
                <center>
                    <img src="{{ asset('images/logohrmis.png') }}" alt="Logo HRMIS" class="logo-img">
                </center>
            </div>

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- <div class="col-md-3 text-center mb-4">
                        <div class="form-group">
                            <label style="text-align: left;">Foto Profil</label>
                            <input type="file" name="profile_photo" class="form-control" accept="image/*">
                        </div>
                    </div> -->
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                                    @error('username')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email Aktif</label>
                                    <input type="email" name="email_active" class="form-control @error('email_active') is-invalid @enderror" value="{{ old('email_active') }}">
                                    @error('email_active')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                                    @error('nip')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Departemen</label>
                                    <input type="text" name="departement" class="form-control @error('departement') is-invalid @enderror" value="{{ old('departement') }}" required>
                                    @error('departement')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control" required>
                                        <option value="hrd" {{ old('role') === 'hrd' ? 'selected' : '' }}>HRD</option>
                                        <option value="karyawan" {{ old('role') === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Alamat Rumah</label>
                                    <textarea name="home_address" class="form-control @error('home_address') is-invalid @enderror">{{ old('home_address') }}</textarea>
                                    @error('home_address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Alamat Tempat Kerja</label>
                                    <textarea name="work_address" class="form-control @error('work_address') is-invalid @enderror">{{ old('work_address') }}</textarea>
                                    @error('work_address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Mulai Kerja</label>
                                    <input type="date" name="join_date" id="join_date" class="form-control @error('join_date') is-invalid @enderror" value="{{ old('join_date') }}">
                                    @error('join_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                    <a href="{{ route('login') }}" class="btn btn-link">Sudah punya akun? Login</a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #f8f9fa;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
            padding: 30px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-img {
            max-width: 150px;
            height: auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #5AB2FF;
            outline: none;
            box-shadow: 0 0 0 2px rgba(90, 178, 255, 0.2);
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
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
        }

        .btn-primary:hover {
            background: #4098D7;
        }

        .btn-link {
            color: #5AB2FF;
            text-decoration: none;
            margin-left: 10px;
        }

        .btn-link:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        function calculateWorkDuration() {
            const joinDate = document.getElementById('join_date').value;
            if (joinDate) {
                const join = new Date(joinDate);
                const now = new Date();
                const diffTime = now - join;
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                document.getElementById('work_duration_days').value = diffDays + ' hari';
            } else {
                document.getElementById('work_duration_days').value = '';
            }
        }
        document.getElementById('join_date').addEventListener('change', calculateWorkDuration);
        window.addEventListener('DOMContentLoaded', calculateWorkDuration);
    </script>
</x-guest-layout>
