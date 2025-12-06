<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'description', 'target', 'unit', 'visibility'
    ];

    protected $casts = [
        'target' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function progresses()
    {
        return $this->hasMany(HabitProgress::class);
    }
}

