<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'name'
    ];

    protected $guarded = [
        'create_at', 'update_at'
    ];

    public function users()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function rooms()
    {
        return $this->belongsTo(\App\Models\Room::class);
    }
}
