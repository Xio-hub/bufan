<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';
    protected $guarded = [];

    public function panoramas()
    {
        return $this->hasMany('App\Models\Panorama', 'material_id');
    }
}