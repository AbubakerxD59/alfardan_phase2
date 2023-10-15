<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'sender_id', 'receiver_id', 'chat_id','file'
    ];
	public function getFileAttribute($value)
    {   
        if($this->attributes['file']){
            return asset('uploads/' . $value);
        }
    }
	
	public function getTextAttribute($value)
    {   if (filter_var($value, FILTER_VALIDATE_URL)&& !request()->is('api/*')) {
			if(getimagesize( $value)){
				return  '<div style="float: right;width: 100%;margin-top: 10px;">
						<a href="'.$value.'" target="_blank"><img src="'.$value.'" class="img-thumbnail" style="width: 100px;float: right;" /></a></div>';
			} 		
		}
	 return $value;	
    }
	
	
    public function addImages($ids)
    {
        Image::whereIn('id', explode(',', $ids))->update(['message_id' => $this->id]);
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
    
    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id');
    }

    public function chat()
    {
        return $this->belongsTo('App\Models\Chat', 'chat_id');
    }
    
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }


    public  function isuser()
    {
       return $this->chat->user2_id==$this->sender_id?true:false;
        
    } 
}
