<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'title',
        'content',
        'thumbnail',
        'author',
        'slug',
    ];
}
