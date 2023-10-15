<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
	
	protected $appends = ['linkuser'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone_number',
        'property',
        'reject_reason',
        'user_id',
        'refrence_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','refrence_id','id');
    }

    //public function referuuser()
    //{
    //    return $this->belongsTo('App\Models\User','refrence_id','id');
   // }
    
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
	
	public function getlinkuserAttribute(){
		$this->user;
	}
	

}    