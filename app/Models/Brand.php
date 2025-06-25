<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\HasMedia;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;

/**
 * @OA\Schema(
 *     schema="Brand",
 *     type="object",
 *     title="Brand",
 *     required={"slug", "name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Brand ID"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="Unique slug of the brand"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the brand"
 *     ),
 *     @OA\Property(
 *         property="icon",
 *         type="string",
 *         description="Icon of the brand"
 *     ),
 *     @OA\Property(
 *         property="cars_count",
 *         type="integer",
 *         description="Number of cars for the brand"
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
 *         description="Resource URL"
 *     )
 * )
 */

class Brand extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;

    protected $fillable = [
        'slug',
        'name',
        'icon',
        'cars_count',
    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    public function cars()
    {
        return $this->hasMany(Car::class, 'car_brand_id');
    }
    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/brands/' . $this->getKey());
    }
    public function carModel()
    {
        return $this->hasMany(CarModel::class);
    }

    public static function getBrandBySlug($slug)
    {
        return Brand::query()->where('slug', $slug)->first();
    }
    /* ************************ MEDIA ************************* */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->accepts('image/*')
            ->maxNumberOfFiles(1);
    }

    public function registerMediaConversions(Media|\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->autoRegisterThumb200();
    }
}
