<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link d-flex justify-content-center align-items-center">
        <img src="{{ asset('images/hrmisputih.png') }}" alt="Logo HRMIS" class="logo-img">
    </a>




    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                @if (auth()->user()->role !== 'karyawan' )
                    <li class="nav-item">
                        <a href="/manage-employees"
                            class="nav-link {{ Request::is('manage-employees') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p> Data Karyawan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/hrd/cuti-requests"
                            class="nav-link {{ Request::is('hrd/cuti-requests') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p> Pengajuan Cuti</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/pengumuman" class="nav-link {{ Request::is('pengumuman') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p> Pengumuman</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/pusat_pembelajaran"
                            class="nav-link {{ Request::is('pusat_pembelajaran') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Perpustakaan Digital</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="/cuti-requests" class="nav-link {{ Request::is('cuti-requests') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p> Pengajuan Cuti</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/karyawan/pengumuman"
                            class="nav-link {{ Request::is('karyawan/pengumuman') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p> Pengumuman</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/karyawan/pembelajaran"
                            class="nav-link {{ Request::is('karyawan/pembelajaran') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Perpustakaan Digital</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


<style>
    .main-sidebar {
        background: linear-gradient(to bottom, #00143a, #005daf, #9fc9ee);
        color: #fff;
        font-family: 'Poppins', sans-serif;
    }

    .logo-img {
        height: 200px;
        width: auto;
        transition: all 0.3s ease;
    }

    .sidebar-collapse .logo-img {
        height: 80px;
    }

    .brand-link {
        background: #00143a;
        padding: 1rem 0;
        height: 70px;
    }

    .nav-sidebar>.nav-item>.nav-link {
        color: #fff;
        border-radius: 10px;
        margin: 5px 10px;
        transition: 0.3s ease;
    }

    .nav-sidebar>.nav-item>.nav-link:hover {
        background-color: #4098D7;
    }

    .nav-sidebar .nav-link.active {
        background-color: #fff;
        color: #00325e !important;
        font-weight: bold;
        box-shadow: 0 0 10px rgba(0, 93, 175, 0.3);
    }
</style>
