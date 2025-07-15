@php
    use Illuminate\Support\Facades\Auth;

    $unreadNotifications =
        Auth::check() && Auth::user()->role === 'hrd'
            ? Auth::user()->unreadNotifications()->latest()->take(5)->get()
            : Auth::user()->unreadNotifications()->latest()->take(5)->get();
@endphp

<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if ($unreadNotifications->count() > 0)
            <span class="badge badge-warning navbar-badge">{{ $unreadNotifications->count() }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">{{ $unreadNotifications->count() }} Notifikasi Baru</span>
        <div class="dropdown-divider"></div>
        @forelse($unreadNotifications as $notification)
            <a href="{{ route('cuti_requests.hrd_show', $notification->data['cuti_request_id'] ?? '') }}"
                class="dropdown-item notification-item" data-notification-id="{{ $notification->id }}">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="mb-0">{{ $notification->title }}</p>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="ml-2">
                        <button type="button" class="btn btn-sm btn-link mark-as-read"
                            data-notification-id="{{ $notification->id }}">
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                </div>
            </a>
            <div class="dropdown-divider"></div>
        @empty
            <div class="dropdown-item text-center">
                <p class="text-muted mb-0">Tidak ada notifikasi baru</p>
            </div>
        @endforelse
        <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
    </div>
</li>
