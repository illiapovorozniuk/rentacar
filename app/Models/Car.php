<?php

namespace App\Models;

use App\Enums\CarConfig;
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
/**
 * @OA\Schema(
 *     schema="Car",
 *     type="object",
 *     title="Car",
 *     required={"car_model_id", "car_brand_id", "car_slug"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Car ID"
 *     ),
 *     @OA\Property(
 *         property="car_model_id",
 *         type="integer",
 *         description="Foreign key to Car Model"
 *     ),
 *     @OA\Property(
 *         property="car_brand_id",
 *         type="integer",
 *         description="Foreign key to Brand"
 *     ),
 *     @OA\Property(
 *         property="car_body_type_id",
 *         type="integer",
 *         description="Foreign key to Body Type"
 *     ),
 *     @OA\Property(
 *         property="car_slug",
 *         type="string",
 *         description="Slug for the car"
 *     ),
 *     @OA\Property(
 *         property="availability_label",
 *         type="string",
 *         nullable=true,
 *         description="Availability label of the car"
 *     ),
 *     @OA\Property(
 *         property="price_1",
 *         type="integer",
 *         description="Price for 1 day"
 *     ),
 *     @OA\Property(
 *         property="price_7",
 *         type="integer",
 *         description="Price for 7 days"
 *     ),
 *     @OA\Property(
 *         property="price_30",
 *         type="integer",
 *         description="Price for 30 days"
 *     ),
 *     @OA\Property(
 *         property="price_31_more",
 *         type="integer",
 *         description="Price for 31 or more days"
 *     ),
 *     @OA\Property(
 *         property="deposit",
 *         type="integer",
 *         nullable=true,
 *         description="Deposit amount"
 *     ),
 *     @OA\Property(
 *         property="km_included_per_day",
 *         type="integer",
 *         nullable=true,
 *         description="Kilometers included per day"
 *     ),
 *     @OA\Property(
 *         property="overlimit_charge_per_km",
 *         type="number",
 *         format="float",
 *         nullable=true,
 *         description="Charge per km over the limit"
 *     ),
 *     @OA\Property(
 *         property="min_day_reservation",
 *         type="integer",
 *         nullable=true,
 *         description="Minimum days for reservation"
 *     ),
 *     @OA\Property(
 *         property="free_delivery",
 *         type="boolean",
 *         nullable=true,
 *         description="Is free delivery available"
 *     ),
 *     @OA\Property(
 *         property="registration_number",
 *         type="string",
 *         nullable=true,
 *         description="Car registration number"
 *     ),
 *     @OA\Property(
 *         property="color_id",
 *         type="integer",
 *         nullable=true,
 *         description="Foreign key to color"
 *     ),
 *     @OA\Property(
 *         property="fuel_id",
 *         type="integer",
 *         nullable=true,
 *         description="Foreign key to fuel"
 *     ),
 *     @OA\Property(
 *         property="attribute_year",
 *         type="integer",
 *         nullable=true,
 *         description="Year attribute"
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
 *         property="attribute_max_speed",
 *         type="integer",
 *         nullable=true,
 *         description="Maximum speed"
 *     ),
 *     @OA\Property(
 *         property="attribute_horsepower",
 *         type="integer",
 *         nullable=true,
 *         description="Horsepower"
 *     ),
 *     @OA\Property(
 *         property="attribute_transmission",
 *         type="string",
 *         nullable=true,
 *         description="Transmission type"
 *     ),
 *     @OA\Property(
 *         property="attribute_doors",
 *         type="integer",
 *         nullable=true,
 *         description="Number of doors"
 *     ),
 *     @OA\Property(
 *         property="attribute_engine",
 *         type="string",
 *         nullable=true,
 *         description="Engine description"
 *     ),
 *     @OA\Property(
 *         property="attribute_baggage",
 *         type="integer",
 *         nullable=true,
 *         description="Baggage capacity"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         nullable=true,
 *         description="Status of the car"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Created timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Updated timestamp"
 *     ),
 *     @OA\Property(
 *         property="resource_url",
 *         type="string",
 *         description="Resource URL for the car"
 *     )
 * )
 */

class Car extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use HasTranslations;


    protected $fillable = [
        'car_model_id',
        'car_brand_id',
        'car_body_type_id',
        'car_body_type_id',
        'car_slug',
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

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function carsColor()
    {
        return $this->belongsTo(CarsColor::class);
    }

    public function fuel()
    {
        return $this->belongsTo(Fuel::class);
    }

    public function carInfo()
    {

        $media_photos = $this->getMedia('cars');
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
        $car['price_1'] = (int)$car['price_1'];
        $car['price_7'] = (int)($car['price_7'] ? $car['price_7'] : $car['price_1'] * CarConfig::PRICE7_MULTIPLIER->toFloat());
        $car['price_30'] = (int)($car['price_30'] ? $car['price_30'] : $car['price_1'] * CarConfig::PRICE30_MULTIPLIER->toFloat());
        $car['price_31_more'] = (int)($car['price_31_more'] ? $car['price_31_more'] : $car['price_1'] * CarConfig::PRICE31MORE_MULTIPLIER->toFloat());
        $car['fuel_name'] = json_decode($car['fuel_name'])->en;
        return $car;
    }

    public static function carsInfo(array $cars)
    {
        if (isset($cars['data'])) {
            $carIds = array_column($cars['data'], 'id');
        } else {
            $carIds = array_column($cars, 'id');
        }

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

        $currentLocale = app()->getLocale();
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
            $car['color_name'] = json_decode($car['color_name'])->$currentLocale;
        }
        return $carsData;
    }

    public static function getCarsByBrandId(int $brandId){
       return self::query()->where('car_brand_id', $brandId)->get();
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/cars/' . $this->getKey());
    }

    /* ************************ Media ************************* */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cars')
            ->maxNumberOfFiles(10)
            ->maxFilesize(15 * 1024 * 1024);
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();
        $this->addMediaConversion('minifiedWebp')
            ->performOnCollections('cars')
            ->format(Manipulations::FORMAT_WEBP)
            ->optimize()
            ->quality(70);
    }
}
