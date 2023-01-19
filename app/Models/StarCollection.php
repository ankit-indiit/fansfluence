<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StarCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'slug',
    ];

    protected $appends = ['stars', 'user_id'];

    public function getImageAttribute()
    {
        if (isset($this->attributes['image'])) {
            return asset('collection/'.$this->attributes['image'].'');
        } else {
            return asset("https://ui-avatars.com/api/?name=".$this->attributes['name']);
        }
    }

    public function getStarsAttribute()
    {
        return StaredInfluencer::where('collection_id', $this->attributes['id'])
            ->get();
    }

    public function getUserIdAttribute()
    {
        return StaredInfluencer::where('collection_id', $this->attributes['id'])
            ->pluck('influencer_id')->first();
    }
}
