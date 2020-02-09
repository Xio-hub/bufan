<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StyleCategory extends Model
{
    protected $table = 'style_categories';
    protected $guarded = [];

    public function styles()
    {
        return $this->hasMany('App\Models\Style', 'category_id');
    }

    public function resources()
    {
        return $this->hasManyThrough(
            'App\Models\StyleResource', 
            'App\Models\Style', 
            'category_id', 
            'style_id', 
            'id', 
            'id' 
        );
    }
}
