<?php

namespace App\Policies;

use App\Models\CutiRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CutiRequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isHrd();
    }

    public function view(User $user, CutiRequest $cutiRequest)
    {
        return $user->isHrd() || $user->id === $cutiRequest->user_id;
    }

    public function create(User $user)
    {
        return $user->isKaryawan();
    }

    public function update(User $user, CutiRequest $cutiRequest)
    {
        return $user->isHrd();
    }

    public function delete(User $user, CutiRequest $cutiRequest)
    {
        return $user->isHrd();
    }
} 