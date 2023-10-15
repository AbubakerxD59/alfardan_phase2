<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use App\Scopes\UserScope;

class AccessKeyRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'card_type',
        'reason',
        'location',
        'phone',
        'access_type',
        'expiry_date',
        'quantity',
        'charge',
        'date',
        'time',
        'status',
        'employee',
        'description',
        'user_id',
		'form_id',
        'submission_date',
        'property_id',
        'apartment_id',
        'photo',
		'form_status',
        'term_cond',
    ];

    public function getTermCondAttribute($value)
    {
         if($value!=null)
		{
        	$url=asset('uploads/' . $value);
            return $url;
      	}
    }
	
	public function setPhotoAttribute($file)
    {
        if ($file) {
            $name = time().'.'.$file->extension();
            $file->storeAs('', $name, 'uploads');
            $this->attributes['photo'] = $name;
        }
    }

    public function getPhotoAttribute($value)
    {
        return asset('uploads/' . $value);
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
	
	protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }
	
	public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		 if($admin->type>2){
			 $property=json_decode($admin->property_id);
			 $query->whereHas('user',function ($query) use ($property) {
			 	$query->whereHas('userpropertyrelation',function ($query) use ($property) {
			 		foreach($property as $val){
					 	$query->orWhere('property_id',$val);
				 	}
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
