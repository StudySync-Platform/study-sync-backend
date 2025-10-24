<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'commenter_id', 'content'];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function commenter() {
        return $this->belongsTo(User::class, 'commenter_id');
    }
}
