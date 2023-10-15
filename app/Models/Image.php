<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'hotel_id',
        'restaurant_id',
        'resort_id',
        'event_id',
        'class_id',
        'facility_id',
        'product_id',
        'maintenance_request_id',
        'property_id',
        'apartment_id',
        'complaint_id',
        'maintenance_absentia_request_id',
        'message_id'
    ];

    public function getPathAttribute($value)
    {
        if($value || !empty($value)){
            return asset('uploads/' . $value);
        }
    }
	
}
