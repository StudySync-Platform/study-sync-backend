<?php

namespace App\Models;

use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'subject',
        'level',
        'host_user_id',
        'max_members',
        'visibility',
        'thumbnail_url',
        'status',
    ];

    protected $casts = [
        'visibility' => Visibility::class,
    ];

    // 🧑 Hosted by user
    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_user_id');
    }

    // 📚 Study sessions in this room
    public function studySessions(): HasMany
    {
        return $this->hasMany(StudySession::class);
    }

    // 📰 Posts inside this room
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
