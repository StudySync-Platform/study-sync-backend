<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'study_sessions';
    protected $fillable = ['emoji', 'subject', 'time', 'status'];

    protected $casts = [
        'time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('time', '>', now());
    }
}
