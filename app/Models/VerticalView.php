<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerticalView extends Model
{
    protected $table = 'vertical_views';
    protected $guarded = [];

    public function style()
    {
        return $this->belongsTo('App\Models\PanoramaStyle', 'style_id', 'id');
    }
}
