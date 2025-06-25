<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

/**
 * @OA\Schema(
 *     schema="CarModel",
 *     type="object",
 *     title="CarModel",
 *     required={"slug", "brand_id", "body_type_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="CarModel ID"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="Slug identifier"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the car model",
 *         example="Model S"
 *     ),
 *     @OA\Property(
 *         property="brand_id",
 *         type="integer",
 *         description="Foreign key to Brand"
 *     ),
 *     @OA\Property(
 *         property="body_type_id",
 *         type="integer",
 *         description="Foreign key to BodyType"
 *     ),
 *     @OA\Property(
 *         property="attribute_seats",
 *         type="integer",
 *         nullable=true,
 *         description="Number of seats"
 *     ),
 *     @OA\Property(
 *         property="attribute_1_to_100",
 *         type="number",
 *         format="float",
 *         nullable=true,
 *         description="Acceleration 0-100 km/h"
 *     ),
 *     @OA\Property(
 *         property="attribute_horsepower",
 *         type="integer",
 *         nullable=true,
 *         description="Horsepower"
 *     ),
 *     @OA\Property(
 *         property="attribute_max_speed",
 *         type="integer",
 *         nullable=true,
 *         description="Maximum speed"
 *     ),
 *     @OA\Property(
 *         property="attribute_transmission",
 *         type="string",
 *         nullable=true,
 *         description="Transmission type"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Update timestamp"
 *     ),
 *     @OA\Property(
 *         property="resource_url",
 *         type="string",
 *         description="URL to the resource"
 *     )
 * )
 */

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
    public function car()
    {
        return $this->hasMany(Car::class);
    }
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
