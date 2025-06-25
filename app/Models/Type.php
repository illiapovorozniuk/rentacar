<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;
/**
 * @OA\Schema(
 *     schema="Type",
 *     type="object",
 *     title="Type",
 *     required={"slug", "name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Type ID"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="Unique slug identifier"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Display name of the type (translatable)"
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
 *         description="Last update timestamp"
 *     ),
 *     @OA\Property(
 *         property="resource_url",
 *         type="string",
 *         description="URL to the admin interface for this type"
 *     )
 * )
 */

class Type extends Model
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

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/types/'.$this->getKey());
    }

    public function carModel(){
        return $this->belongsToMany(CarModel::class);
    }
}
