<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product',
        'type',
    ];

    protected $appends = ['product_name', 'product_exe'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getProductAttribute()
    {
        return asset('/order/'.$this->attributes['product']);
    }

    public function getProductNameAttribute()
    {
        return $this->attributes['product'];
    }

    public function getProductExeAttribute()
    {
        return $extension = pathinfo(asset('/order/'.$this->attributes['product']), PATHINFO_EXTENSION);

    }
}
