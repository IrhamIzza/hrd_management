@extends('layouts.app')

@section('content')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-primary text-white" >
                <h2 class="mb-0">Profil Saya</h2>
            </div>
            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            <div class="form-group">
                                <label>Foto Profil</label>
                                @if (auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto Profil"
                                        class="img-fluid rounded-circle mb-2" style="max-width: 200px;">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <i class="fas fa-user fa-4x text-white"></i>
                                    </div>
                                @endif
                                <center>
                                    <input type="file" name="profile_photo" class="form-control" accept="image/*">
                                </center>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ auth()->user()->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control"
                                            value="{{ auth()->user()->username }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ auth()->user()->email }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email Aktif</label>
                                        <input type="email" name="email_active" class="form-control"
                                            value="{{ auth()->user()->email_active }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="birth_date" class="form-control"
                                            value="{{ auth()->user()->birth_date ? auth()->user()->birth_date->format('Y-m-d') : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>No. Telepon</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ auth()->user()->phone }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>NIP</label>
                                        <input type="text" name="nip" class="form-control"
                                            value="{{ auth()->user()->nip }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Departemen</label>
                                        <input type="text" name="departement" class="form-control"
                                            value="{{ auth()->user()->departement }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Rumah</label>
                                        <textarea name="home_address" class="form-control">{{ auth()->user()->home_address }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Tempat Kerja</label>
                                        <textarea name="work_address" class="form-control">{{ auth()->user()->work_address }}</textarea>
                                    </div>
                                    @if (auth()->user()->isHrd())
                                        <div class="form-group">
                                            <label>Role</label>
                                            <input type="text" class="form-control"
                                                value="{{ ucfirst(auth()->user()->role) }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Jabatan</label>
                                            <input type="text" class="form-control"
                                                value="{{ ucfirst(auth()->user()->position) }}" readonly>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Tanggal Mulai Kerja</label>
                                        <input type="date" name="join_date" id="join_date" class="form-control"
                                            value="{{ auth()->user()->join_date ? auth()->user()->join_date->format('Y-m-d') : '' }}">
                                    </div>
                                    @if (auth()->user()->isHrd())
                                        <div class="form-group">
                                            <label>Status Kepegawaian</label>
                                            <input type="text" class="form-control"
                                                value="{{ ucfirst(auth()->user()->employment_status) }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Durasi Kontrak</label>
                                            <input type="text" class="form-control"
                                                value="{{ auth()->user()->contract_duration ? auth()->user()->contract_duration . ' bulan' : '-' }}"
                                                readonly>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Tanggal Berakhir Kerja</label>
                                        <input type="text" id="end_date" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Lama Bekerja</label>
                                        <input type="text" id="work_duration_days" class="form-control" readonly>
                                    </div>


                                    <div class="form-group">
                                        <label>Sisa Waktu Bekerja</label>
                                        <input type="text" id="remaining_days" class="form-control" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Password Baru</label>
                                        <input type="password" name="password" class="form-control">
                                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah
                                            password</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                
                    <div class="card-header bg-primary text-white">
                        <h2 class="mb-0">Unggah Dokumen</h2>
                    </div>

                    <div class="row">
                        {{-- Upload Ijazah --}}
                        <div class="col-md-6 text-center mb-8">
                            <div class="form-group">
                                <label>Upload Ijazah</label>
                                @php
                                    $ijazah = auth()->user()->ijazah;
                                    $ijazah_path = $ijazah ? asset('storage/' . $ijazah) : null;
                                    $ext = $ijazah ? pathinfo($ijazah_path, PATHINFO_EXTENSION) : null;
                                @endphp

                                @if ($ijazah)
                                    <a href="{{ $ijazah_path }}" target="_blank" title="Klik untuk membuka"
                                        class="d-block mb-2" style="width: 200px; height: 200px; margin: 0 auto;">
                                        @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width: 100%; height: 100%;">
                                                <img src="{{ $ijazah_path }}" alt="Ijazah"
                                                    style="max-width: 100%; max-height: 100%; object-fit: contain;" />
                                            </div>
                                        @else
                                            <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center"
                                                style="width: 100%; height: 100%;">
                                                <i class="fas fa-file-alt fa-3x text-primary mb-2"></i>
                                                <span style="font-size: 14px;">Lihat File</span>
                                            </div>
                                        @endif
                                    </a>
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <i class="fas fa-file-upload fa-4x text-white"></i>
                                    </div>
                                @endif

                                <center>
                                    <input type="file" name="ijazah" class="form-control"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                </center>
                            </div>
                        </div>

                        {{-- Upload SIP --}}
                        <div class="col-md-6 text-center mb-4">
                            <div class="form-group">
                                <label>Upload SIP</label>
                                @if (auth()->user()->sip)
                                    @php
                                        $sipPath = asset('storage/' . auth()->user()->sip);
                                        $sipExt = pathinfo(auth()->user()->sip, PATHINFO_EXTENSION);
                                    @endphp
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <a href="{{ $sipPath }}" target="_blank">
                                            @if (in_array($sipExt, ['jpg', 'jpeg', 'png']))
                                                <img src="{{ $sipPath }}"
                                                    style="max-width: 100%; max-height: 100%;" />
                                            @elseif ($sipExt == 'pdf')
                                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                            @elseif (in_array($sipExt, ['doc', 'docx']))
                                                <i class="fas fa-file-word fa-4x text-primary"></i>
                                            @else
                                                <i class="fas fa-file fa-4x text-dark"></i>
                                            @endif
                                        </a>
                                    </div>
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <i class="fas fa-file-upload fa-4x text-white"></i>
                                    </div>
                                @endif
                                <center>
                                    <input type="file" name="sip" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                </center>
                            </div>
                        </div>

                        {{-- Upload KTP --}}
                        <div class="col-md-6 text-center mb-4">
                            <div class="form-group">
                                <label>Upload KTP</label>
                                @if (auth()->user()->ktp)
                                    @php
                                        $ktpPath = asset('storage/' . auth()->user()->ktp);
                                        $ktpExt = pathinfo(auth()->user()->ktp, PATHINFO_EXTENSION);
                                    @endphp
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <a href="{{ $ktpPath }}" target="_blank">
                                            @if (in_array($ktpExt, ['jpg', 'jpeg', 'png']))
                                                <img src="{{ $ktpPath }}"
                                                    style="max-width: 100%; max-height: 100%;" />
                                            @elseif ($ktpExt == 'pdf')
                                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                            @elseif (in_array($ktpExt, ['doc', 'docx']))
                                                <i class="fas fa-file-word fa-4x text-primary"></i>
                                            @else
                                                <i class="fas fa-file fa-4x text-dark"></i>
                                            @endif
                                        </a>
                                    </div>
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <i class="fas fa-id-card fa-4x text-white"></i>
                                    </div>
                                @endif
                                <center>
                                    <input type="file" name="ktp" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                </center>
                            </div>
                        </div>

                        {{-- Upload Kartu Keluarga (KK) --}}
                        <div class="col-md-6 text-center mb-4">
                            <div class="form-group">
                                <label>Upload Kartu Keluarga (KK)</label>
                                @if (auth()->user()->kk)
                                    @php
                                        $kkPath = asset('storage/' . auth()->user()->kk);
                                        $kkExt = pathinfo(auth()->user()->kk, PATHINFO_EXTENSION);
                                    @endphp
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <a href="{{ $kkPath }}" target="_blank">
                                            @if (in_array($kkExt, ['jpg', 'jpeg', 'png']))
                                                <img src="{{ $kkPath }}"
                                                    style="max-width: 100%; max-height: 100%;" />
                                            @elseif ($kkExt == 'pdf')
                                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                            @elseif (in_array($kkExt, ['doc', 'docx']))
                                                <i class="fas fa-file-word fa-4x text-primary"></i>
                                            @else
                                                <i class="fas fa-file fa-4x text-dark"></i>
                                            @endif
                                        </a>
                                    </div>
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <i class="fas fa-file-upload fa-4x text-white"></i>
                                    </div>
                                @endif
                                <center>
                                    <input type="file" name="kk" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                </center>
                            </div>
                        </div>

                    </div>



                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="/dashboard" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script>
        function calculateWorkDuration() {
            const joinDateInput = document.getElementById('join_date').value;
            const workDurationField = document.getElementById('work_duration_days');
            const endDateField = document.getElementById('end_date');
            const remainingDaysField = document.getElementById('remaining_days');

            @php
                $contractDuration = auth()->user()->contract_duration ?? null;
            @endphp
            const contractDuration = {{ $contractDuration ?? 'null' }};

            if (joinDateInput) {
                const joinDate = new Date(joinDateInput);
                const now = new Date();

                // Hitung lama bekerja
                const diffTime = now - joinDate;
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                workDurationField.value = diffDays + ' hari';

                if (contractDuration) {
                    // Hitung tanggal berakhir kerja
                    const endDate = new Date(joinDate);
                    endDate.setMonth(endDate.getMonth() + contractDuration);

                    const year = endDate.getFullYear();
                    const month = String(endDate.getMonth() + 1).padStart(2, '0');
                    const day = String(endDate.getDate()).padStart(2, '0');
                    const formattedEndDate = `${year}-${month}-${day}`;
                    endDateField.value = formattedEndDate;

                    // Hitung sisa waktu kerja
                    const remainingMs = endDate - now;
                    const remainingDays = Math.max(Math.floor(remainingMs / (1000 * 60 * 60 * 24)), 0);
                    remainingDaysField.value = remainingDays + ' hari';
                } else {
                    endDateField.value = '-';
                    remainingDaysField.value = '-';
                }
            } else {
                workDurationField.value = '';
                endDateField.value = '';
                remainingDaysField.value = '';
            }
        }

        document.getElementById('join_date').addEventListener('change', calculateWorkDuration);
        window.addEventListener('DOMContentLoaded', calculateWorkDuration);
    </script>
@endpush
