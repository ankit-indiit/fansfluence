<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    protected $appends = ['category'];

    public function getCategoryAttribute()
    {
    	switch ($this->attributes['name']) {
    		case 'Youtubers':
    			return 'youtube';
    		break;
    		case 'Twitchers':
    			return 'twitch';
    		break;
    		case 'Tiktokers':
    			return 'tiktok';
    		break;
    		case 'Business':
    			return 'business';
    		break;    		
    		default:
    			return '';
    		break;
    	}
    }
}
