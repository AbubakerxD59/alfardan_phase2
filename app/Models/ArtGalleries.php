<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;

class ArtGalleries extends Model
{
    protected $table = 'artgallery';
    protected $fillable = [
        'name',
        'phone',
        'latitude',
        'longitude',
        'location',
        'description',
        'view_link',
        'property_id',
        'tenant_type',
        'status',
        'photo',
    ];
    public static $rules = [
        
        'name'      =>'required|string|max:190',
        'phone'     =>'string',
        'location'  =>'required|string',
        'description' =>'required|string',
        'view_link'       =>'required|string|max:190',
        'property_id'     =>'required|max:190',
        'tenant_type' =>'required|max:190',
        // 'status'   =>'string|max:190',
        'photo'     =>'mimes:gif,jpg,jpeg,png|max:2048',
    ];
    public function getPhotoAttribute($value)
    {
		
      if($this->attributes['photo']){

      	if($value!=null){
              $url=asset('uploads/' . $value);
        }
	 	$headers=get_headers($url);
		 if(stripos($headers[0],"200 OK")){
			 return $url;
		 }else{
	  		return asset('alfardan/assets/placeholder.png');
		 }
		  
      } 
	  
    }
    public static function getRules() {
        return static::$rules;
    }

    public function property()
    {
        return $this->belongsTo('App\Models\Property','property_id','id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    public function art()
    {
        return $this->hasMany('App\Models\Art','art_gallery_id','id');
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
