<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Models\Apartment;
use App\Scopes\UserScope;

class Update extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'cover',
        'description',
        'property_id',
        'apartment_id',
        'circular_id',
        'image',
		'status',
        'pdffile',
		'circular_name'
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
		if($this->attributes['cover']){
        return asset('uploads/' . $value);
		}
    }
	
	 public function getImageAttribute($value)
    {
        return asset('uploads/' . $value);
    }

    public function property()
    {
       return Property::whereIn('id',explode(",",$this->property_id))->get();
    }

    public function apartment()
    {
        return Apartment::whereIn('id',explode(",",$this->apartment_id))->get();
    }
	
	public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		 if($admin->type>2){
			 $property=json_decode($admin->property_id);
			 $query->where(function ($query) use ($property) {
				 foreach($property as $val){
					 $query->orWhere('property_id',$val);
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
