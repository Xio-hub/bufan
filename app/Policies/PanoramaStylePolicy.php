<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\PanoramaStyle;
use Illuminate\Auth\Access\HandlesAuthorization;

class PanoramaStylePolicy
{
    use HandlesAuthorization;

    public function view(Merchant $merchant, PanoramaStyle $panorama_style)
    {
        return $merchant->id === $panorama_style->merchant_id;
    }

    public function create(Merchant $merchant)
    {
        //
    }

    public function update(Merchant $merchant, PanoramaStyle $panorama_style)
    {
        return $merchant->id === $panorama_style->merchant_id;
    }

    public function delete(Merchant $merchant, PanoramaStyle $panorama_style)
    {
        return $merchant->id === $panorama_style->merchant_id;
    }
}
