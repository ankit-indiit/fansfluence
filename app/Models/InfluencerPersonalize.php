<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerPersonalize extends Model
{
    use HasFactory;

    protected $fillable = [
    	'influencer_id',
    	'photo_with_watermark',
    	'photo_with_out_watermark',
    	'video_with_watermark',
    	'video_with_out_watermark',
    	'facebook_price',
        'instagram_price',
    	'twitter_price',
        'photo_type',
        'video_type',
        'min_price',
    ];

    protected $appends = ['check_cat', 'photo_price', 'video_price', 'social_price'];

    public function getCheckCatAttribute()
    {
        $price = [];
        if ($this->attributes['photo_with_watermark'] != '') {
            $price[] = $this->attributes['photo_with_watermark'];
        }
        if ($this->attributes['photo_with_out_watermark'] != '') {
            $price[] = $this->attributes['photo_with_out_watermark'];
        }
        if ($this->attributes['video_with_watermark'] != '') {
            $price[] = $this->attributes['video_with_watermark'];
        }
        if ($this->attributes['video_with_out_watermark'] != '') {
            $price[] = $this->attributes['video_with_out_watermark'];
        }
        if ($this->attributes['facebook_price'] != '') {
            $price[] = $this->attributes['facebook_price'];
        }
        if ($this->attributes['instagram_price'] != '') {
            $price[] = $this->attributes['instagram_price'];
        }
        if ($this->attributes['twitter_price'] != '') {
            $price[] = $this->attributes['twitter_price'];
        }
        return $price;
    }

    public function getPhotoPriceAttribute()
    {
        $price = [];
        if (isset($this->attributes['photo_with_watermark'])) {
            $price[] = $this->attributes['photo_with_watermark'];
        }
        if (isset($this->attributes['photo_with_out_watermark'])) {
            $price[] = $this->attributes['photo_with_out_watermark'];
        }
        if (count($price) > 0) {
            return min($price);
        }       
    }

    public function getVideoPriceAttribute()
    {
        $price = [];
        if (isset($this->attributes['video_with_watermark'])) {
            $price[] = $this->attributes['video_with_watermark'];
        }
        if (isset($this->attributes['video_with_out_watermark'])) {
            $price[] = $this->attributes['video_with_out_watermark'];
        }
        if (count($price) > 0) {
            return min($price);
        }      
    }

    public function getSocialPriceAttribute()
    {
        $price = [];
        if (isset($this->attributes['facebook_price'])) {
            $price[] = $this->attributes['facebook_price'];
        }
        if (isset($this->attributes['instagram_price'])) {
            $price[] = $this->attributes['instagram_price'];
        }
        if (isset($this->attributes['twitter_price'])) {
            $price[] = $this->attributes['twitter_price'];
        }
        if (count($price) > 0) {
            return min($price);
        }
    }
}

