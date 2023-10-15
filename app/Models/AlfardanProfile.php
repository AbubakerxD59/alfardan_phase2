<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlfardanProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
    	
        'title',
        'title1',
        'description',
        'description1',
        'photo',
        'photo1'
        
    ];

    public function getPhotoAttribute($value)
    {
       // return asset('uploads/' . $value);
		
		
	 if($value){

      	$url=asset('uploads/' . $value);
	 	$headers=get_headers($url);
		 if(stripos($headers[0],"200 OK")){
			 return $url;
		 }else{
	  		return asset('alfardan/assets/placeholder.png');
		 }
		  
      }  
		
    }
	
	
	
    public function getPhoto1Attribute($value)
    {
		
		 // return asset('uploads/' . $value);
         if($value){

      	$url=asset('uploads/' . $value);
	 	$headers=get_headers($url);
		 if(stripos($headers[0],"200 OK")){
			 return $url;
		 }else{
	  		return asset('alfardan/assets/placeholder.png');
		 }
		  
      }  
    }
	

}
