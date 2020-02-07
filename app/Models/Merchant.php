<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Merchant extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;
    use HasRoles;
    protected $guard_name = 'merchant';

    protected $table = 'merchants';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function base()
    {
        return $this->hasOne('App\Models\MerchantBase', 'merchant_id');
    }

    public function index()
    {
        return $this->hasOne('App\Models\MerchantIndex', 'merchant_id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'merchant_id');
    }

    public function spaceCategories()
    {
        return $this->hasMany('App\Models\SpaceCategory', 'merchant_id');
    }

    public function spaces()
    {
        return $this->hasMany('App\Models\Space', 'merchant_id');
    }
}
