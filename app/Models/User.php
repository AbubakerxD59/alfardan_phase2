<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use DB;
use DateTimeInterface;
use App\Scopes\UserScope;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'telephone',
        'dob',
        'type',
        'property',
        'apt_number',
        'password',
        'is_guest',
        'status',
        'tenant_type',
        'nom',
        'start_date',
        'reject_reason',
		'original_tenant_name',
        'company_name',
		'fusername',
        'registered_as',
		'name',
        'submit_date',
		'refrence_id',
		'contract',
		'end_date',
		'profile',
		'full_name',
		'message',
		'device_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
	
	public function getContractAttribute($value)
    {   
        if($this->attributes['contract']){
            return asset('uploads/' . $value);
        }
    }
	public function getProfileAttribute($value)
    {
		 if($this->attributes['profile']){
        return asset('uploads/' . $this->attributes['profile']);
        }
       // return asset('uploads/' . $value);
    }

    public function getDobAttribute($value){
        $explode_date=explode('-',$value);
        $update=[];
        if(count($explode_date)>1){
            if(intval($explode_date[1])>12 && intval($explode_date[2])>1000){
                $month=$explode_date[0];
                $day=$explode_date[1];
                $year=$explode_date[2];
                $value=$year.'-'.$month.'-'.$day; 
                $update['dob']=$value;
            }else if(intval($explode_date[1])>12 && intval($explode_date[0])>1000){
                $month=$explode_date[2];
                $day=$explode_date[1];
                $year=$explode_date[0];
                $value=$year.'-'.$month.'-'.$day;
                $update['dob']=$value;
            }
        }else{
           // dd($explode_date);
        }

        if(count($update)){
            Self::find($this->id)->update($update);
        }

        return  Carbon::parse($value)->format('d-m-Y');// date("Y-m-d",strtotime($value));
    }
	public function images()
    {
        return $this->hasOne('App\Models\Image');
    }
	
	public function families(){
        //return $this->hasMany('App\Models\FamilyMember','refrence_id','id');
		return $this->hasMany('App\Models\FamilyMember','refrence_id','id')->where('user_id','!=',null);
    }
	public function familycount(){
        return $this->families->count('refrence_id');
    }
	
	public function familylink(){
		
        return $this->belongsTo('App\Models\FamilyMember','email','email');

    }
	public function linkfamily(){
        return $this->hasOne('App\Models\FamilyMember','user_id','id');

    }
    public function corporates(){
        return $this->hasMany('App\Models\CorporateIndividual','user_id','id');

    }

    public function vehicles(){
        return $this->hasMany('App\Models\VehicleRequest','user_id','id');
    }

    public function maintenances(){
        return $this->hasMany('App\Models\MaintenanceRequest','user_id','id');
    }

    public function reviews(){
        return $this->hasMany('App\Models\Review','user_id','id');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\Booking','user_id','id');
    }
	 public function housekeeping_requests()
    {
        return $this->hasMany('App\Models\HousekeeperRequest','user_id','id');
    }

    public function service_requests()
    {
        return $this->hasMany('App\Models\ServiceRequest','user_id','id');
    }

    public function petapplications()
    {
        return $this->hasMany('App\Models\PetApplication','user_id','id');
    }

    public function guestrequests()
    {
        return $this->hasMany('App\Models\GuestAccessRequest','user_id','id');
    }

    public function accesskeys()
    {
        return $this->hasMany('App\Models\AccessKeyRequest','user_id','id');
    }
	
	public function products()
    {
        return $this->hasMany('App\Models\Product','user_id','id');
    }
	
	public function lifestyles()
    {
        return $this->hasMany('App\Models\Product','user_id','id')->where('type','!=','');
    }
	
	public function conciergeview(){
        return $users = DB::table('concierge')
        ->selectRaw('*')
        ->where('user_id', '=', $this->id)
        ->get();
    }
	 public function lifestyleview(){
        return $users = DB::table('lifestyle')
        ->selectRaw('*')
        ->where('user_id', '=', $this->id)
        ->where('type','!=','')
        ->get();
    }

    public function hospitalityview(){
        return $users = DB::table('hospitality')
        ->selectRaw('*')
        ->where('user_id', '=', $this->id)
        ->where('type','!=','')
        ->get();
    }
	
	 protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
	public function userpropertyrelation(){
        return $this->belongsTo('App\Models\UserPropertyRelation','id','user_id')->where('status',1); 
    }

    public function getPropertyAttribute($value){ 
        return @$this->userpropertyrelation->property->name;
    }
	public function getAptNumberAttribute($value){
	  
        return @$this->userpropertyrelation->apartment->name;
    }
	//public function uproperty()
    //{
   //     return $this->belongsTo('App\Models\Property','property','id');
   // }

   // public function uapartment()
   // {
   //     return $this->belongsTo('App\Models\Apartment','apt_number','id');
   // }
	
	
    public function getTypeAttribute($value)
    {
        return intval($value)==10?'corporate':$value;
    }
	
     public function getRegisteredAsAttribute($value)
    {
		//$this->attributes['password']
		if(empty($value)){
			$value=$this->attributes['registered_as']=$this->attributes['type'];
			//$this->save();
		}
        return $value;
    }  
	
	
	public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		 if($admin->type>2){
			 $property=json_decode($admin->property_id);
			 $query->where(function ($query) use ($property) {
					$query->WhereHas('userpropertyrelation',function ($query) use ($property) {
						$query->whereIn('property_id',$property);
					});
				});
		 }
		return $query;
	}
	
	 protected static function booted()
     {
        static::addGlobalScope(new UserScope);
    } 
	public function setfamiltmemberproperty(){
		$user=$this->linkfamily?$this->linkfamily->user:$this->familylink->user;
		$user->userpropertyrelation;
		
		$property_details = array(
			'user_id' => $this->id,
			'property_id' => $user->userpropertyrelation->property_id,
			'apartment_id' => $user->userpropertyrelation->apartment_id,
			'status' => 1,
		);
		UserPropertyRelation::create($property_details);
	}
}
