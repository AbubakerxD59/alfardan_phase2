<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
	use SoftDeletes;
	
	    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'phone',
        'condition',
        'price',
        'status',
        'featured',
        'cover',
        'user_id',
        'category_id',
        'email',
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

    //public function addImages($ids)
   // {
   //     Image::whereIn('id', explode(',', $ids))->update(['product_id' => $this->id]);
   // }
	public function addImages($files)
    {
        foreach ($files as $key => $file) {

            $name = time() .'-'. $key .'.'. $file->extension();
            $file->storeAs('', $name, 'uploads');

            $images[] = [
                'path' => $name,
                'product_id' => $this->id
            ];
        }

        Image::insert($images);
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = auth()->id();
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
	public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'category_id','id');
    }
	protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
	
	
	public function scopeAdmin($query){
		$admin=\App\Helpers\helpers::$admin;
		if($admin->type>2){
			$property=json_decode($admin->property_id);
			$query->whereHas('seller',function ($query) use ($property) {
				$query->whereHas('userpropertyrelation',function ($query) use ($property) {
                    foreach($property as $val){
                        $query->orWhere('property',$val);
                    }
                });
			});
		}
		return $query;
	}
	
	 protected static function booted()
     {
        static::addGlobalScope(new UserScope);
    }
	 
}
