<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedPengumuman extends Model
{
    protected $table = 'archived_pengumuman';
    protected $fillable = [
        'user_id',
        'pengumuman_id',
        'is_read',
        'archived_at',
    ];
    public $timestamps = false;

    public function pengumuman() {
        return $this->belongsTo(Pengumuman::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
} 