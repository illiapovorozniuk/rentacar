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

    public function carInfo()
    {

        $media_photos = $this->getMedia('cars');
        $main_photo = null;
        $photos = [];
        if(isset($media_photos[0])) {
            $path_parts = pathinfo($media_photos[0]->getUrl('minifiedWebp'));
            $main_photo = $path_parts['dirname'] . '/' . $path_parts['basename'];
            foreach ($media_photos as $photo) {
                $path_parts = pathinfo($media_photos[0]->getUrl('minifiedWebp'));
                $photos[] = $path_parts['dirname'] . '/' . $path_parts['basename'];
            }
        }
        $car = self::query()
            ->join('car_models', 'cars.car_model_id', '=', 'car_models.id')
            ->join('brands', 'car_models.brand_id', '=', 'brands.id')
            ->join('cars_colors', 'cars.color_id', '=', 'cars_colors.id')
            ->join('fuels', 'cars.fuel_id', '=', 'fuels.id')
            ->select(
                'cars.*',
                'car_models.name as car_model_name',
                'brands.slug as brand_slug',
                'cars_colors.slug as color_slug',
                'cars_colors.name as color_name',
                'cars_colors.color_code as color',
                'fuels.name as fuel_name'
            )
            ->where('cars.id', $this->id)
            ->first();
        $car['main_photo'] = $main_photo;
        $car['photos'] = $photos;
        return $car;
    }
    public static function carsInfo(array $cars)
    {
        $carIds = array_column($cars['data'], 'id');

        $carsData = self::query()
            ->join('car_models', 'cars.car_model_id', '=', 'car_models.id')
            ->join('brands', 'car_models.brand_id', '=', 'brands.id')
            ->join('cars_colors', 'cars.color_id', '=', 'cars_colors.id')
            ->join('fuels', 'cars.fuel_id', '=', 'fuels.id')
            ->select(
                'cars.*',
                'car_models.name as car_model_name',
                'car_models.slug as car_model_slug',
                'brands.slug as brand_slug',
                'cars_colors.slug as color_slug',
                'cars_colors.name as color_name',
                'cars_colors.color_code as color',
                'fuels.name as fuel_name'
            )
            ->whereIn('cars.id', $carIds)
            ->get();

        foreach ($carsData as $car) {
            $media_photos = $car->getMedia('cars');
            $main_photo = null;
            $photos = [];
            if (isset($media_photos[0])) {
                $path_parts = pathinfo($media_photos[0]->getUrl('minifiedWebp'));
                $main_photo = $path_parts['dirname'] . '/' . $path_parts['basename'];
                foreach ($media_photos as $photo) {
                    $path_parts = pathinfo($photo->getUrl('minifiedWebp'));
                    $photos[] = $path_parts['dirname'] . '/' . $path_parts['basename'];
                }
            }
            $car['main_photo'] = $main_photo;
            $car['photos'] = $photos;
        }
        return $carsData;
    }
    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/cars/'.$this->getKey());
    }
    /* ************************ Media ************************* */
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
}
