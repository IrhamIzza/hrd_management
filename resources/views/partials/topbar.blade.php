@php use Illuminate\Support\Str; @endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/dashboard" class="nav-link">HRD Management System</a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link d-flex" data-toggle="dropdown" href="#" aria-expanded="false" style="align-items: center;">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}?v={{ time() }}" alt="{{ auth()->user()->name }}" class="img-circle elevation-2 mr-2" style="width: 32px; height: 32px;">
                @else
                    <span class="avatar-placeholder mr-2" style="width:32px;height:32px;display:inline-block;border-radius:50%;background:#eee;text-align:center;line-height:32px;">
                        <i class="fas fa-user text-secondary"></i>
                    </span>
                @endif
                <span class="ml-2">{{ auth()->user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="/profile" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="dropdown-item p-0 m-0">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0" style="margin-left: 10%; border:none; background:none; width:100%; text-align:left;">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </li>
        @if(auth()->user()->role === 'karyawan')
            @php
                $unreadPengumuman = \App\Models\Pengumuman::whereDoesntHave('archivedPengumuman', function($q) {
                    $q->where('user_id', auth()->id())->where('is_read', true);
                })->orderBy('created_at', 'desc')->take(5)->get();
                $unreadCount = $unreadPengumuman->count();
            @endphp
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    @if($unreadCount > 0)
                        <span class="badge badge-warning navbar-badge">{{ $unreadCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">{{ $unreadCount }} Pengumuman Belum Dibaca</span>
                    <div class="dropdown-divider"></div>
                    @forelse($unreadPengumuman as $notif)
                        <a href="{{ route('karyawan.pengumuman.show', $notif) }}" class="dropdown-item">
                            <i class="fas fa-bullhorn mr-2"></i> {{ Str::limit($notif->judul, 30) }}
                        </a>
                        <div class="dropdown-divider"></div>
                    @empty
                        <span class="dropdown-item text-muted">Tidak ada pengumuman baru</span>
                    @endforelse
                    <a href="{{ route('karyawan.pengumuman.index') }}" class="dropdown-item dropdown-footer">Lihat Semua Pengumuman</a>
                </div>
            </li>
        @endif
    </ul>
</nav>
