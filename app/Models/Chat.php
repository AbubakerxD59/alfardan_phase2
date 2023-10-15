<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;

class Chat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user1_id', 'user2_id', 'type'
    ];

    public function user1()
    {
        return $this->belongsTo('App\Models\Employee', 'user1_id');
    }

    public function user2()
    {
        return $this->belongsTo('App\Models\User', 'user2_id');
    }
    
    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'chat_id');
    }
    
    public function last_msg()
    {
        return $this->hasOne('App\Models\Message', 'chat_id')->latest();
    }
	
	
	public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		if($admin->type>2){
			$property=json_decode($admin->property_id);
			
			$query->whereHas('user2',function ($query) use ($property) {
				foreach($property as $val){
					$query->orWhere('property',$val);
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
