<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'title',
        'location',
        'description',
        'phone',
        'email',
        'latitude',
        'longitude',
        'cover',
        'property_id',
		 'bedrooms',
        'bathrooms',
        'area',
        'view_link',
        'short_description',
        'status',
        'availability',
        'floor_id',
        'tower_id',
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

    public function addImages($files)
    {
        foreach ($files as $key => $file) {

            $name = time() .'-'. $key .'.'. $file->extension();
            $file->storeAs('', $name, 'uploads');

            $images[] = [
                'path' => $name,
                'apartment_id' => $this->id
            ];
        }

        Image::insert($images);
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
	public function property(){
        return $this->belongsTo('App\Models\Property');

    }
    public function tower(){
        return $this->belongsTo('App\Models\Tower', 'tower_id', 'id');
    }
    public function floor(){
        return $this->belongsTo('App\Models\Floor', 'floor_id', 'id');
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
	
	
}
