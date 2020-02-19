<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function view(Merchant $merchant, Product $product)
    {
        return $merchant->id === $product->merchant_id;
    }

    public function edit(Merchant $merchant, Product $product)
    {
        return $merchant->id === $product->merchant_id;
    }

    public function update(Merchant $merchant, Product $product)
    {
        return $merchant->id === $product->merchant_id;
    }

    public function delete(Merchant $merchant, Product $product)
    {
        return $merchant->id === $product->merchant_id;
    }
}
