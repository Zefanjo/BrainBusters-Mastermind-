<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class game extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'turns',
        'won',
        'game_time',
    ];

    public static function create(array $array)
    {
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

