<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'hotel_id',
        'restaurant_id',
        'resort_id',
        'event_id',
        'class_id',
        'facility_id',
        'reservations',
        'time',
        'date',
        'slot_id',
    ];

    public function user(){

        return $this->belongsTo('App\Models\User','user_id','id');
    }
    
    public function event(){
        return $this->belongsTo('App\Models\Event','event_id','id');
    }

    public function event_register_date(){
        return $this->date;
    }

    public function day(){
		if(!empty($this->date)){
			$paymentDate = $this->date;
			$day = Carbon::createFromFormat('Y-m-d', $paymentDate)->format('l');
			return $day;
		}
		return "-";
    }

    public function class(){
        return $this->belongsTo('App\Models\ClassEvent','class_id','id');
    }

    public function facility(){
        return $this->belongsTo('App\Models\Facility','facility_id','id');
    }

    public function slot(){
        return $this->belongsTo('App\Models\ClassSlot','slot_id','id');
    }
 
}
