<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\StyleResource;
use Illuminate\Auth\Access\HandlesAuthorization;

class StyleResourcePolicy
{
    use HandlesAuthorization;

    public function update(Merchant $merchant, StyleResource $style_resource)
    {
        return $merchant->id === $style_resource->merchant_id;
    }

    public function delete(Merchant $merchant, StyleResource $style_resource)
    {
        return $merchant->id === $style_resource->merchant_id;
    }
}
