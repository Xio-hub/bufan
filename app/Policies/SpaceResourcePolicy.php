<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\SpaceResource;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpaceResourcePolicy
{
    use HandlesAuthorization;

    public function update(Merchant $merchant, SpaceResource $space_resource)
    {
        return $merchant->id === $space_resource->merchant_id;
    }

    public function delete(Merchant $merchant, SpaceResource $space_resource)
    {
        return $merchant->id === $space_resource->merchant_id;
    }

}
