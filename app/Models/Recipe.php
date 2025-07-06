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

    // Relationship: a recipe has many likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Like count per type
    public function likeCount($type)
    {
        return $this->likes()->where('type', $type)->count();
    }

    // Get like type by user
    public function likedTypeByUser($userId)
    {
        $like = $this->likes()->where('user_id', $userId)->first();
        return $like ? $like->type : null;
    }

    // Relationship: a recipe belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
