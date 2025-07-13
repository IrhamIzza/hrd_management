<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\CutiRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserApprovalController;
use App\Http\Controllers\KaryawanPengumumanController;
use App\Http\Controllers\Auth\RegisteredUserController;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});

Route::middleware(['auth','role:hrd,superadmin'])->group(function () {
    Route::get('/hrd-dashboard', [DashboardController::class, 'hrdDashboard'])->name('hrd.dashboard');

    // User approval routes
    Route::get('/user-approvals', [UserApprovalController::class, 'index'])->name('user-approvals.index');
    Route::get('/user-approvals/{user}', [UserApprovalController::class, 'show'])->name('user-approvals.show');
    Route::post('/user-approvals/{user}/approve', [UserApprovalController::class, 'approve'])->name('user-approvals.approve');
    Route::post('/user-approvals/{user}/reject', [UserApprovalController::class, 'reject'])->name('user-approvals.reject');

    // Route::get('/manage-employees', [EmployeeController::class, 'index'])->name('employees.index');
    // Route::get('/manage-employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    // Route::post('/manage-employees', [EmployeeController::class, 'store'])->name('employees.store');
    // Route::get('/manage-employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    // Route::put('/manage-employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    // Route::delete('/manage-employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    // Route::post('pengumuman/upload-image', [PengumumanController::class, 'uploadImage'])->name('pengumuman.upload-image');
});
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
Route::middleware(['auth','role:superadmin'])->group(function (){
    Route::get('/user-approvals/hrd/{user}', [UserApprovalController::class, 'show'])->name('user-approvals.show_hrd');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== 'karyawan') {
            return redirect()->route('hrd.dashboard');
        }
        return redirect()->route('karyawan.dashboard');
    })->name('dashboard');

    Route::resource('pengumuman', PengumumanController::class);
    Route::post('pengumuman/upload-image', [PengumumanController::class, 'uploadImage'])->name('pengumuman.upload-image');
    Route::resource('pusat_pembelajaran', App\Http\Controllers\PusatPembelajaranController::class);

    Route::get('/manage-employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/manage-employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/manage-employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/manage-employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/manage-employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/manage-employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/manage-employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');

    // Karyawan routes
    Route::get('/cuti-requests', [CutiRequestController::class, 'index'])->name('cuti_requests.index');
    Route::get('/cuti-requests/create', [CutiRequestController::class, 'create'])->name('cuti_requests.create');
    Route::post('/cuti-requests', [CutiRequestController::class, 'store'])->name('cuti_requests.store');
    Route::get('/cuti-requests/{cutiRequest}', [CutiRequestController::class, 'show'])->name('cuti_requests.show');

    // HRD routes
    Route::get('/hrd/cuti-requests', [CutiRequestController::class, 'hrdIndex'])->name('cuti_requests.hrd_index');
    Route::get('/hrd/cuti-requests/{cutiRequest}', [CutiRequestController::class, 'hrdShow'])->name('cuti_requests.hrd_show');
    Route::post('/cuti-requests/{cutiRequest}/approve', [CutiRequestController::class, 'approve'])->name('cuti_requests.approve');
    Route::post('/cuti-requests/{cutiRequest}/reject', [CutiRequestController::class, 'reject'])->name('cuti_requests.reject');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/karyawan-dashboard', [\App\Http\Controllers\DashboardController::class, 'karyawanDashboard'])->name('karyawan.dashboard');
    Route::get('karyawan/pengumuman', [KaryawanPengumumanController::class, 'index'])->name('karyawan.pengumuman.index');
    Route::get('karyawan/pengumuman/archived', [KaryawanPengumumanController::class, 'archived'])->name('karyawan.pengumuman.archived');
    Route::get('karyawan/pengumuman/{pengumuman}', [KaryawanPengumumanController::class, 'show'])->name('karyawan.pengumuman.show');
    Route::post('karyawan/pengumuman/{pengumuman}/archive', [KaryawanPengumumanController::class, 'archive'])->name('karyawan.pengumuman.archive');
    Route::get('karyawan/pembelajaran', [\App\Http\Controllers\KaryawanPembelajaranController::class, 'index'])->name('karyawan.pembelajaran.index');
    Route::get('karyawan/pembelajaran/{pusat_pembelajaran}', [\App\Http\Controllers\KaryawanPembelajaranController::class, 'show'])->name('karyawan.pembelajaran.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/test', function () { 
    return 'Passed isHrd';
})->middleware(['auth', 'isHrd']);
