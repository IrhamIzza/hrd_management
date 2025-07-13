<?php
namespace App\Http\Controllers;

use App\Models\PusatPembelajaran;
use Illuminate\Http\Request;

class KaryawanPembelajaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $items = PusatPembelajaran::orderBy('created_at', 'desc')->paginate(10);
        return view('karyawan.pembelajaran.index', compact('items'));
    }

    public function show(PusatPembelajaran $pusat_pembelajaran)
    {
        return view('karyawan.pembelajaran.show', compact('pusat_pembelajaran'));
    }
} 