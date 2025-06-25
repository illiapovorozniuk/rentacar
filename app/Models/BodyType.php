<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

/**
 * @OA\Schema(
 *     schema="BodyType",
 *     type="object",
 *     title="BodyType",
 *     required={"slug", "name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="Slug"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Localized name"
 *     ),
 *     @OA\Property(
 *         property="icon",
 *         type="string",
 *         description="Icon class or URL"
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
 *         description="Resource URL"
 *     )
 * )
 */

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
