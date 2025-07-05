<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'recipe_id',
        'user_id',
        'message',
    ];
}
