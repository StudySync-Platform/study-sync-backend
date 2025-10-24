<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\Visibility;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id', 'room_id', 'content', 'media_urls',
        'visibility', 'type',
    ];

    protected $casts = [
        'media_urls' => 'array',
        'visibility' => Visibility::class,
    ];

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function comments() {
        return $this->hasMany(PostComment::class);
    }

    public function reactions() {
        return $this->hasMany(PostReaction::class);
    }
}

