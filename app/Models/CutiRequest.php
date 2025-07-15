<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutiRequest extends Model
{
    protected $table = 'cuti_requests';
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'reason',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
        'bukti',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
} 