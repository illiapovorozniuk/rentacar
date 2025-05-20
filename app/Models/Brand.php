<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\HasMedia;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;


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
