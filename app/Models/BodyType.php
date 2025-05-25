<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

class BodyType extends Model
{
use HasTranslations;
    protected $fillable = [
        'slug',
        'name',
        'icon',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];
    // these attributes are translatable
    public $translatable = [
        'name',

    ];

    protected $appends = ['resource_url'];

    public function cars()
    {
        return $this->hasMany(Car::class, 'car_body_type_id');
    }
    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/body-types/'.$this->getKey());
    }

    public function carModel()
    {
        return $this->hasMany(CarModel::class);
    }
}
