<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'apartment_id',
        'category',
        'message',
    ];

    public function tenant(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    } 

    public function properties(){
        return $this->belongsTo('App\Models\Property', 'property_id', 'id');
    }

    public function apartments(){
        return $this->belongsTo('App\Models\Apartment', 'apartments_id', 'id');
    }
}
