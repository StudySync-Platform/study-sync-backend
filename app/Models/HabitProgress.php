<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitProgress extends Model
{
    use HasFactory;

    protected $table = 'habit_progresses';

    protected $fillable = [
        'habit_id', 'user_id', 'progress_date', 'value', 'note'
    ];

    protected $casts = [
        'progress_date' => 'date',
        'value' => 'integer',
    ];

    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
