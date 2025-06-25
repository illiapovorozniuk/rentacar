<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

/**
 * @OA\Schema(
 *     schema="Fuel",
 *     type="object",
 *     title="Fuel",
 *     required={"slug", "name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Fuel ID"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="Unique slug identifier for the fuel type"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Fuel name (translatable)"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Record creation timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Record update timestamp"
 *     ),
 *     @OA\Property(
 *         property="resource_url",
 *         type="string",
 *         description="URL to the fuel resource"
 *     )
 * )
 */

class Fuel extends Model
{
use HasTranslations;
    protected $fillable = [
        'slug',
        'name',

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
        return $this->hasMany(Car::class);
    }
    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/fuels/'.$this->getKey());
    }
}
