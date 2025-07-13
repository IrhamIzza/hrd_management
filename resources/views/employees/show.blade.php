@extends('layouts.app')

@section('content')
<link href="{{ asset('css/employees.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Detail Karyawan</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center mb-4">
                        @if ($employee->profile_photo)
                            <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="Foto Profil"
                                class="img-fluid rounded-circle" style="max-width: 200px;">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 200px; height: 200px; margin: 0 auto;">
                                <i class="fas fa-user fa-4x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nama</label>
                                    <p>{{ $employee->name }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Username</label>
                                    <p>{{ $employee->username }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Email</label>
                                    <p>{{ $employee->email }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Email Aktif</label>
                                    <p>{{ $employee->email_active ?? '-' }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Lahir</label>
                                    <p>{{ $employee->birth_date ? $employee->birth_date->format('d/m/Y') : '-' }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">No. Telepon</label>
                                    <p>{{ $employee->phone }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">NIP</label>
                                    <p>{{ $employee->nip ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Departemen</label>
                                    <p>{{ $employee->departement }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Alamat Rumah</label>
                                    <p>{{ $employee->home_address ?? '-' }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Alamat Tempat Kerja</label>
                                    <p>{{ $employee->work_address ?? '-' }}</p>
                                </div>
                                @if (auth()->user()->isHrd())
                                    <div class="form-group">
                                        <label class="font-weight-bold">Role</label>
                                        <p>{{ ucfirst($employee->role) }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Jabatan</label>
                                        <p>{{ ucfirst($employee->position) ?? '-' }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tanggal Mulai Kerja</label>
                                        <p>{{ $employee->join_date ? $employee->join_date->format('d/m/Y') : '-' }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Status Kepegawaian</label>
                                        <p>{{ ucfirst($employee->employment_status) ?? '-' }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Durasi Kontrak</label>
                                        <p>{{ $employee->contract_duration ? $employee->contract_duration . ' bulan' : '-' }}
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Lama Bekerja</label>
                                        <p id="work-duration"
                                            data-join-date="{{ $employee->join_date ? $employee->join_date->format('Y-m-d') : '' }}">
                                            -</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tanggal Berakhir Kerja</label>
                                        <p id="end-date"
                                            data-join-date="{{ $employee->join_date ? $employee->join_date->format('Y-m-d') : '' }}"
                                            data-duration="{{ $employee->contract_duration ?? '' }}">-</p>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Ijazah</label>
                                        @if ($employee->ijazah)
                                            <p><a href="{{ asset('storage/' . $employee->ijazah) }}" target="_blank">Lihat
                                                    Ijazah</a></p>
                                        @else
                                            <p>-</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">SIP</label>
                                        @if ($employee->sip)
                                            <p><a href="{{ asset('storage/' . $employee->sip) }}" target="_blank">Lihat
                                                    SIP</a></p>
                                        @else
                                            <p>-</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Kartu Keluarga (KK)</label>
                                        @if ($employee->kk)
                                            <p><a href="{{ asset('storage/' . $employee->kk) }}" target="_blank">Lihat
                                                    KK</a></p>
                                        @else
                                            <p>-</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">KTP</label>
                                        @if ($employee->ktp)
                                            <p><a href="{{ asset('storage/' . $employee->ktp) }}" target="_blank">Lihat
                                                    KTP</a></p>
                                        @else
                                            <p>-</p>
                                        @endif
                                    </div>



                                    <div class="form-group">
                                        <label class="font-weight-bold">Sisa Waktu Bekerja</label>
                                        <p id="remaining-days">-</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            // Fungsi untuk menghitung lama bekerja
            function calculateDuration(joinDateStr) {
                if (!joinDateStr) return '-';
                const joinDate = new Date(joinDateStr);
                const now = new Date();

                let years = now.getFullYear() - joinDate.getFullYear();
                let months = now.getMonth() - joinDate.getMonth();
                let days = now.getDate() - joinDate.getDate();

                if (days < 0) {
                    months--;
                    const prevMonth = new Date(now.getFullYear(), now.getMonth(), 0);
                    days += prevMonth.getDate();
                }
                if (months < 0) {
                    years--;
                    months += 12;
                }

                let result = '';
                if (years > 0) result += `${years} tahun `;
                if (months > 0) result += `${months} bulan `;
                result += `${days} hari`;
                return result.trim();
            }

            // Fungsi untuk hitung tanggal akhir kontrak
            function calculateEndDate(joinDateStr, contractDurationMonths) {
                if (!joinDateStr || !contractDurationMonths) return null;
                const joinDate = new Date(joinDateStr);
                const endDate = new Date(joinDate);
                endDate.setMonth(endDate.getMonth() + parseInt(contractDurationMonths));
                return endDate;
            }

            // Fungsi untuk hitung sisa hari kerja
            function calculateRemainingDays(endDate) {
                if (!endDate) return '-';
                const now = new Date();
                const diff = endDate - now;
                const daysLeft = Math.ceil(diff / (1000 * 60 * 60 * 24));
                return daysLeft > 0 ? `${daysLeft} hari` : 'Kontrak berakhir';
            }


            // Lama Bekerja
            const el = document.getElementById('work-duration');
            const joinDate = el.getAttribute('data-join-date');
            if (el && joinDate) {
                el.textContent = calculateDuration(joinDate);
            }

            // Tanggal Berakhir Kerja & Sisa Waktu
            const endDateEl = document.getElementById('end-date');
            const remainingEl = document.getElementById('remaining-days');

            if (endDateEl) {
                const joinDateEnd = endDateEl.getAttribute('data-join-date');
                const duration = endDateEl.getAttribute('data-duration');
                const endDate = calculateEndDate(joinDateEnd, duration);

                if (endDate) {
                    // Format tanggal berakhir menjadi dd/mm/yyyy
                    const formatted =
                        `${endDate.getDate().toString().padStart(2, '0')}/${(endDate.getMonth()+1).toString().padStart(2, '0')}/${endDate.getFullYear()}`;
                    endDateEl.textContent = formatted;

                    if (remainingEl) {
                        remainingEl.textContent = calculateRemainingDays(endDate);
                    }
                }
            }
        </script>
    @endpush
@endsection
