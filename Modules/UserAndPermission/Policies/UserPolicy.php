<?php

namespace Modules\UserAndPermission\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\UserAndPermission\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function delete(User $auth, User $user)
    {
        if ($user->is_admin || $user->id == $auth->id) {
            return false;
        }

        return true;
    }
}
