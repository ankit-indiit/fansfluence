<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'image',
        'question_description',
        'primary_platform',
        'anything_else',
        'token',
        'status',
        'business',
        'theme',
        'stripe_customer_id',
        'min_price',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'image_name',
        'stared',
        'profile_price',
        'rating',
        // 'alert',
        'reviews',
    ];

    public function modelFilter()
    {
        return $this->provideFilter(\App\ModelFilters\InfluencerFilter::class);
    }

    public function getCreatedAtAttribute()
    {
        return date('d M Y', strtotime($this->attributes['created_at']));
    }

    public function getReviewsAttribute()
    {
        return Review::where('influencer_id', $this->attributes['id'])
            ->paginate(5);        
    }

    public function getImageAttribute()
    {
        if ($this->attributes['image'] != '') {
            return asset("user/".$this->attributes['image']."");
        } else {
            return asset("https://ui-avatars.com/api/?name=".@$this->attributes['name']."");
        }
    }

    public function getImageNameAttribute()
    {
        return $this->attributes['image'];
    }

    public function getStaredAttribute()
    {
        $collectionIds = StarCollection::where('user_id', Auth::id())
            ->pluck('id');
        return StaredInfluencer::whereIn('collection_id', $collectionIds)
            ->where('influencer_id', $this->attributes['id'])
            ->pluck('collection_id')
            ->first();
    }

    public function getProfilePriceAttribute($influencerId)
    {
        return InfluencerPersonalize::where('influencer_id', $this->attributes['id'])
            ->pluck('min_price')
            ->first();
        // if (isset($price->check_cat) && count($price->check_cat) > 0) {
        //     return min($price->check_cat);
        // }
    }

    public function getRatingAttribute()
    {
        return Review::where('influencer_id', $this->attributes['id'])
            ->max('rating');
    }

    public function alert($name, $type)
    {
        if ($name != '' && $type != '') {
            return AccountNotification::where('user_id', $this->attributes['id'])
                ->where('name', $name)
                ->pluck($type)
                ->first();            
        }
    }
}
