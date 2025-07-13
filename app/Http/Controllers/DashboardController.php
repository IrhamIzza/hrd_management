<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function hrdDashboard()
    {
        $totalKaryawan = \App\Models\User::where('role', 'karyawan')->count();
        $pendingCuti = \App\Models\CutiRequest::where('status', 'pending')->count();
        $totalPengumuman = \App\Models\Pengumuman::count();
        $recentNotifications = auth()->user()->notifications()->latest()->take(5)->get();
        $cutiStats = [
            'pending' => \App\Models\CutiRequest::where('status', 'pending')->count(),
            'approved' => \App\Models\CutiRequest::where('status', 'approved')->count(),
            'rejected' => \App\Models\CutiRequest::where('status', 'rejected')->count(),
        ];
        return view('dashboard.hrd', compact('totalKaryawan', 'pendingCuti', 'totalPengumuman', 'recentNotifications', 'cutiStats'));
    }

    public function karyawanDashboard()
    {
        $sisaCuti = auth()->user()->sisa_cuti ?? 0; // adjust as needed
        $totalCutiSaya = auth()->user()->cutiRequests()->count();
        $pengumumanBaru = \App\Models\Pengumuman::whereDate('created_at', '>=', now()->subWeek())->count();
        $recentNotifications = auth()->user()->notifications()->latest()->take(5)->get();
        return view('dashboard.karyawan', compact('sisaCuti', 'totalCutiSaya', 'pengumumanBaru', 'recentNotifications'));
    }
}
