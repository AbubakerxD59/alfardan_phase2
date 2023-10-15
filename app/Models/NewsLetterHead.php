<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetterHead extends Model
{
    use HasFactory;

    public $table = 'news_letter_heads';

    protected $fillable = [
        'title',
        'publish_date',
        'intro',
        'photo',
        'status',
        'type'
    ];
}
