<?php

namespace App\Repositories\Traits;

use Illuminate\Support\Facades\Auth;

trait TraitRepository
{
    public function getAuthUser()
    {
        return Auth::user();
    }
}
