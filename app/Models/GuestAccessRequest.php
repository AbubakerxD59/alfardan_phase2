<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use App\Scopes\UserScope;

class GuestAccessRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'date',
        'time',
        'photo',
        'user_id',
		'form_id',
        'number',
        'property_id',
        'apartment_id',
        'status',
        'reason',
        'term',
        'submission_date',
		'form_status',
		'name',
        'term_cond'
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
        if($this->attributes['photo']){
            return asset('uploads/' . $value);
        }
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
