<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'influencer_id',
        'user_id',
        'order_id',
        'rating',
        'review',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'influencer_id', 'id');
    // }
}
