<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
    	'user_id',
        'order_id',
    	'customer_id',
    	'payment_type',
    	'product',
    	'mark',
    	'product_price',
        'status',
        'decline_reasone',
    ];

    protected $appends = ['user', 'product_name', 'time'];


    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function deliverProduct()
    {
        return $this->hasMany(DeliverProduct::class);
    }

    public function modelFilter()
    {
        return $this->provideFilter(\App\ModelFilters\OrderFilter::class);
    }

    public function getUserAttribute()
    {
    	return User::where('id', $this->attributes['user_id'])
    		->first();
    }

    public function getProductNameAttribute()
    {
        if ($this->attributes['mark'] != '') {
            return "Personalized ".$this->attributes['product']." (".$this->attributes['mark'].")";
        } else {
            return $this->attributes['product']." Social Media Post";
        }
    }

    public function getCreatedAtAttribute()
    {
    	return date('M d, Y', strtotime($this->attributes['created_at']));
    }

    public function getTimeAttribute()
    {
        return date('H:i a', strtotime($this->attributes['created_at']));
    }    
}
