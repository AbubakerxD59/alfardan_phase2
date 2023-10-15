<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Scopes\UserScope;

class Survey extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'property_id',
        'apartment_id',
        'link',
        'survey_id',
		'tenant_type',
		'status'
    ];


    public function property()
    {
       return Property::whereIn('id',explode(",",$this->property_id))->get();
    }

    public function apartment()
    {
        return $this->belongsTo('App\Models\Apartment','apartment_id','id');
    }
	
	public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		 if($admin->type>2){
			 $property=json_decode($admin->property_id);
			 $query->where(function ($query) use ($property) {
				 foreach($property as $val){ 
					 $query->orWhere('property_id','like','%,'.$val.',%');
					 $query->orWhere('property_id','like',$val.',%');
					 $query->orWhere('property_id',$val);
					 $query->orWhere('property_id','like','%,'.$val);
				 }
			});
		 }
		return $query;
	}
	
	 protected static function booted()
     {
        static::addGlobalScope(new UserScope);
    }	
	 
}
