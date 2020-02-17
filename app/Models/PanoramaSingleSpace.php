<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanoramaSingleSpace extends Model
{
    protected $table = 'panorama_single_spaces';
    protected $guarded = [];

    public function style()
    {
        return $this->belongsTo('App\Models\PanoramaStyle', 'style_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'material_id', 'id');
    }

    public function space()
    {
        return $this->belongsTo('App\Models\Space', 'space_id', 'id');
    }
}
