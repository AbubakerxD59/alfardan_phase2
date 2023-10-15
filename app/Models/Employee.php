<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasPermissionsTrait;
use App\Models\Property;

class Employee extends Authenticatable
{
	
	use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait;
    protected $guard = 'admin';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'emp_id',
        'name',
        'email',
        'password',
        'job_role',
        'dob',
        'office_number',
        //'apartment_id',
        'property_id',
        'type',
        'phone',
		'profile',
		'status'
    ];
	
	
	 public static $roles=[
	 		'1'	=>	'System Admin',
	 		'2'	=>	'Admin',
	 		'3'	=>	'Concierge',
	 		'4'	=>	'Customer Service',
	 		'5'	=>	'Leasing',
	 		'6'	=>	'Marketing',
	 		'7'	=>	'Maintenance'
	 ];

    // public function users()
    // {
    //     return $this->belongsTo('App\Models\User','user_id','id');
    // }
    
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
	public function getProfileAttribute($value)
    {
       if($value!=null){
            return asset('uploads/' . $value);
        }
    }
	
	
	public function Property()
    {
        return $this->belongsTo('App\Models\Property','property_id','id');
    }
	
	public function propertylisit()
    {	$property=json_decode($this->property_id,true);
	 	
       return !empty($property)?Property::whereIn('id',$property)->get():Property::whereIn('id',[0])->get();
    }

    public function Apartment()
    {
        return $this->belongsTo('App\Models\Apartment','apartment_id','id');
    }
	

	
}    