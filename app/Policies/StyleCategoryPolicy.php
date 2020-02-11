<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\StyleCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class StyleCategoryPolicy
{
    use HandlesAuthorization;

    public function view(Merchant $merchant, StyleCategory $style_category)
    {
        return $merchant->id === $style_category->merchant_id;
    }

    public function create(Merchant $merchant)
    {
        //
    }

    public function update(Merchant $merchant, StyleCategory $style_category)
    {
        return $merchant->id === $style_category->merchant_id;
    }

    public function delete(Merchant $merchant, StyleCategory $style_category)
    {
        return $merchant->id === $style_category->merchant_id;
    }
}
