<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;
use App\Models\Property;
class Facility extends Model
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
        'latitude',
        'longitude',
        'cover',
        'tenant_type',
        'time',
        'date',
        'property',
		'news_feed',
		'endtime',
		'avlb_days',
		'locationdetail',
        'status',
        'term_cond'
    ];
 	
	protected $casts = [
        'avlb_days' => 'array',
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
        return asset('uploads/' . $value);
    }

    public function getTermCondAttribute($value)
    {
         if($value!=null)
		{
        	$url=asset('uploads/' . $value);
            return $url;
      	}
    }

    public function addImages($files)
    {
        foreach ($files as $key => $file) {

            $name = time() .'-'. $key .'.'. $file->extension();
            $file->storeAs('', $name, 'uploads');

            $images[] = [
                'path' => $name,
                'facility_id' => $this->id
            ];
        }

        Image::insert($images);
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image','facility_id');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\Booking','facility_id','id');
    }

    public function reservations(){
        return $this->bookings->sum('reservations');
    }

    public function reviews(){

        return $this->hasMany('App\Models\Review','entity_id','id')->where('entity_type','facilities');

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
