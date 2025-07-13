<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'departement',
        'phone',
        'profile_photo',
        'approval_status',
        'rejection_reason',
        'approved_by',
        'approved_at',
        'email_active',
        'birth_date',
        'nip',
        'home_address',
        'work_address',
        'position',
        'join_date',
        'employment_status',
        'contract_duration',
        'work_duration_days',
        'ijazah', 'sip', 'kk', 'ktp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'approved_at' => 'datetime',
        'birth_date' => 'datetime',
        'join_date' => 'datetime',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function isHrd()
    {
        return $this->hasRole('hrd');
    }

    public function isKaryawan()
    {
        return $this->hasRole('karyawan');
    }

    public function cutiRequests()
    {
        return $this->hasMany(CutiRequest::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo
            ? asset('storage/' . $this->profile_photo)
            : asset('default-avatar.png');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approvedUsers()
    {
        return $this->hasMany(User::class, 'approved_by');
    }

    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    public function isPending()
    {
        return $this->approval_status === 'pending';
    }

    public function isRejected()
    {
        return $this->approval_status === 'rejected';
    }

    public function calculateWorkDuration()
    {
        if ($this->join_date) {
            $this->work_duration_days = Carbon::now()->diffInDays($this->join_date);
            $this->save();
        }
    }

    public function getEditableFields()
    {
        $fields = [
            'profile_photo',
            'name',
            'username',
            'email',
            'email_active',
            'birth_date',
            'phone',
            'nip',
            'departement',
            'home_address',
            'work_address',
            'join_date',
        ];
        if (auth()->user() && auth()->user()->isHrd()) {
            $fields = array_merge($fields, [
                'role',
                'position',
                'employment_status',
                'contract_duration',
            ]);
        }
        return $fields;
    }

    public function getWorkDurationDaysAttribute()
    {
        if (!$this->join_date) {
            return null;
        }
        return now()->diffInDays($this->join_date);
    }

}
