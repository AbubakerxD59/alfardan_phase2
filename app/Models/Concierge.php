<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concierge extends Model
{
    protected $fillable = ['banner', 'safety'];



    public function getBannerAttribute($value)
    {
        return asset('uploads/' . $value);
    }

    public function getSafetyAttribute($value)
    {
        return asset('uploads/' . $value);
    }
}