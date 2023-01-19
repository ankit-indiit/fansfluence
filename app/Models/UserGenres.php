<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGenres extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'genres_id',
    ];
}
