<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerIntroPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
    	'influencer_id',
    	'name',
    ];

    protected $appends = ['image'];

    public function getNameAttribute()
    {
    	if ($this->attributes['name']) {
    		return asset('influencer/'.$this->attributes['name'].'');
    	}
    }

    public function getImageAttribute()
    {
        return $this->attributes['name'];
    }
}
