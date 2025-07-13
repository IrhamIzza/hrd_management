@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/employees.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Edit Karyawan</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Photo -->
                    <div class="form-group">
                        <label>Foto Profil</label>
                        <input type="file" name="profile_photo" class="form-control" accept="image/*">
                        @if ($employee->profile_photo)
                            <img src="{{ $employee->profile_photo_url }}" alt="Profile Photo" class="mt-2"
                                style="max-width: 200px;">
                        @endif
                    </div>

                    <!-- Basic Information -->
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control"
                            value="{{ old('username', $employee->username) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $employee->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email Aktif</label>
                        <input type="email" name="email_active" class="form-control"
                            value="{{ old('email_active', $employee->email_active) }}">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control"
                            value="{{ old('birth_date', $employee->birth_date?->format('Y-m-d')) }}">
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $employee->phone) }}" required>
                    </div>

                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip', $employee->nip) }}">
                    </div>

                    {{-- <div class="form-group">
                        <label>Departemen</label>
                        <input type="text" name="departement" class="form-control"
                            value="{{ old('departement', $employee->departement) }}" required>
                    </div> --}}

                    <div class="form-group">
                        <label>Departemen</label>
                        <input type="text" name="departement" class="form-control"
                            placeholder="Mohon selalu di isi dengan Departemen Kesehatan"
                            value="{{ old('departement', $employee->departement) }}">
                    </div>


                    <div class="form-group">
                        <label>Alamat Rumah</label>
                        <textarea name="home_address" class="form-control">{{ old('home_address', $employee->home_address) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Alamat Tempat Kerja</label>
                        <textarea name="work_address" class="form-control">{{ old('work_address', $employee->work_address) }}</textarea>
                    </div>

                    <!-- Admin Only Fields -->
                    @if (auth()->user()->isHrd())
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                <option value="karyawan" {{ $employee->role === 'karyawan' ? 'selected' : '' }}>Karyawan
                                </option>
                                <option value="hrd" {{ $employee->role === 'hrd' ? 'selected' : '' }}>HRD</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jabatan</label>
                            <select name="position" class="form-control">
                                <option value="">Pilih Jabatan</option>
                                <option value="dokter" {{ $employee->position === 'dokter' ? 'selected' : '' }}>Dokter
                                </option>
                                <option value="perawat" {{ $employee->position === 'perawat' ? 'selected' : '' }}>Perawat
                                </option>
                                <option value="bidan" {{ old('position') === 'bidan' ? 'selected' : '' }}>Bidan
                                </option>
                                <option value="ttk" {{ old('position') === 'ttk' ? 'selected' : '' }}>TTK
                                </option>
                                <option value="kepala_dokter" {{ old('position') === 'kepala_dokter' ? 'selected' : '' }}>
                                    Kepala Dokter</option>
                                <option value="manager" {{ old('position') === 'manager' ? 'selected' : '' }}>Manager
                                </option>
                                <option value="analis" {{ old('position') === 'analis' ? 'selected' : '' }}>Analis</option>
                                <option value="supervisor" {{ old('position') === 'supervisor' ? 'selected' : '' }}>
                                    Supervisor</option>
                                <option value="kepala_cabang" {{ old('position') === 'kepala_cabang' ? 'selected' : '' }}>
                                    Kepala Cabang</option>
                                <option value="apoteker" {{ old('position') === 'apoteker' ? 'selected' : '' }}>
                                    Apoteker</option>
                                <option value="ahligizi" {{ old('position') === 'ahligizi' ? 'selected' : '' }}>Ahli Gizi
                                </option>
                                <option value="others" {{ old('position') === 'others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Mulai Kerja</label>
                            <input type="date" name="join_date" id="join_date" class="form-control"
                                value="{{ old('join_date', $employee->join_date?->format('Y-m-d')) }}">
                        </div>

                        <div class="form-group">
                            <label>Status Kepegawaian</label>
                            <select name="employment_status" class="form-control">
                                <option value="">Pilih Status</option>
                                <option value="tetap" {{ $employee->employment_status === 'tetap' ? 'selected' : '' }}>
                                    Tetap</option>
                                <option value="kontrak" {{ $employee->employment_status === 'kontrak' ? 'selected' : '' }}>
                                    Kontrak</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Durasi Kontrak (bulan)</label>
                            <input type="text" name="contract_duration" class="form-control"
                                value="{{ old('contract_duration', $employee->contract_duration) }}" min="1">
                        </div>

                        <div class="form-group">
                            <label>Lama Bekerja</label>
                            <input type="text" id="work_duration_days" class="form-control"
                                value="{{ $employee->work_duration_days }} hari" readonly>
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>


                    <!-- Dokumen Pendukung -->
                    <div class="form-group mb-4">
                        <label style="font-size: 1.2rem; font-weight: 600;">Ijazah</label>
                        @if ($employee->ijazah)
                            <a href="{{ asset('storage/' . $employee->ijazah) }}" target="_blank">
                                <img src="{{ asset('storage/' . $employee->ijazah) }}" alt="Ijazah"
                                    style="width: 200px; height: 200px; object-fit: cover; cursor: zoom-in;"
                                    class="d-block mt-2 img-thumbnail">
                            </a>
                        @endif
                        <input type="file" name="ijazah" class="form-control mt-2" style="font-size: 1rem;">
                    </div>

                    <div class="form-group mb-4">
                        <label style="font-size: 1.2rem; font-weight: 600;">SIP</label>
                        @if ($employee->sip)
                            <a href="{{ asset('storage/' . $employee->sip) }}" target="_blank">
                                <img src="{{ asset('storage/' . $employee->sip) }}" alt="SIP"
                                    style="width: 200px; height: 200px; object-fit: cover; cursor: zoom-in;"
                                    class="d-block mt-2 img-thumbnail">
                            </a>
                        @endif
                        <input type="file" name="sip" class="form-control mt-2" style="font-size: 1rem;">
                    </div>

                    <div class="form-group mb-4">
                        <label style="font-size: 1.2rem; font-weight: 600;">Kartu Keluarga (KK)</label>
                        @if ($employee->kk)
                            <a href="{{ asset('storage/' . $employee->kk) }}" target="_blank">
                                <img src="{{ asset('storage/' . $employee->kk) }}" alt="KK"
                                    style="width: 200px; height: 200px; object-fit: cover; cursor: zoom-in;"
                                    class="d-block mt-2 img-thumbnail">
                            </a>
                        @endif
                        <input type="file" name="kk" class="form-control mt-2" style="font-size: 1rem;">
                    </div>

                    <div class="form-group mb-4">
                        <label style="font-size: 1.2rem; font-weight: 600;">KTP</label>
                        @if ($employee->ktp)
                            <a href="{{ asset('storage/' . $employee->ktp) }}" target="_blank">
                                <img src="{{ asset('storage/' . $employee->ktp) }}" alt="KTP"
                                    style="width: 200px; height: 200px; object-fit: cover; cursor: zoom-in;"
                                    class="d-block mt-2 img-thumbnail">
                            </a>
                        @endif
                        <input type="file" name="ktp" class="form-control mt-2" style="font-size: 1rem;">
                    </div>


                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <div class="mt-4">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
@endpush
