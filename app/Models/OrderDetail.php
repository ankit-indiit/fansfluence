<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
    	'order_id',
    	'user_id',
    	'influencer_id',
    	'detail',
        'visibility',
    ];

    protected $appends = ['delivery_date'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getDetailAttribute()
    {
        $detail = unserialize($this->attributes['detail']);
        unset($detail['_token']);
        unset($detail['visibility']);
        return $detail;
    }

    public function getDeliveryDateAttribute()
    {
        $deliverySpeedId = InfluencerProfileDetail::where('influencer_id', $this->attributes['influencer_id'])
            ->pluck('delivery_speed')
            ->first();
        $estimate = DeliverySpeed::where('id', $deliverySpeedId)
            ->pluck('estimate')
            ->first();
        switch ($estimate) {
            case '24 Hours':
                $day = 1;
            break;
            case '5 Days':
                $day = 5;
            break;
            case '3 Days':
                $day = 3;
            break;
            case 'Anytime':
                $day = 0;
            break;            
            default:
                $day = 0;
            break;
        }
        return date('M d, Y', strtotime($this->attributes['created_at'] . " +$day day"));
    }
}
