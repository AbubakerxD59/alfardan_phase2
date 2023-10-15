<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;

class Property extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'location',
        'description',
        'phone',
        'email',
        'residences',
        'facilities',
        'services',
        'privileges',
        'latitude',
        'longitude',
        'cover',
		'short_description',
        'view_link',
		'handbook',
        'safety',
		'status',
		'brochure',
        'safety_handbook',
        'cpnumber',
        'whatsapp'
    ];

    public function getResidencesAttribute($data)
    {
        return explode(',', $data);
    }

    public function getFacilitiesAttribute($data)
    {
        return explode(',', $data);
    }

    public function getServicesAttribute($data)
    {
        return explode(',', $data);
    }

    public function getPrivilegesAttribute($data)
    {
		if(!empty($data)){
			return explode(',', $data);
		}
    	return [];    
    }

    public function setCoverAttribute($file)
    {
        if ($file) {
            $name = time().'.'.$file->extension();
            $file->storeAs('', $name, 'uploads');
            $this->attributes['cover'] = $name;
        }
    }

    public function getCoverAttribute($value)
    {
        if($this->attributes['cover']){
            return asset('uploads/' . $value);
        }
    }
	
	public function getHandbookAttribute($value)
    {
        if($this->attributes['handbook']){
            return asset('uploads/' . $value);
        }
    }

    public function getSafetyAttribute($value)
    {
        if($this->attributes['safety']){
            return asset('uploads/' . $value);
        }
    }
	
	public function getBrochureAttribute($value)
    {
        if($this->attributes['brochure']){
            return asset('uploads/' . $value);
        }
    }
    
    public function getSafetyHandbookAttribute($value)
    {
        if($this->attributes['safety_handbook']){
            return asset('uploads/' . $value);
        }
    }
	
    public function addImages($files)
    {
        foreach ($files as $key => $file) {

            $name = time() .'-'. $key .'.'. $file->extension();
            $file->storeAs('', $name, 'uploads');

            $images[] = [
                'path' => $name,
                'property_id' => $this->id
            ];
        }

        Image::insert($images);
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image','property_id');
    }

    public function gallery()
    {
        return $this->hasMany('App\Models\PropertyGallery','property_id');
    }

    public function p3dview()
    {
        return $this->hasMany('App\Models\Property3dview','property_id');
    }



	public function apartments()
    {
        return $this->hasMany('App\Models\Apartment','property_id','id');
    }

	public function towers()
    {
        return $this->hasMany('App\Models\Tower','property_id','id');
    }
	public function total_apartment(){
        
        return $this->apartments->count('property_id');
    }
	
			
	public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		 if($admin->type>2){
			 $property=json_decode($admin->property_id);
			 $query->where(function ($query) use ($property) {
				 foreach($property as $val){ 
					 $query->orWhere('id',$val);
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
