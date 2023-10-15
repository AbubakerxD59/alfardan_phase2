<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use App\Scopes\UserScope;
class ArtGallery extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
  	
      'name',
      'phone',
      'location',
      'description',
      'view_link',
      'property_id',
      'tenant_type',
      'status',
      'photo',

        
    ];

      /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'id'        =>'integer',
        'name'      =>'string',
        'phone'     =>'string',
        'location'  =>'string',
        'description' =>'string',
        'view_link'   =>'string',
        'property_id' =>'string',
        'tenant_type' =>'string',
        'status'      =>'integer',
        'photo'       =>'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
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

    // public function setPhotoAttribute($file)
    // {
    //   if ($file) {
    //     $name = time().'.'.$file->extension();
    //     $file->storeAs('', $name, 'uploads');
    //     $this->attributes['photo'] = $name;
    //   }
    // }
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
