<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
class NewsFeed extends Model
{

   public $table = 'news_feeds';
  
  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'description',
    'photo',
    'photo1',
    'photo2',
   
      
  ];

    /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [

    'id'             =>'integer',
    'description'    =>'string',
    'status'         =>'integer',
    'photo'          =>'string',
    'photo1'         =>'string',
    'photo2'         =>'string',
  ];

  /**
   * Validation rules
   *
   * @var array
   */
  public static $rules = [
      
    'description' =>'required|string',
    'photo'       =>'mimes:gif,jpg,jpeg,png|max:2048',
    'photo1'      =>'mimes:gif,jpg,jpeg,png|max:2048',
    'photo2'      =>'mimes:gif,jpg,jpeg,png|max:2048',
  ];

  
  public function getPhotoAttribute($value)
  {
    if($this->attributes['photo']){

    return asset('uploads/' . $value);
    }
  }
  public function getPhoto1Attribute($value)
  {
    if($this->attributes['photo1']){

    return asset('uploads/' . $value);
    }
  }
  public function getPhoto2Attribute($value)
  {
    if($this->attributes['photo2']){

    return asset('uploads/' . $value);
    }
  }
 
  public static function getRules() {
    return static::$rules;
  }

  protected function serializeDate(DateTimeInterface $date)
  {
      return $date->format('Y-m-d');
  }
	
}
