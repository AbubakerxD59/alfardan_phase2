<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tower extends Model
{
    protected $fillable = [
        'name',
        'property_id',
        'status'
    ];
    
    public function property()
    {
        return $this->belongsTo('App\Models\Property', 'property_id', 'id');
    }

    public function floors()
    {
        return $this->hasMany('App\Models\Floor', 'tower_id', 'id');
    }
}