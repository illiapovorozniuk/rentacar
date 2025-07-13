<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'car_id',
        'date_from',
        'date_to',
        'address_from',
        'address_to',
        'status',
        'total_price',
        'currency_id',
        'liqpay_payment_id',
        'payment_status'
    ];


    protected $dates = [

    ];
    public $timestamps = true;

    protected $appends = ['resource_url'];

    /* ************************ RELATIONS ************************* */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/orders/'.$this->getKey());
    }
}
