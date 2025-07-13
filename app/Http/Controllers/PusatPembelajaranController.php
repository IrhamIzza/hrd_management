<?php
namespace App\Http\Controllers;

use App\Models\PusatPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PusatPembelajaranController extends Controller
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
        $items = PusatPembelajaran::orderBy('created_at', 'desc')->paginate(10);
        return view('pusat_pembelajaran.index', compact('items'));
    }

    public function create()
    {
        return view('pusat_pembelajaran.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'konten' => 'required|mimes:pdf|max:10240',
        ]);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('pembelajaran_thumbnails', 'public');
        }
        if ($request->hasFile('konten')) {
            $data['konten'] = $request->file('konten')->store('pembelajaran_pdfs', 'public');
        }
        $data['created_by'] = Auth::id();
        PusatPembelajaran::create($data);
        return redirect()->route('pusat_pembelajaran.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(PusatPembelajaran $pusat_pembelajaran)
    {
        return view('pusat_pembelajaran.edit', compact('pusat_pembelajaran'));
    }

    public function update(Request $request, PusatPembelajaran $pusat_pembelajaran)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'konten' => 'nullable|mimes:pdf|max:10240',
        ]);
        if ($request->hasFile('thumbnail')) {
            if ($pusat_pembelajaran->thumbnail) {
                Storage::disk('public')->delete($pusat_pembelajaran->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('pembelajaran_thumbnails', 'public');
        }
        if ($request->hasFile('konten')) {
            if ($pusat_pembelajaran->konten) {
                Storage::disk('public')->delete($pusat_pembelajaran->konten);
            }
            $data['konten'] = $request->file('konten')->store('pembelajaran_pdfs', 'public');
        }
        $pusat_pembelajaran->update($data);
        return redirect()->route('pusat_pembelajaran.index')->with('success', 'Materi berhasil diupdate.');
    }

    public function destroy(PusatPembelajaran $pusat_pembelajaran)
    {
        if ($pusat_pembelajaran->thumbnail) {
            Storage::disk('public')->delete($pusat_pembelajaran->thumbnail);
        }
        if ($pusat_pembelajaran->konten) {
            Storage::disk('public')->delete($pusat_pembelajaran->konten);
        }
        $pusat_pembelajaran->delete();
        return redirect()->route('pusat_pembelajaran.index')->with('success', 'Materi berhasil dihapus.');
    }

    public function show(PusatPembelajaran $pusat_pembelajaran)
    {
        return view('pusat_pembelajaran.show', compact('pusat_pembelajaran'));
    }
} 