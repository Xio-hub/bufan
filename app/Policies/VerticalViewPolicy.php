<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\VerticalView;
use Illuminate\Auth\Access\HandlesAuthorization;

class VerticalViewPolicy
{
    use HandlesAuthorization;

    public function view(Merchant $merchant, VerticalView $vertical_view)
    {
        return $merchant->id === $vertical_view->merchant_id;
    }

    public function create(Merchant $merchant)
    {
        //
    }

    public function update(Merchant $merchant, VerticalView $vertical_view)
    {
        return $merchant->id === $vertical_view->merchant_id;
    }

    public function delete(Merchant $merchant, VerticalView $vertical_view)
    {
        return $merchant->id === $vertical_view->merchant_id;
    }
}
