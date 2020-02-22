<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\SpaceCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpaceCategoryPolicy
{
    use HandlesAuthorization;

    public function view(Merchant $merchant, SpaceCategory $space_category)
    {
        return $merchant->id === $space_category->merchant_id;
    }

    public function edit(Merchant $merchant, SpaceCategory $space_category)
    {
        return $merchant->id === $space_category->merchant_id;
    }

    public function update(Merchant $merchant, SpaceCategory $space_category)
    {
        return $merchant->id === $space_category->merchant_id;
    }

    public function delete(Merchant $merchant, SpaceCategory $space_category)
    {
        return $merchant->id === $space_category->merchant_id;
    }
}
