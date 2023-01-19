<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
    	'name',
    	'email',
    	'reaching_out_us',
    	'question_description',
        'twitter',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'twitch',
    ];

    public function getCreatedAtAttribute()
    {
        return date('d M Y', strtotime($this->attributes['created_at']));
    }
}
