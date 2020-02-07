<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceCategory extends Model
{
    protected $table = 'space_categories';
    protected $guarded = [];

    public function spaces()
    {
        return $this->hasMany('App\Models\Space', 'category_id');
    }

    public function resources()
    {
        return $this->hasManyThrough(
            'App\Models\SpaceResource', 
            'App\Models\Space', 
            'category_id', 
            'space_id', 
            'id', 
            'id' 
        );
    }
}
