<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'maintenance_id',
        'property_id',
        'floor_id',
        'tower_id',
        'apartment_id',
        'complaint_id',
        'type',
        'status',
		'title',
        'message'
    ];
	
	
	public function getCreatedAtAttribute($value)
{
		
		$d=strtotime($value);
    return date("h:i a d-m-Y ", $d);
}

    public function tenant(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    } 

    public function properties(){
        return $this->belongsTo('App\Models\Property', 'property_id', 'id');
    }
}