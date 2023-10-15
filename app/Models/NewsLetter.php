<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    use HasFactory;

    public $table = 'news_letters';

    protected $fillable = [
        'title',
        'description',
        'cta_button',
        'cta_link',
        'photo',
        'head_id',
        'status',
    ];

    public function header()
    {
        return $this->belongsTo('App\Model\NewsLetterHead', 'head_id', 'id');
    }
}
