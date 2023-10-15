<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPropertyRelation extends Model
{
	public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'property_id',
        'apartment_id',
        'status'
        
    ];
	 public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
	public function property(){
        return $this->belongsTo('App\Models\Property','property_id','id');

    }

    public function apartment(){
        return $this->belongsTo('App\Models\Apartment','apartment_id','id');

    } 
}
