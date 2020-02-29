<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\PanoramaSingleSpaceResource;
use Illuminate\Auth\Access\HandlesAuthorization;

class PanoramaSingleSpaceResourcePolicy
{
    use HandlesAuthorization;

    public function update(Merchant $merchant, PanoramaSingleSpaceResource $single_space_resource)
    {
        return $merchant->id === $single_space_resource->merchant_id;
    }

    public function delete(Merchant $merchant, PanoramaSingleSpaceResource $single_space_resource)
    {
        return $merchant->id === $single_space_resource->merchant_id;
    }
}
