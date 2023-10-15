<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivilegeProgram extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'file'
    ];

    public function getFileAttribute($value)
    {
        return asset('uploads/' . $value);
    }
	
	 
}
