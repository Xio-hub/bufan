<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\Space;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpacePolicy
{
    public function view(Merchant $merchant, Space $space)
    {
        return $merchant->id === $space->merchant_id;
    }

    public function edit(Merchant $merchant, Space $space)
    {
        return $merchant->id === $space->merchant_id;
    }

    public function update(Merchant $merchant, Space $space)
    {
        return $merchant->id === $space->merchant_id;
    }

    public function delete(Merchant $merchant, Space $space)
    {
        return $merchant->id === $space->merchant_id;
    }
}
