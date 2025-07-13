<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = 'pengumuman';
    protected $fillable = [
        'judul',
        'deskripsi',
        'thumbnail',
        'efficient_start_date',
        'efficient_end_date',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function archivedPengumuman()
    {
        return $this->hasMany(ArchivedPengumuman::class, 'pengumuman_id');
    }
} 