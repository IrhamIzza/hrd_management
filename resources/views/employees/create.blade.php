@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">{{ __('messages.add_employee') }}</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('messages.profile_photo') }}</label>
                        <input type="file" name="profile_photo" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.username') }}</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.email') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.active_email') }}</label>
                        <input type="email" name="email_active" class="form-control" value="{{ old('email_active') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.birth_date') }}</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.phone') }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.nip') }}</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.department') }}</label>
                        <input type="text" name="departement" class="form-control" value="{{ old('departement') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('messages.home_address') }}</label>
                        <textarea name="home_address" class="form-control">{{ old('home_address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>{{ __('messages.work_address') }}</label>
                        <textarea name="work_address" class="form-control">{{ old('work_address') }}</textarea>
                    </div>
                    @if (auth()->user()->isHrd())
                        <div class="form-group">
                            <label>{{ __('messages.role') }}</label>
                            <select name="role" class="form-control" required>
                                <option value="karyawan" {{ old('role') === 'karyawan' ? 'selected' : '' }}>
                                    {{ __('messages.employee') }}
                                </option>
                                <option value="hrd" {{ old('role') === 'hrd' ? 'selected' : '' }}>
                                    {{ __('messages.hrd') }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('messages.position') }}</label>
                            <select name="position" class="form-control">
                                <option value="">Pilih Jabatan</option>
                                <option value="dokter" {{ old('position') === 'dokter' ? 'selected' : '' }}>Dokter</option>
                                <option value="perawat" {{ old('position') === 'perawat' ? 'selected' : '' }}>Perawat
                                </option>
                                <option value="petugas_kebersihan"
                                    {{ old('position') === 'petugas_kebersihan' ? 'selected' : '' }}>Petugas Kebersihan
                                </option>
                                <option value="kepala_dokter" {{ old('position') === 'kepala_dokter' ? 'selected' : '' }}>
                                    Kepala Dokter</option>
                                <option value="manager" {{ old('position') === 'manager' ? 'selected' : '' }}>Manager
                                </option>
                                <option value="staff" {{ old('position') === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="supervisor" {{ old('position') === 'supervisor' ? 'selected' : '' }}>
                                    Supervisor</option>
                                <option value="kepala_cabang" {{ old('position') === 'kepala_cabang' ? 'selected' : '' }}>
                                    Kepala Cabang</option>
                                <option value="accounting" {{ old('position') === 'accounting' ? 'selected' : '' }}>
                                    Accounting</option>
                                <option value="finance" {{ old('position') === 'finance' ? 'selected' : '' }}>Finance
                                </option>
                                <option value="others" {{ old('position') === 'others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('messages.join_date') }}</label>
                            <input type="date" name="join_date" id="join_date" class="form-control"
                                value="{{ old('join_date') }}">
                        </div>
                        <div class="form-group">
                            <label>{{ __('messages.employment_status') }}</label>
                            <select name="employment_status" class="form-control">
                                <option value="">{{ __('messages.select_status') }}</option>
                                <option value="tetap" {{ old('employment_status') === 'tetap' ? 'selected' : '' }}>
                                    {{ __('messages.permanent') }}
                                </option>
                                <option value="kontrak" {{ old('employment_status') === 'kontrak' ? 'selected' : '' }}>
                                    {{ __('messages.contract') }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Durasi Kontrak (bulan)</label>
                            <input type="text" name="contract_duration" class="form-control"
                                value="{{ old('contract_duration') }}" min="1">
                        </div>
                        <div class="form-group">
                            <label>Lama Bekerja</label>
                            <input type="text" id="work_duration_days" class="form-control" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_berakhir_kerja">Tanggal Berakhir Kerja</label>
                            <input type="date" id="tanggal_berakhir_kerja" name="tanggal_berakhir_kerja"
                                class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="sisa_waktu_bekerja_hari">Sisa Waktu Bekerja (hari)</label>
                            <input type="number" id="sisa_waktu_bekerja_hari" name="sisa_waktu_bekerja_hari"
                                class="form-control" readonly>
                        </div>
                    @endif
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>

                </form>
            </div>
        </div>
    </div>
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
@endsection
