<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use App\Scopes\UserScope;
	
class OfferUpdate extends Model
{
    public $table = 'offer_updates';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
  	
      'title',
      'type',
      'link',
      'submission',
      'description',
      'property_id',
      'tenant_type',
      'status',
      'photo',
	   'data_id',
       'whatsapp',
       'outlet'

        
    ];

      /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'id'         =>'integer',
        'title'      =>'string',
        'type'       =>'string',
        'link'       =>'string',
        'submission' =>'string',
        'description' =>'string',
        'property_id' =>'string',
        'tenant_type' =>'string',
        'status'      =>'integer',
        'photo'       =>'string',
        'data_id'     =>'integer',
        'whatsapp'    => 'integer', 
        'outlet'      => 'string',		
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
        'title'      =>'required|string|max:190',
        'type'       =>'required|string|max:190',
        'submission' =>'required|string',
        'description'=>'required|string|max:1000',
        'property_id'=>'required|max:190',
        'tenant_type'=>'required|max:190',
        // 'status'   =>'string|max:190',
        'photo'      =>'mimes:gif,jpg,jpeg,png|max:2048',
        'data_id'      =>'required',
        'outlet'    => 'required',
    ];

    
    public function getPhotoAttribute($value)
    {
      /*if($this->attributes['photo']){

      return asset('uploads/' . $value);
      }*/
		
	if($this->attributes['photo']){

      	$url=asset('uploads/' . $value);
	 	$headers=get_headers($url);
		 if(stripos($headers[0],"200 OK")){
			 return $url;
		 }else{
	  		return asset('alfardan/assets/placeholder.png');
		 }
		  
      }
	 
		return $value;
		
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
        if(!empty($admin)){
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
	}
	
    protected static function booted()
     {
        static::addGlobalScope(new UserScope);
    }
	 
}
