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
        'liqpay_payment_id',
        'payment_status'
    ];


    protected $dates = [

    ];
    public $timestamps = true;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/orders/'.$this->getKey());
    }
}
