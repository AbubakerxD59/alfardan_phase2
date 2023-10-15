<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
class PropertyGallery extends Model
{

   public $table = 'property_gallery';
  
  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [   
  ];

    /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [

  ];

  /**
   * Validation rules
   *
   * @var array
   */
  public static $rules = [
  ];

   
  public static function getRules() {
    return static::$rules;
  }

  public function property()
  {
      return $this->belongsTo('App\Models\Property','property_id','id');
  }

  protected function serializeDate(DateTimeInterface $date)
  {
      return $date->format('Y-m-d');
  }



  public function getImageUrlAttribute($value)
    {
        if(!empty($value)){
            return asset($value);
        }
    }
	 
}
