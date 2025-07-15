@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">{{ __('messages.welcome_karyawan', ['name' => auth()->user()->name]) }}</h2>

    <div class="row">
        <!-- Quick Stats -->
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.remaining_leave') }}</h5>
                    <h3>{{ $sisaCuti }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.my_leave_requests') }}</h5>
                    <h3>{{ $totalCutiSaya }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('messages.new_announcements') }}</h5>
                    <h3>{{ $pengumumanBaru }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Notifications -->
    <div class="card mt-4">
        <div class="card-header">{{ __('messages.recent_notifications') }}</div>
        <div class="card-body">
            <ul>
                @forelse($recentNotifications as $notif)
                    <li>{{ $notif->title }} - <small>{{ $notif->created_at->diffForHumans() }}</small></li>
                @empty
                    <li class="text-muted">{{ __('messages.no_notifications') }}</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
