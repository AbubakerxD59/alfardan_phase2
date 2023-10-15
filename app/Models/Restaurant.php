<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;
use App\Models\Property;
class Restaurant extends Model
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
        'latitude',
        'longitude',
        'cover',
		'date',
        'view_link',
        'property',
        'tenant_type',
		'menu1',
        'menu2',
		'menu3',
        'menu4',
		'news_feed',
		'locationdetail',
        'whatsapp',
        'facebook',
        'instagram',
        'snapchat',
        'tiktok',
        'order'
    ];

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
        if($value || !empty($value)){       
            return asset('uploads/' . $value);
        }
    }
	
	public function getMenu1Attribute($value)
    {
       if($this->attributes['menu1']){
            return asset('uploads/' . $this->attributes['menu1']);
        }
    }

    public function getMenu2Attribute($value)
    {
        if($this->attributes['menu2']){
            return asset('uploads/' . $this->attributes['menu2']);
        }
    }
	
	public function getMenu3Attribute($value)
    {
       if($this->attributes['menu3']){
            return asset('uploads/' . $this->attributes['menu3']);
        }
    }

    public function getMenu4Attribute($value)
    {
       if($this->attributes['menu4']){
            return asset('uploads/' . $this->attributes['menu4']);
        }
    }

    public function getMenu5Attribute($value)
    {
       if($this->attributes['menu5']){
            return asset('uploads/' . $this->attributes['menu5']);
        }
    }
    public function addImages($files)
    {
        foreach ($files as $key => $file) {

            $name = time() .'-'. $key .'.'. $file->extension();
            $file->storeAs('', $name, 'uploads');

            $images[] = [
                'path' => $name,
                'restaurant_id' => $this->id
            ];
        }

        Image::insert($images);
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image','restaurant_id');
    }
	
	public function reviews(){

        return $this->hasMany('App\Models\Review','entity_id','id')->where('entity_type','restaurants');

    }

    public function totalreviews(){
        return $this->reviews->count('stars');
    }
	public function avgreviews(){
        return $this->reviews->avg('stars');
    }

    public function fiveviews(){
        return $this->reviews->where('stars','=',5);
    }
    public function fourviews(){
        return $this->reviews->where('stars','=',4);
    }
    public function threeviews(){
        return $this->reviews->where('stars','=',3);
    }
    public function twoviews(){
        return $this->reviews->where('stars','=',2);
    }
    public function oneview(){
        return $this->reviews->where('stars','=',1);
    }
	
	protected static function booted()
     {
        static::addGlobalScope(new UserScope);
    }
	public function getPropertyAttribute($data)
    {
        return explode(',', $data);
    }

    public function getpropertyname(){
       return Property::whereIn('id',$this->property)->select('name')->get();
    }
	
	
	public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		 if($admin->type>2){
			 $property=json_decode($admin->property_id);
			 $query->where(function ($query) use ($property) {
				 foreach($property as $val){ 
					 $query->orWhere('property','like','%,'.$val.',%');
					 $query->orWhere('property','like',$val.',%');
					 $query->orWhere('property',$val);
					 $query->orWhere('property','like','%,'.$val);
				 }
			});
		 }
		return $query;
	}
	
}
