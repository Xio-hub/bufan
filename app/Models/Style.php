<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $table = 'styles';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Models\StyleCategory', 'category_id', 'id');
    }

    public function resources()
    {
        return $this->hasMany('App\Models\StyleResource', 'style_id');
    }
}
