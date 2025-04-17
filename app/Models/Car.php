<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'car_model_id',
        'availability_label',
        'price_1',
        'price_7',
        'price_30',
        'price_31_more',
        'deposit',
        'km_included_per_day',
        'overlimit_charge_per_km',
        'min_day_reservation',
        'free_delivery',
        'registration_number',
        'color_id',
        'fuel_id',
        'attribute_year',
        'attribute_seats',
        'attribute_1_to_100',
        'attribute_max_speed',
        'attribute_horsepower',
        'attribute_transmission',
        'attribute_doors',
        'attribute_engine',
        'attribute_baggage',
        'status',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    public function carModel() {
        return $this->belongsTo(CarModel::class);
    }
    public function carsColor() {
        return $this->belongsTo(CarsColor::class);
    }
    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/cars/'.$this->getKey());
    }
}
