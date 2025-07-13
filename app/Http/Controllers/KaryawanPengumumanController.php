<?php
namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\ArchivedPengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KaryawanPengumumanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $userId = Auth::id();
        $archivedIds = ArchivedPengumuman::where('user_id', $userId)
            ->whereNotNull('archived_at')
            ->pluck('pengumuman_id');

        $pengumuman = Pengumuman::whereNotIn('id', $archivedIds)->orderBy('created_at', 'desc')->get();
        return view('karyawan.pengumuman.index', compact('pengumuman'));
    }

    public function show(Pengumuman $pengumuman)
    {
        $userId = Auth::id();
        $archived = ArchivedPengumuman::where('user_id', $userId)->where('pengumuman_id', $pengumuman->id)->first();
        if (!$archived) {
            ArchivedPengumuman::create([
                'user_id' => $userId,
                'pengumuman_id' => $pengumuman->id,
                'is_read' => true,
                'archived_at' => null,
            ]);
        } else if (!$archived->is_read) {
            $archived->update(['is_read' => true]);
        }
        return view('karyawan.pengumuman.show', compact('pengumuman'));
    }

    public function archive(Pengumuman $pengumuman)
    {
        $userId = Auth::id();
        $archived = ArchivedPengumuman::firstOrCreate([
            'user_id' => $userId,
            'pengumuman_id' => $pengumuman->id,
        ]);
        $archived->update(['archived_at' => Carbon::now()]);
        return redirect()->route('karyawan.pengumuman.index')->with('success', 'Pengumuman diarsipkan.');
    }

    public function archived()
    {
        $userId = Auth::id();
        $archivedPengumuman = ArchivedPengumuman::where('user_id', $userId)->whereNotNull('archived_at')->with('pengumuman')->get();
        return view('karyawan.pengumuman.archived', compact('archivedPengumuman'));
    }
} 