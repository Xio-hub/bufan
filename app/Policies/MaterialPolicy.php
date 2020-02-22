<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\Material;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;

    public function view(Merchant $merchant, Material $material)
    {
        return $merchant->id === $material->merchant_id;
    }

    public function edit(Merchant $merchant, Material $material)
    {
        return $merchant->id === $material->merchant_id;
    }

    public function update(Merchant $merchant, Material $material)
    {
        return $merchant->id === $material->merchant_id;
    }

    public function delete(Merchant $merchant, Material $material)
    {
        return $merchant->id === $material->merchant_id;
    }
}
