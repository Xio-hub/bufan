<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanoramaStyle extends Model
{
    protected $table = 'panorama_styles';
    protected $guarded = [];

    public function panoramas()
    {
        return $this->hasMany('App\Models\Panorama', 'material_id');
    }
}