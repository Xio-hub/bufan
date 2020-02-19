<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\Style;
use Illuminate\Auth\Access\HandlesAuthorization;

class StylePolicy
{
    use HandlesAuthorization;

    public function view(Merchant $merchant, Style $style)
    {
        return $merchant->id === $style->merchant_id;
    }

    public function edit(Merchant $merchant, Style $style)
    {
        return $merchant->id === $style->merchant_id;
    }

    public function update(Merchant $merchant, Style $style)
    {
        return $merchant->id === $style->merchant_id;
    }

    public function delete(Merchant $merchant, Style $style)
    {
        return $merchant->id === $style->merchant_id;
    }
}
