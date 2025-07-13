@extends('layouts.app')


@section('content')

    <div class="container-fluid">
        <h2 class="mb-4">Selamat Datang, {{ auth()->user()->name }} (Karyawan)</h2>
        <div class="row">
            <!-- Quick Stats -->
            <div class="col-md-4">
                <div class="card bg-primary text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">🗓️ Sisa Cuti</h5>
                        <h3>{{ $sisaCuti }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">📄 Pengajuan Cuti Saya</h5>
                        <h3>{{ $totalCutiSaya }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">📢 Pengumuman Baru</h5>
                        <h3>{{ $pengumumanBaru }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Notifications -->
        <div class="card mt-4">
            <div class="card-header">Notifikasi Terbaru</div>
            <div class="card-body">
                <ul>
                    @foreach ($recentNotifications as $notif)
                        <li>{{ $notif->title }} - <small>{{ $notif->created_at->diffForHumans() }}</small></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.card').forEach((card, index) => {
            card.style.opacity = 0;
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                card.style.opacity = 1;
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });
    });
</script>
@endpush
