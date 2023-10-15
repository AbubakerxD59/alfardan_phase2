<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'cover',
        'text'
    ];

    public function setCoverAttribute($file)
    {
        if ($file) {
            $name = time().'.'.$file->extension();
            $file->storeAs('', $name, 'uploads');
            $this->attributes['cover'] = $name;
        }
    }

    public function getCoverAttribute($value)
    {
        return asset('uploads/' . $value);
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }
	 
}
