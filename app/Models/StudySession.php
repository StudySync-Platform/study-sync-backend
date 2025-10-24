<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Visibility;

class StudySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'host_user_id', 'subject',
        'start_time', 'end_time', 'status',
        'visibility', 'room_link', 'recording_url'
    ];

    protected $casts = [
        'visibility' => Visibility::class,
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function host() {
        return $this->belongsTo(User::class, 'host_user_id');
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'study_session_user');
    }

    public function memberCount(): int
    {
        return $this->members()->count();
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
