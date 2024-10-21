<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable = [
        'title',
        'author',
        'published_year',
        'file_url',
        'thumbnail',
        'slug',
    ];    
}
