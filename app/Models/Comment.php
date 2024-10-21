<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment',
        'forum_id',
        'user_id'
    ];

    public function forum() {
        return $this->belongsTo(Forum::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
