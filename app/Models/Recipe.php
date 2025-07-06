<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;
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

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likeCount($type)
    {
        return $this->likes()->where('type', $type)->count();
    }

    // si user udah pernah like jenis apa
    public function likedTypeByUser($userId)
    {
        $like = $this->likes()->where('user_id', $userId)->first();
        return $like ? $like->type : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
