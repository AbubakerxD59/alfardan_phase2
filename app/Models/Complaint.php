<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;
class Complaint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type',
        'description',
        'status',
        'user_id',
		'property_id',
        'apartment_id',
        'form_id',
        'mobile',
		'form_status'
    ];

    public function addImages($files)
    {
        foreach ($files as $key => $file) {

            $name = time() .'-'. $key .'.'. $file->extension();
            $file->storeAs('', $name, 'uploads');

            $images[] = [
                'path' => $name,
                'complaint_id' => $this->id
            ];
        }

        Image::insert($images);
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
	
	public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function property()
    {
        return $this->belongsTo('App\Models\Property','property_id','id');
    }

    public function apartment()
    {
        return $this->belongsTo('App\Models\Apartment','apartment_id','id');
    }
	
	public function reviews(){

        return $this->hasMany('App\Models\Review','entity_id','id')->where('entity_type','customer_service');

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
	 
    
	
	protected function serializeDate(\DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}
}
