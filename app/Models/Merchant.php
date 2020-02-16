<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Merchant extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;
    use HasRoles;
    use HasApiTokens;
    use SoftDeletes;
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

    public function styleCategories()
    {
        return $this->hasMany('App\Models\StyleCategory', 'merchant_id');
    }

    public function styles()
    {
        return $this->hasMany('App\Models\Style', 'merchant_id');
    }

    public function introductions()
    {
        return $this->hasMany('App\Models\Introduction', 'merchant_id');
    }

    public function materials()
    {
        return $this->hasMany('App\Models\Material', 'merchant_id');
    }

    public function panorama_styles()
    {
        return $this->hasMany('App\Models\PanoramaStyle', 'merchant_id');
    }

    public function panoramas()
    {
        return $this->hasMany('App\Models\Panorama', 'merchant_id');
    }

    public function vertical_views()
    {
        return $this->hasMany('App\Models\VerticalView', 'merchant_id');
    }

    public function single_spaces()
    {
        return $this->hasMany('App\Models\PanoramaSingleSpace', 'merchant_id');
    }

    public function course_orders()
    {
        return $this->hasMany('App\Models\VerticalView', 'user_id');
    }
}
