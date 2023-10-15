<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'location',
        'type',
        'description',
        'date',
        'time',
        'status',
        'user_id',
		'tenant_type',
        'ticket_id',
        'property_id',
        'apartment_id',
		'emp_name',
		'form_status'
    ];

    public function addImages($files)
    {
        foreach ($files as $key => $file) {

            $name = time() .'-'. $key .'.'. $file->extension();
            $file->storeAs('', $name, 'uploads');

            $images[] = [
                'path' => $name,
                'maintenance_request_id' => $this->id
            ];
        }

        Image::insert($images);
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
	public function users()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
	public function reviews(){

        return $this->hasMany('App\Models\Review','entity_id','id')->where('entity_type','maintenance');

    }
	public function totalreviews(){
        return $this->reviews->avg('stars');
    }
	public function property()
    {
        return $this->belongsTo('App\Models\Property','property_id','id');
    }

    public function apartment()
    {
        return $this->belongsTo('App\Models\Apartment','apartment_id','id');
    }
	 
	   
	
	protected function serializeDate(\DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}
}
