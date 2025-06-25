<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;
/**
 * @OA\Schema(
 *     schema="CarsColor",
 *     type="object",
 *     title="CarsColor",
 *     required={"slug"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="CarsColor ID"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="Slug identifier"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Color name",
 *         example="Red"
 *     ),
 *     @OA\Property(
 *         property="color_code",
 *         type="string",
 *         description="Color hex code",
 *         example="#FF0000"
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

class CarsColor extends Model
{
use HasTranslations;
    protected $fillable = [
        'slug',
        'name',
        'color_code',

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
        return url('/admin/cars-colors/'.$this->getKey());
    }
}
