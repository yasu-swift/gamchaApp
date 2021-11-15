<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function joinUsers()
    {
        return $this->hasMany(\App\Models\JoinUser::class);
    }
}
