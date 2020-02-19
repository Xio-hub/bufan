<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\ProductResource;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductResourcePolicy
{
    use HandlesAuthorization;

    public function update(Merchant $merchant, ProductResource $product_resource)
    {
        return $merchant->id === $product_resource->merchant_id;
    }

    public function delete(Merchant $merchant, ProductResource $product_resource)
    {
        return $merchant->id === $product_resource->merchant_id;
    }
}
