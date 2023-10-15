<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use App\Scopes\UserScope;

class MaintenanceAbsentiaRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone',
        'property',
        'date',
        'time',
        'description', 
		'form_id',
        'property_id',
        'apartment_id',
        'submission_date',
        'status',
        'reason',
        'term',
		'user_id',
		'form_status',
    ];

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
                'maintenance_absentia_request_id' => $this->id
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

    public function _property()
    {
        return $this->belongsTo('App\Models\Property','property_id','id');
    }

    public function apartment()
    {
        return $this->belongsTo('App\Models\Apartment','apartment_id','id');
    }
	protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }
	
	public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		 if($admin->type>2){
			 $property=json_decode($admin->property_id);
			$query->whereHas('user', function ($qry) use ($property) {
			 	$qry->whereHas('userpropertyrelation', function ($qry) use ($property) {
            		$qry->whereIn('property_id', $property);
            	});
            });
		 }
		return $query;
	}
	
	 protected static function booted()
     {
        static::addGlobalScope(new UserScope);
    }
	
}
