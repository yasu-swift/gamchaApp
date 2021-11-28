<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'likeGame',
        'profile',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function joinUsers()
    {
        return $this->hasMany(RoomUser::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function getImagePathAttribute()
    {
        return 'images/users/' . $this->avatar;
    }
    
    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }
}
