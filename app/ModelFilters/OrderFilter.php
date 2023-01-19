<?php
namespace App\ModelFilters;
use EloquentFilter\ModelFilter;
use App\Models\User;

class OrderFilter extends ModelFilter
{
    public $relations = [];

    public function sortOrder($sortOrder)
    {
        if ($sortOrder == 'newOld') {
            return $this->orderBy('id', 'DESC');
        }

        if ($sortOrder == 'oldNew') {
            return $this->orderBy('id', 'ASC');
        }
    }

    public function search($search)
    {
        @$userId = User::where('name', 'like', '%' . $search  . '%')
            ->pluck('id');
        return $this->whereIn('user_id', $userId);        
    }

    public function status($status)
    {
        return $this->where('status', $status);
    }

    public function startDate($date)
    {
        $startDate = \Carbon\Carbon::parse($date);
        return $this->whereDate('created_at', '>=', $startDate->format('Y-m-d'));
    }

    public function endDate($date)
    {
        $endDate = \Carbon\Carbon::parse($date);
        return $this->whereDate('created_at', '<=', $endDate->format('Y-m-d'));
    }
}