<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $table = 'spaces';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Models\SpaceCategory', 'category_id', 'id');
    }

    public function resources()
    {
        return $this->hasMany('App\Models\SpaceResource', 'space_id');
    }
}
