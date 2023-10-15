<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateIndividual extends Model
{
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
        'company_name',
        'user_id',
        'refrence_id',
        'status',
        'reject_reason'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
	public function refrenceuser()
    {
        return $this->belongsTo('App\Models\User','refrence_id','id');
    }
	

    
}    