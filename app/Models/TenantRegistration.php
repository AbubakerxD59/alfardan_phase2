<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class TenantRegistration extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
    	
        'name',
        'user_id',
        'property_id',
        'apartment_id',
        'dob',
        'email',
        'emergency_contact',
        'nationality',
        'occupants',
        'occupant_name',
        'term_cond'

        
    ];

      /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'id'        =>'integer',
        'name'      =>'string',
        'user_id'   =>'integer',
        'property_id'  =>'integer',
        'apartment_id' =>'integer',
        'dob'       =>'string',
        'email'     =>'string',
        'emergency_contact' =>'string',
        'nationality'   =>'string',
        'occupants'     =>'integer',
        'occupant_name' =>'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
        'name'      =>'required|string|max:190',
        'user_id'   =>'integer',
        'property_id'  =>'required|integer',
        'apartment_id' =>'required|integer',
        'dob'       =>'required|string|max:190',
        'email'     =>'required|string|max:190|unique:tenant_registrations',
        'emergency_contact' =>'required|string|max:190',
        'nationality'   =>'required|string|max:190',
        'occupants'     =>'required|integer',
        'occupant_name' =>'required|string|max:190',
        'terms' => 'required|mimes:pdf',
    ];


    public static function getRules() {
        return static::$rules;
    }

    public function getTermCondAttribute($value)
    {
         if($value!=null)
		{
        	$url=asset('uploads/' . $value);
            return $url;
      	}
    }

    public function property()
    {
        return $this->belongsTo('App\Models\Property','property_id','id');
    }

    public function apartment()
    {
        return $this->belongsTo('App\Models\Apartment','apartment_id','id');
    }
	
	public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
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
