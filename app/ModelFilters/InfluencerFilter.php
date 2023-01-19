<?php
namespace App\ModelFilters;
use EloquentFilter\ModelFilter;
use App\Models\User;
use App\Models\InfluencerPersonalize;
use App\Models\InfluencerProfileDetail;
use App\Models\Review;

class InfluencerFilter extends ModelFilter
{
    public $relations = [];

    public function price($price)
    {
        $influencer = new InfluencerPersonalize();
 
        switch ($price) {
            case '25':            
                return $this->whereBetween('min_price', [0, 25]);   
            break;
            case '100':
                return $this->whereBetween('min_price', [25, 100]); 
            break;
            case '300':
                return $this->whereBetween('min_price', [100, 300]); 
            break;
            case '300+':
                return $this->where('min_price', '>', 300);               
            break;                    
        }       
    }   

    public function minPrice($minPrice)
    {       
        return $this->where('min_price', '>=', $minPrice); 
    }

    public function maxPrice($maxPrice)
    {        
        return $this->where('min_price', '<=', $maxPrice); 
    }

    public function speed($speed)
    {
        $influencerIds = InfluencerProfileDetail::where('delivery_speed', $speed)            
            ->pluck('influencer_id');        
        return $this->whereIn('id', $influencerIds); 
    }

    public function recommended($recommended)
    {
        switch ($recommended) {
            case 'asc-name':
                return $this->orderBy('name', 'ASC');       
            break;
            case 'desc-name':
                return $this->orderBy('name', 'DESC');       
            break;
            case 'asc-price':               
                return $this->orderBy('min_price', 'ASC');
            break;
            case 'desc-price':              
                return $this->orderBy('min_price', 'DESC');      
            break;            
        }         
    }   

    public function ratings($ratings)
    {
        if (in_array(4, $ratings)) {
            array_push($ratings, 5);
        }
        $ids = Review::whereIn('rating', $ratings)->pluck('influencer_id')->toArray(); 
        
        if (in_array(0, $ratings)) {
            $influencerIds = Review::pluck('influencer_id')->toArray();        
            $userIds = User::whereNotIn('id', $influencerIds)
                ->pluck('id')
                ->toArray();
            $ids = array_merge($ids, $userIds);
        }

        return $this->whereIn('id', array_unique($ids)); 
    }    
}