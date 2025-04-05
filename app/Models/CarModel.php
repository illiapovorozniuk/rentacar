<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

class CarModel extends Model
{
use HasTranslations;
    protected $fillable = [
        'slug',
        'name',
        'brand_id',
        'body_type_id',
        'attribute_seats',
        'attribute_1_to_100',
        'attribute_horsepower',
        'attribute_max_speed',
        'attribute_transmission',

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

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/car-models/'.$this->getKey());
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }
    public function bodyType() {
        return $this->belongsTo(BodyType::class);
    }
    public function types()
    {
        return $this->belongsToMany(Type::class);
    }
}
