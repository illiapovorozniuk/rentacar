<?php

namespace App\Models;

use App\Traits\SiteBlogTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Translatable\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Car extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use HasTranslations;

    public function registerMediaCollections(): void {
        $this->addMediaCollection('cars')
            ->maxNumberOfFiles(10)
            ->maxFilesize(15*1024*1024);
    }

    public function registerMediaConversions(Media $media = null): void {
        $this->autoRegisterThumb200();
        $this->addMediaConversion('minifiedWebp')
            ->performOnCollections('cars')
            ->format(Manipulations::FORMAT_WEBP)
            ->optimize()
            ->quality(70);
    }
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
    public function fuel() {
        return $this->belongsTo(Fuel::class);
    }
    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/cars/'.$this->getKey());
    }
}
