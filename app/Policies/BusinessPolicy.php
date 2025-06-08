<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;

class BusinessPolicy
{
    public function viewAny(User $user): bool
    {
        // Admin يرى الكل، User يرى فقط نشاطه (في Resource سنفعل ذلك بالquery)
        return true;
    }

    public function view(User $user, Business $business): bool
    {
        return $user->role === 'admin' || $business->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true; // الجميع يمكنه إنشاء Business
    }

    public function update(User $user, Business $business): bool
    {
        return $user->role === 'admin' || $business->user_id === $user->id;
    }

    public function delete(User $user, Business $business): bool
    {
        return $user->role === 'admin' || $business->user_id === $user->id;
    }


    public function restore(User $user, Business $business): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Business $business): bool
    {
        return $user->role === 'admin';
    }
}
