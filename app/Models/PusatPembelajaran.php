<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PusatPembelajaran extends Model
{
    protected $table = 'pusat_pembelajaran';
    protected $fillable = [
        'judul',
        'deskripsi',
        'thumbnail',
        'konten',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
} 