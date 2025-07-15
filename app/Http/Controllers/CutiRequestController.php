<?php

namespace App\Http\Controllers;

use App\Models\CutiRequest;
use App\Models\User;
use App\Notifications\CutiRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CutiRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Karyawan: list their own requests
    public function index()
    {
        $cutiRequests = CutiRequest::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('cuti_requests.index', compact('cutiRequests'));
    }

    // Karyawan: show form
    public function create()
    {
        return view('cuti_requests.create');
    }

    // Karyawan: submit request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'bukti' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // // Proses upload file
        // if ($request->hasFile('bukti')) {
        //     $file = $request->file('bukti');
        //     $filename = $file->store('bukti_cuti', 'public'); // disimpan di storage/app/public/bukti_cuti
        //     $validated['bukti'] = $filename;
        // }

        // Simpan file jika ada
        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('bukti_cuti', 'public');
        }

        $cutiRequest = auth()->user()->cutiRequests()->create($validated);

        $hrUsers = User::where('role', 'hrd')->get();
        foreach ($hrUsers as $hrUser) {
            DB::table('notifications')->insert([
                'user_id' => $hrUser->id,
                'cuti_request_id' => $cutiRequest->id,
                'type' => 'cuti_request',
                'title' => 'Pengajuan Cuti Baru',
                'message' => auth()->user()->name . ' mengajukan cuti dari ' . $cutiRequest->start_date . ' s/d ' . $cutiRequest->end_date,
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('cuti_requests.index')
            ->with('success', 'Pengajuan cuti berhasil dibuat.');
    }

    // Karyawan: show detail
    public function show(CutiRequest $cutiRequest)
    {
        return view('cuti_requests.show', compact('cutiRequest'));
    }

    // HRD: list all requests
    public function hrdIndex()
    {
        $cutiRequests = CutiRequest::with('user')->orderBy('created_at', 'desc')->get();
        return view('cuti_requests.hrd_index', compact('cutiRequests'));
    }

    // HRD: show detail
    public function hrdShow(CutiRequest $cutiRequest)
    {
        return view('cuti_requests.hrd_show', compact('cutiRequest'));
    }

    public function approve(CutiRequest $cutiRequest)
    {
        $cutiRequest->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => Carbon::now(),
            'rejection_reason' => null,
        ]);

        DB::table('notifications')->insert([
            'user_id' => $cutiRequest->user_id,
            'cuti_request_id' => $cutiRequest->id,
            'type' => 'cuti_request',
            'title' => 'Pengajuan Cuti Disetujui',
            'message' => "Pengajuan cuti Anda pada {$cutiRequest->start_date} s/d {$cutiRequest->end_date} telah disetujui",
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('cuti_requests.hrd_index')->with('success', 'Pengajuan cuti disetujui.');
    }
    
    public function reject(Request $request, CutiRequest $cutiRequest)
    {
        $data = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $cutiRequest->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => Carbon::now(),
            'rejection_reason' => $data['rejection_reason'],
        ]);

        DB::table('notifications')->insert([
            'user_id' => $cutiRequest->user_id,
            'cuti_request_id' => $cutiRequest->id,
            'type' => 'cuti_request',
            'title' => 'Pengajuan Cuti Ditolak',
            'message' => "Pengajuan cuti Anda pada {$cutiRequest->start_date} s/d {$cutiRequest->end_date} telah ditolak. Alasan: {$cutiRequest->rejection_reason}",
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('cuti_requests.hrd_index')->with('success', 'Pengajuan cuti ditolak.');
    }
} 