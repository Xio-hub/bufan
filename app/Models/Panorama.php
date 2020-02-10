<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panorama extends Model
{
    protected $table = 'panoramas';
    protected $guarded = [];

    public function style()
    {
        return $this->belongsTo('App\Models\PanoramaStyle', 'style_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'material_id', 'id');
    }
}
