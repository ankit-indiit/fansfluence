<?php
namespace App\ModelFilters;
use EloquentFilter\ModelFilter;
use App\Models\User;

class OrderFilter extends ModelFilter
{
    public $relations = [];  

    public function search($search)
    {
        $userId = User::where('name', 'like', '%' . $search  . '%')
            ->pluck('id');
        return $this->whereIn('user_id', $userId);        
    }    
}