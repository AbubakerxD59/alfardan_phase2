<?php

namespace App\Models;

use DateTimeInterface;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    public $table = 'offers';

    protected $fillable = [
  	
        'title',
        'type',
        'outlet',
        'phone',
        'link',
        'whatsapp',
        'location_detail',
        'instagram',
        'snapchat',
        'tiktok',
        'facebook',
        'submission',
        'description',
        'points',
        'photo',
        'property_id',
        'tenant_type',
        'status',
        'order', 
      ];

      public function getPointsAttribute($data)
    {
        return explode(',', $data);
    }

    public function getPhotoAttribute($data){
		if($data){
			return asset('uploads/' . $data);
		}
	}

    public function property()
    {
        return $this->belongsTo('App\Models\Property','property_id','id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
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
