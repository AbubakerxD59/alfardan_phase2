<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = [
        'name',
        'property_id',
        'tower_id',
        'status'
    ];

    public function property(){
        return $this->belongsTo('App\Models\Property', 'property_id', 'id');
    }
    public function tower(){
        return $this->belongsTo('App\Models\Tower', 'tower_id', 'id');
    }

    public function apartments(){
        return $this->hasMany('App\Models\Apartment', 'floor_id', 'id');
    }
}
