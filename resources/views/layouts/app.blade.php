<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HRD Management')</title>

    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            @if(auth()->user()->role === 'hrd')
                @include('layouts.notifications')
                <!-- Profile Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex" style="align-items: center;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="img-circle elevation-2 mr-2" style="width: 32px; height: 32px;">
                        <span class="ml-2 d-none d-md-inline-block">{{ auth()->user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/profile">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            @else
                @php
                    $unreadNotifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();
                @endphp
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        @if($unreadNotifications->count() > 0)
                            <span class="badge badge-warning navbar-badge">{{ $unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">{{ $unreadNotifications->count() }} Notifikasi Baru</span>
                        <div class="dropdown-divider"></div>
                        @forelse($unreadNotifications as $notification)
                            <a href="{{ $notification->data['link'] ?? '#' }}" 
                               class="dropdown-item notification-item" 
                               data-notification-id="{{ $notification->id }}">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="mb-0">{{ $notification->title }}</p>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="ml-2">
                                        <button type="button" 
                                                class="btn btn-sm btn-link mark-as-read" 
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
                <!-- Profile Dropdown Menu for Karyawan -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex" style="align-items: center;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="img-circle elevation-2 mr-2" style="width: 32px; height: 32px;">
                        <span class="ml-2 d-none d-md-inline-block">{{ auth()->user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/profile">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            @endif
        </ul>
    </nav>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content pt-4">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <!-- Footer -->
    @include('partials.footer')
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- Bootstrap 4 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@stack('scripts')

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
        })
        .fail(function() {
            alert('Terjadi kesalahan saat menandai notifikasi sebagai dibaca.');
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
</body>
</html>


<style>
    /* Warna tema utama */
    :root {
        --main-navbar: #00143a;
        --main-sidebar: #5AB2FF;
        --sidebar-hover: #FFFFD3;
        --main-bg: #F3F2B4;
    }

    /* Navbar */
    .main-header.navbar {
        background-color: var(--main-navbar) !important;
        color: white;
        height: 70px;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .navbar-light .navbar-nav .nav-link {
        color: white;
    }

    .navbar-light .navbar-nav .nav-link:hover {
        color: #ffffff;
    }

    /* Sidebar */
    .main-sidebar {
        background-color: var(--main-sidebar);
    }

    .nav-sidebar>.nav-item>.nav-link.active {
        background-color: var(--sidebar-hover);
        color: #003441;
    }

    .nav-sidebar .nav-link:hover {
        background-color: #5AB2FF;
        color: #00143a;
    }

    /* Notification badge */
    .navbar-badge {
        background-color: #5AB2FF !important;
        color: #00143a !important;
    }

    /* Profile image border and dropdown */
    .img-circle {
        border: 2px solid white;
    }

    .dropdown-menu {
        background-color: #ffffff;
    }

    .dropdown-item:hover {
        background-color: #5AB2FF;
    }

    /* Body Background */
    body {
        background-color: var(--main-bg);
    }
</style>
