<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body'
        // 'name'
    ];

    protected $guarded = [
        'create_at', 'update_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
