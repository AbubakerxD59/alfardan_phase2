<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use App\Scopes\UserScope;

class ClassSlot extends Model
{
	
	 protected $table = 'class_slot';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
  	
      'class_id',
      'time',
      'seats_available',
      'days',
      'status',        
    ];

      /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'id'        =>'integer',
        'class_id'  =>'integer',
        'time'     =>'string',
        'seats_available' =>'integer',
        'days' =>'string',
        'status'   =>'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'time'			=>'required|string',
        'seats_available'  =>'required',
        'days' 			=>'required|string',
        'status'       	=>'required|max:1',
    ];
 
 
    public static function getRules() {
        return static::$rules;
    }

    public function calss()
    {
        return $this->belongsTo('App\Models\ClassEvent','class_id','id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    public function getIsAvailableAttribute()
    {
        return $this->bookings()->whereIn('status',[1,0])->count()==intval($this->seats_available)?0:1;
    }


    public function bookings()
    {
        return $this->hasMany('App\Models\Booking','slot_id','id');
    }
	
	public function reservations(){
		return $this->bookings()->whereIn('status',[1,0])->sum('reservations');
	}
	
 
}
