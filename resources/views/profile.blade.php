@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-primary text-white" style="background: #000 !important;">
                <h2 class="mb-0">{{ __('messages.my_profile') }}</h2>


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
                                {{-- <label>Foto Profil</label> --}}
                                <label>{{ __('messages.profile_photo') }}</label>
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
                                        <label>{{ __('messages.name') }}</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ auth()->user()->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('messages.username') }}</label>
                                        <input type="text" name="username" class="form-control"
                                            value="{{ auth()->user()->username }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('messages.email') }}</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ auth()->user()->email }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('messages.active_email') }}</label>
                                        <input type="email" name="email_active" class="form-control"
                                            value="{{ auth()->user()->email_active }}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('messages.birth_date') }}</label>
                                        <input type="date" name="birth_date" class="form-control"
                                            value="{{ auth()->user()->birth_date ? auth()->user()->birth_date->format('Y-m-d') : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('messages.phone') }}</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ auth()->user()->phone }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('messages.nip') }}</label>
                                        <input type="text" name="nip" class="form-control"
                                            value="{{ auth()->user()->nip }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('messages.department') }}</label>
                                        <input type="text" name="departement" class="form-control"
                                            value="{{ auth()->user()->departement }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('messages.home_address') }}</label>
                                        <textarea name="home_address" class="form-control">{{ auth()->user()->home_address }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('messages.work_address') }}</label>
                                        <textarea name="work_address" class="form-control">{{ auth()->user()->work_address }}</textarea>
                                    </div>
                                    @if (auth()->user()->isHrd())
                                        <div class="form-group">
                                            <label>{{ __('messages.role') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ ucfirst(auth()->user()->role) }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('messages.position') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ ucfirst(auth()->user()->position) }}" readonly>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>{{ __('messages.join_date') }}</label>
                                        <input type="date" name="join_date" id="join_date" class="form-control"
                                            value="{{ auth()->user()->join_date ? auth()->user()->join_date->format('Y-m-d') : '' }}">
                                    </div>
                                    @if (auth()->user()->isHrd())
                                        <div class="form-group">
                                            <label>{{ __('messages.employment_status') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ ucfirst(auth()->user()->employment_status) }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('messages.contract_duration') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ auth()->user()->contract_duration ? auth()->user()->contract_duration . ' bulan' : '-' }}"
                                                readonly>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>{{ __('messages.end_work_date') }}</label>
                                        <input type="text" id="end_date" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('messages.work_duration') }}</label>
                                        <input type="text" id="work_duration_days" class="form-control" readonly>
                                    </div>


                                    <div class="form-group">
                                        <label>{{ __('messages.remaining_time') }}</label>
                                        <input type="text" id="remaining_days" class="form-control" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('messages.new_password') }}</label>
                                        <input type="password" name="password" class="form-control">
                                        <small
                                            class="form-text text-muted">{{ __('messages.leave_blank_password') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <hr>
                    <h4>{{ __('messages.upload_documents') }}</h4>
                    <div class="row">
                        {{-- Upload Ijazah --}}
                        <div class="col-md-3 text-center mb-4">
                            <div class="form-group">
                                <label>{{ __('messages.upload_ijazah') }}</label>
                                @if (auth()->user()->ijazah)
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <a href="{{ asset('storage/' . auth()->user()->ijazah) }}" target="_blank">
                                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                            <p class="mt-2">{{ __('messages.view_ijazah') }}</p>
                                        </a>
                                    </div>
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <i class="fas fa-file-upload fa-4x text-white"></i>
                                    </div>
                                @endif
                                <center>
                                    <input type="file" name="ijazah" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </center>
                            </div>
                        </div>

                        {{-- Upload SIP --}}
                        <div class="col-md-3 text-center mb-4">
                            <div class="form-group">
                                <label>{{ __('messages.upload_sip') }}</label>
                                @if (auth()->user()->sip)
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <a href="{{ asset('storage/' . auth()->user()->sip) }}" target="_blank">
                                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                            <p class="mt-2">{{ __('messages.view_sip') }}</p>
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
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </center>
                            </div>
                        </div>

                        {{-- Upload KTP --}}
                        <div class="col-md-3 text-center mb-4">
                            <div class="form-group">
                                <label>{{ __('messages.upload_ktp') }}</label>
                                @if (auth()->user()->ktp)
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <a href="{{ asset('storage/' . auth()->user()->ktp) }}" target="_blank">
                                            <i class="fas fa-id-card fa-4x text-primary"></i>
                                            <p class="mt-2">{{ __('messages.view_ktp') }}</p>
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
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </center>
                            </div>
                        </div>

                        {{-- Upload KK --}}
                        <div class="col-md-3 text-center mb-4">
                            <div class="form-group">
                                <label>{{ __('messages.upload_kk') }}</label>
                                @if (auth()->user()->kk)
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-2"
                                        style="width: 200px; height: 200px; margin: 0 auto;">
                                        <a href="{{ asset('storage/' . auth()->user()->kk) }}" target="_blank">
                                            <i class="fas fa-file-alt fa-4x text-info"></i>
                                            <p class="mt-2">{{ __('messages.view_kk') }}</p>
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
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </center>
                            </div>
                        </div>
                    </div>



                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">{{ __('messages.save_changes') }}</button>
                        <a href="/dashboard" class="btn btn-secondary">{{ __('messages.back') }}</a>

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
