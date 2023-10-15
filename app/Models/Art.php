<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
class Art extends Model
{

   public $table = 'arts';
  
  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
	  'art_gallery_id',
    'name',
    'artist_name',
    'submission',
    'description',
    'status',
    'photo',
    'photo1',
    'photo2',
    'photo3',
    'photo4',

      
  ];

    /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [

    'id'             =>'integer',
    'art_gallery_id' =>'integer',
    'name'           =>'string',
    'artist_name'    =>'string',
    'submission'     =>'string',
    'description'    =>'string',
    'status'         =>'integer',
    'photo'          =>'string',
    'photo1'         =>'string',
    'photo2'         =>'string',
    'photo3'         =>'string',
    'photo4'         =>'string',

  ];

  /**
   * Validation rules
   *
   * @var array
   */
  public static $rules = [
      
    'name'        =>'required|string|max:190',
    'artist_name' =>'required|string|max:190',
    'submission'  =>'required|string',
    'description' =>'required|string',
    'photo'       =>'mimes:jpg,jpeg,png|max:2048',
    'photo1'      =>'mimes:jpg,jpeg,png|max:2048',
    'photo2'      =>'mimes:jpg,jpeg,png|max:2048',
    'photo3'      =>'mimes:jpg,jpeg,png|max:2048',
    'photo4'      =>'mimes:jpg,jpeg,png|max:2048',
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
  public function getPhoto3Attribute($value)
  {
    if($this->attributes['photo3']){

    return asset('uploads/' . $value);
    }
  }
  public function getPhoto4Attribute($value)
  {
    if($this->attributes['photo4']){

    return asset('uploads/' . $value);
    }
  }
  public static function getRules() {
    return static::$rules;
  }

  public function gallery()
  {
      return $this->belongsTo('App\Models\ArtGallery','art_gallery_id','id');
  }

  protected function serializeDate(DateTimeInterface $date)
  {
      return $date->format('Y-m-d');
  }
	

}
