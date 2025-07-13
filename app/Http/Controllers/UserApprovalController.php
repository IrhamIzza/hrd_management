<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->role == 'superadmin') {
            $pendingUsers = User::where('approval_status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();
            return view('user_approvals.index', compact('pendingUsers'));
        }else{
            $pendingUsers = User::where('approval_status', 'pending')
                ->where('role', '!=', 'hrd')
                ->orderBy('created_at', 'desc')
                ->get();
    
            return view('user_approvals.index', compact('pendingUsers'));
        }
    }

    public function show(User $user)
    {
        return view('user_approvals.show', compact('user'));
    }

    public function approve(User $user)
    {
        $user->update([
            'approval_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        // Create notification for the approved user
        DB::table('notifications')->insert([
            'user_id' => $user->id,
            'type' => 'user_approval',
            'title' => 'Akun Disetujui',
            'message' => 'Akun Anda telah disetujui oleh HRD. Anda sekarang dapat mengakses sistem.',
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('user-approvals.index')
            ->with('success', 'Pengguna berhasil disetujui.');
    }

    public function reject(Request $request, User $user)
    {
        $data = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        // Delete user's notifications
        DB::table('notifications')->where('user_id', $user->id)->delete();

        // Delete user's cuti requests if any
        DB::table('cuti_requests')->where('user_id', $user->id)->delete();

        // Delete the user
        $user->delete();

        return redirect()->route('user-approvals.index')
            ->with('success', 'Pengguna berhasil ditolak dan dihapus.');
    }
}
