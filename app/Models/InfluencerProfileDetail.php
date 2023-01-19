<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerProfileDetail extends Model
{
    use HasFactory;

    protected $fillable = [
    	'influencer_id',
    	'intro_video',
    	'intro_photo',
    	'about',
    	'photo_question',
        'video_question',
    	'post_question',
    	'twitter',
    	'facebook',
    	'instagram',
    	'youtube',
    	'tiktok',
    	'twitch',
        'delivery_speed',
    ];

    protected $appends = ['exist_video_name'];

    public function getPhotoQuestionAttribute()
    {
        return unserialize($this->attributes['photo_question']);
    }

    public function getVideoQuestionAttribute()
    {
        return unserialize($this->attributes['video_question']);
    }

    public function getPostQuestionAttribute()
    {
        return unserialize($this->attributes['post_question']);
    }

    public function getIntroVideoAttribute()
    {
        if ($this->attributes['intro_video']) {
            return asset("/influencer/".$this->attributes['intro_video']."");
        }
    }

    public function getExistVideoNameAttribute()
    {
        return $this->attributes['intro_video'];        
    }  
}
