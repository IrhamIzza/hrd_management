@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h2">Notifikasi</h1>
        @if($notifications->count() > 0)
            <button type="button" class="btn btn-primary" id="markAllAsRead">
                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
            </button>
        @endif
    </div>
    <hr class="mb-3" />

    <div class="card shadow">
        <div class="card-body">
            @forelse($notifications as $notification)
                <div class="notification-item p-3 border-bottom {{ $notification->read_at ? 'bg-light' : '' }}" 
                     data-notification-id="{{ $notification->id }}">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $notification->title }}</h5>
                            <p class="mb-1">{{ $notification->message }}</p>
                            <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="ml-3">
                            @if(!$notification->read_at)
                                <button type="button" 
                                        class="btn btn-sm btn-link mark-as-read" 
                                        data-notification-id="{{ $notification->id }}">
                                    <i class="fas fa-check"></i> Tandai Dibaca
                                </button>
                            @endif
                            @if(isset($notification->data['link']))
                                <a href="{{ $notification->data['link'] }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center p-5">
                    <i class="far fa-bell fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada notifikasi</p>
                </div>
            @endforelse

            @if($notifications->hasPages())
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .notification-item {
        transition: background-color 0.3s ease;
    }
    .notification-item:hover {
        background-color: #f8f9fa;
    }
    .notification-item.read {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Mark single notification as read
    $('.mark-as-read').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const notificationId = $(this).data('notification-id');
        const notificationItem = $(this).closest('.notification-item');
        
        $.post(`/notifications/${notificationId}/mark-as-read`, {
            _token: '{{ csrf_token() }}'
        })
        .done(function() {
            notificationItem.addClass('read');
            $(this).closest('.dropdown-item').remove();
            updateNotificationCount();
            window.location.reload();
        })
        .fail(function() {
            alert('Terjadi kesalahan saat menandai notifikasi sebagai dibaca.');
        });
    });

    // Mark all notifications as read
    $('#markAllAsRead').click(function() {
        $.post('/notifications/mark-all-as-read', {
            _token: '{{ csrf_token() }}'
        })
        .done(function() {
            $('.notification-item').addClass('read');
            $('.mark-as-read').remove();
            updateNotificationCount();
        })
        .fail(function() {
            alert('Terjadi kesalahan saat menandai semua notifikasi sebagai dibaca.');
        });
    });

    function updateNotificationCount() {
        const count = $('.notification-item:not(.read)').length;
        $('.navbar-badge').text(count);
        if (count === 0) {
            $('.navbar-badge').hide();
        }
    }
});
</script>
@endpush 