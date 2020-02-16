<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\PanoramaSingleSpace;
use Illuminate\Auth\Access\HandlesAuthorization;

class PanoramaSingleSpacePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(Merchant $merchant, PanoramaSingleSpace $panorama_single_space)
    {
        return $merchant->id === $panorama_single_space->merchant_id;
    }

    public function update(Merchant $merchant, PanoramaSingleSpace $panorama_single_space)
    {
        return $merchant->id === $panorama_single_space->merchant_id;
    }

    public function delete(Merchant $merchant, PanoramaSingleSpace $panorama_single_space)
    {
        return $merchant->id === $panorama_single_space->merchant_id;
    }
}
