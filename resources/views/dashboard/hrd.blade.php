@extends('layouts.app')

@section('title', 'Dashboard HRD')

@section('content')

    <link href="{{ asset('css/hrddashboard.css') }}" rel="stylesheet">
    <div class="dashboard-bg px-2 px-md-4">
        <h2 class="mb-4 mt-3 h3">Selamat Datang, <b>{{ auth()->user()->name }}</b> (HRD)</h2>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Karyawan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKaryawan }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pengajuan Cuti Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingCuti }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Pengumuman</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPengumuman }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Pengguna Menunggu Persetujuan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\User::where('approval_status', 'pending')->where('role', '!=', 'hrd')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Pengguna Menunggu Persetujuan</h6>
                        <a href="{{ route('user-approvals.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-users"></i> Kelola Persetujuan
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Departemen</th>
                                        <th>Role</th>
                                        <th>Tanggal Registrasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\User::where('approval_status', 'pending')->where('role', '!=', 'hrd')->latest()->take(5)->get() as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->departement }}</td>
                                            <td>{{ ucfirst($user->role) }}</td>
                                            {{-- <td>{{ $user->created_at->format('d/m/Y H:i') }}</td> --}}
                                            <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>

                                            <td>
                                                <a href="{{ route('user-approvals.show', $user) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card-section">
                    <div class="card-header">Statistik Pengajuan Cuti</div>
                    <div class="card-body">
                        <canvas id="cutiChart" height="120"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card-section">
                    <div class="card-header">Aktivitas Terbaru</div>
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
                            <div class="text-muted">Belum ada aktivitas terbaru.</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div id="motivation-box" class="alert alert-info shadow-sm p-3 rounded"
                    style="font-size: 1rem; font-weight: 500;">
                    Semangat terus dan jangan menyerah!
                </div>
            </div>



        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('cutiChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Disetujui', 'Ditolak'],
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: [
                        {{ $cutiStats['pending'] }},
                        {{ $cutiStats['approved'] }},
                        {{ $cutiStats['rejected'] }}
                    ],
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 193, 7, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const messages = [
            "Semangat terus dan jangan menyerah!",
            "Kerja keras tidak akan mengkhianati hasil.",
            "Hari ini lebih baik dari kemarin!",
            "Fokus pada tujuan, bukan hambatan.",
            "Sukses dimulai dengan langkah pertama.",
            "Tetap konsisten, tetap positif.",
            "Kamu hebat, jangan ragu!"
        ];

        let currentMessageIndex = 0;
        const box = document.getElementById('motivation-box');

        setInterval(() => {
            currentMessageIndex = (currentMessageIndex + 1) % messages.length;
            box.textContent = messages[currentMessageIndex];
        }, 5000);
    </script>
@endpush
