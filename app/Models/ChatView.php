<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;

class ChatView extends Model
{
	
	protected $table = 'chatview';
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
	
	protected static function booted()
     {
        static::addGlobalScope(new UserScope);
    }	
	
		public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		if($admin->type>2){
			$property=json_decode($admin->property_id);
			 
			$query->whereHas('user2', function ($qry) use ($property) {
			 	$qry->whereHas('userpropertyrelation', function ($qry) use ($property) {
            		$qry->whereIn('property_id', $property);
            	});
            });
			
		}
			
		return $query;
	}
	

}
