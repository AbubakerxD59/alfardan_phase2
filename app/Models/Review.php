<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'entity_type',
        'entity_id',
        'stars',
        'description',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
	 
}
