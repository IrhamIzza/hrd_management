<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cuti_request_id',
        'type',
        'title',
        'message',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cutiRequest()
    {
        return $this->belongsTo(CutiRequest::class);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}
