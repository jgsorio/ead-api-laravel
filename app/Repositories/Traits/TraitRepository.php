<?php

namespace App\Repositories\Traits;

use App\Models\User;

trait TraitRepository
{
    public function getAuthUser()
    {
        return User::first();
    }
}
