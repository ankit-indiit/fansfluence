<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaredInfluencer extends Model
{
    use HasFactory;

    protected $fillable = [
    	'collection_id',
    	'influencer_id',
    ];

    protected $appends = [
        'user',
    ];

    public function getUserAttribute()
    {
        return User::where('id', $this->attributes['influencer_id'])->first();
    }
}
