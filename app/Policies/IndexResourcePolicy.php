<?php

namespace App\Policies;

use App\Models\IndexResource;
use App\Models\Merchant;
use Illuminate\Auth\Access\HandlesAuthorization;

class IndexResourcePolicy
{
    use HandlesAuthorization;

    public function update(Merchant $merchant, IndexResource $index_resource)
    {
        return $merchant->id === $index_resource->merchant_id;
    }

    public function delete(Merchant $merchant, IndexResource $index_resource)
    {
        return $merchant->id === $index_resource->merchant_id;
    }
}
