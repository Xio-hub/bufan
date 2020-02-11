<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\Panorama;
use Illuminate\Auth\Access\HandlesAuthorization;

class PanoramaPolicy
{
    use HandlesAuthorization;

    public function view(Merchant $merchant, Panorama $panorama)
    {
        return $merchant->id === $panorama->merchant_id;
    }

    public function create(Merchant $merchant)
    {
        //
    }

    public function update(Merchant $merchant, Panorama $panorama)
    {
        return $merchant->id === $panorama->merchant_id;
    }

    public function delete(Merchant $merchant, Panorama $panorama)
    {
        return $merchant->id === $panorama->merchant_id;
    }
}
