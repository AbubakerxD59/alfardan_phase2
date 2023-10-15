<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use App\Scopes\UserScope;

class ServiceRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type',
        'date',
        'time',
        'address',
        'payment_method',
        'status',
        'attendee',
        'user_id',
		'form_id',
        'property_id',
        'apartment_id',
        'submission_date',
        'reason',
		'form_status',
        'term_cond',
    ];

    public function getTermCondAttribute($value)
    {
         if($value!=null)
		{
        	$url=asset('uploads/' . $value);
            return $url;
      	}
    }
	
	public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function property()
    {
        return $this->belongsTo('App\Models\Property','property_id','id');
    }

    public function apartment()
    {
        return $this->belongsTo('App\Models\Apartment','apartment_id','id');
    }
	
	protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }
	
	public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		 if($admin->type>2){
			 $property=json_decode($admin->property_id);
			 $query->whereHas('user', function ($qry) use ($property) {
			 	$qry->whereHas('userpropertyrelation', function ($qry) use ($property) {
            		$qry->whereIn('property_id', $property);
            	});
            });
		 }
		return $query;
	}
	
	 protected static function booted()
     {
        static::addGlobalScope(new UserScope);
    }	
	 
}
