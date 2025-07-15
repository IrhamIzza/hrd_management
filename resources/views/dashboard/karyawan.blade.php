@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
    <style>
        .dashboard-bg {
            background: #f4f6f9;
            min-height: 100vh;
            padding-bottom: 30px;
        }

        .stat-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.2s;
            padding: 1.5rem 1.2rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .stat-icon-bg {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
            margin-right: 1rem;
        }

        .stat-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.2rem;
            color: #555;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .card-section {
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
            margin-bottom: 2rem;
            background: #fff;
        }

        .card-header {
            font-weight: 700;
            font-size: 1.15rem;
            background: #f8f9fa !important;
            border-bottom: 1px solid #eee;
            border-radius: 18px 18px 0 0;
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid #f1f1f1;
        }
    </style>
    <div class="dashboard-bg px-2 px-md-4">
        {{-- <h2 class="mb-4 mt-3 h3">Selamat Datang, <b>{{ auth()->user()->name }}</b> (Karyawan)</h2> --}}
        <h2 class="mb-4 mt-3 h3">{{ __('messages.welcome_karyawan', ['name' => auth()->user()->name]) }}</h2>



        <div class="row mb-4 g-4">
            <div class="col-md-4 mb-3">
                <div class="stat-card bg-white">
                    <div class="stat-icon-bg" style="background: #007bff;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        {{-- <div class="stat-title">Sisa Cuti</div> --}}
                        <div class="stat-title">{{ __('messages.sisa_cuti') }}</div>
                        <div class="stat-value">{{ $sisaCuti }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card bg-white">
                    <div class="stat-icon-bg" style="background: #17a2b8;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        {{-- <div class="stat-title">Pengajuan Cuti Saya</div> --}}
                        <div class="stat-title">{{ __('messages.pengajuan_cuti_saya') }}</div>
                        <div class="stat-value">{{ $totalCutiSaya }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card bg-white">
                    <div class="stat-icon-bg" style="background: #28a745;">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div>
                        {{-- <div class="stat-title">Pengumuman Baru</div> --}}
                        <div class="stat-title">{{ __('messages.pengumuman_baru') }}</div>
                        <div class="stat-value">{{ $pengumumanBaru }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Notifications -->
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card-section">
                    {{-- <div class="card-header">Notifikasi Terbaru</div> --}}
                    <div class="card-header">{{ __('messages.recent_notifications') }}</div>
                    <div class="card-body">
                        @if ($recentNotifications->count())
                            <ul class="list-group list-group-flush">
                                @foreach ($recentNotifications as $notif)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $notif->title }}</span>
                                        <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            {{-- <div class="text-muted">Belum ada notifikasi terbaru.</div> --}}
                            <div class="text-muted">{{ __('messages.no_notifications') }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card-section">
                    {{-- <div class="card-header">Aksi Cepat</div> --}}
                    <div class="card-header">{{ __('messages.quick_actions') }}</div>
                    <div class="card-body">
                        {{-- <a href="{{ route('cuti_requests.create') }}" class="btn btn-primary btn-block mb-2"><i
                                class="fas fa-plus"></i> Ajukan Cuti</a>
                        <a href="{{ route('karyawan.pengumuman.index') }}" class="btn btn-success btn-block mb-2"><i
                                class="fas fa-bullhorn"></i> Lihat Pengumuman</a>
                        <a href="{{ route('karyawan.pembelajaran.index') }}" class="btn btn-info btn-block"><i
                                class="fas fa-book"></i> Pusat Pembelajaran</a> --}}
                        <a href="{{ route('cuti_requests.create') }}" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-plus"></i> {{ __('messages.ajukan_cuti') }}
                        </a>
                        <a href="{{ route('karyawan.pengumuman.index') }}" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-bullhorn"></i> {{ __('messages.lihat_pengumuman') }}
                        </a>
                        <a href="{{ route('karyawan.pembelajaran.index') }}" class="btn btn-info btn-block">
                            <i class="fas fa-book"></i> {{ __('messages.pusat_pembelajaran') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
