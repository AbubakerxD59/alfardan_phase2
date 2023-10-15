<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'icon',
        'background'
    ];

    public function setIconAttribute($file)
    {
        if ($file) {
            $name = time().'.'.$file->extension(); 
            $file->storeAs('', $name, 'uploads');
            $this->attributes['icon'] = $name;
        }
    }

    public function getIconAttribute($value)
    {
        return $value ? asset('uploads/' . $value) : $value;
    }

    public function setBackgroundAttribute($file)
    {
        if ($file) {
            $name = time().'.'.$file->extension(); 
            $file->storeAs('', $name, 'uploads');
            $this->attributes['background'] = $name;
        }
    }

    public function getBackgroundAttribute($value)
    {
        return $value ? asset('uploads/' . $value) : $value;
    }
	
	
}
