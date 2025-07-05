<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'privacy',
        'title',
        'description',
        'ingredients',
        'directions',
        'photo_path',
    ];
}
