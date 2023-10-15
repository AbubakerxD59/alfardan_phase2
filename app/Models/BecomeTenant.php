<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BecomeTenant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
    	
        'fullname',
        'email',
        'phone',
        'bedrooms',
        'company_name',
		'message'
        
        
    ];

    
}
