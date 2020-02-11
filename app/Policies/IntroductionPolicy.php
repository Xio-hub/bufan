<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\Introduction;
use Illuminate\Auth\Access\HandlesAuthorization;

class IntroductionPolicy
{
    use HandlesAuthorization;

    public function update(Merchant $merchant, Introduction $introduction)
    {
        return $merchant->id === $introduction->merchant_id;
    }
}
