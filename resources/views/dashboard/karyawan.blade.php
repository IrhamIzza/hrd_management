@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<link href="{{ asset('css/karyawandashboard.css') }}" rel="stylesheet">

<div class="dashboard-bg px-2 px-md-4">
    <h2 class="mb-4 mt-3 h3">Selamat Datang, <b>{{ auth()->user()->name }}</b> (Karyawan)</h2>
    <div class="row mb-4 g-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card bg-white">
                <div class="stat-icon-bg" style="background: #007bff;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <div class="stat-title">Sisa Cuti</div>
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
                    <div class="stat-title">Pengajuan Cuti Saya</div>
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
                    <div class="stat-title">Pengumuman Baru</div>
                    <div class="stat-value">{{ $pengumumanBaru }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Recent Notifications -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card-section">
                <div class="card-header">Notifikasi Terbaru</div>
                <div class="card-body">
                    @if($recentNotifications->count())
                        <ul class="list-group list-group-flush">
                            @foreach($recentNotifications as $notif)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $notif->title }}</span>
                                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-muted">Belum ada notifikasi terbaru.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card-section">
                <div class="card-header">Aksi Cepat</div>
                <div class="card-body">
                    <a href="{{ route('cuti_requests.create') }}" class="btn btn-primary btn-block mb-2"><i class="fas fa-plus"></i> Ajukan Cuti</a>
                    <a href="{{ route('karyawan.pengumuman.index') }}" class="btn btn-success btn-block mb-2"><i class="fas fa-bullhorn"></i> Lihat Pengumuman</a>
                    <a href="{{ route('karyawan.pembelajaran.index') }}" class="btn btn-info btn-block"><i class="fas fa-book"></i> Pusat Pembelajaran</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
