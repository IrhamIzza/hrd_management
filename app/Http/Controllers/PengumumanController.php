<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\User;
use App\Notifications\PengumumanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'hrd') {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $pengumuman = Pengumuman::orderBy('created_at', 'desc')->paginate(10);
        return view('pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('pengumuman.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'efficient_start_date' => 'nullable|date',
            'efficient_end_date' => 'nullable|date|after_or_equal:efficient_start_date',
        ]);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('pengumuman_thumbnails', 'public');
        }
        $data['created_by'] = Auth::id();

        $pengumuman = Pengumuman::create($data);

        // Send notifications to all employees
        $karyawanUsers = User::where('role', 'karyawan')->get();
        foreach ($karyawanUsers as $karyawan) {
            DB::table('notifications')->insert([
                'user_id' => $karyawan->id,
                'type' => 'pengumuman',
                'title' => $request->judul,
                'message' => Str::limit(strip_tags($request->deskripsi), 100),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'efficient_start_date' => 'nullable|date',
            'efficient_end_date' => 'nullable|date|after_or_equal:efficient_start_date',
        ]);
        if ($request->hasFile('thumbnail')) {
            if ($pengumuman->thumbnail) {
                Storage::disk('public')->delete($pengumuman->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('pengumuman_thumbnails', 'public');
        }
      
        $pengumuman->update($data);
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->thumbnail) {
            Storage::disk('public')->delete($pengumuman->thumbnail);
        }
        $pengumuman->delete();
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('pengumuman_images', 'public');
            return asset('storage/' . $path);
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    public function show(Pengumuman $pengumuman)
    {
        return view('pengumuman.show', compact('pengumuman'));
    }
}
