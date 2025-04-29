<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,
        
    ];
});/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Brand::class, static function (Faker\Generator $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'name' => $faker->firstName,
        'icon' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\BodyType::class, static function (Faker\Generator $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'icon' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        'name' => ['en' => $faker->firstName],
        
    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Type::class, static function (Faker\Generator $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        'name' => ['en' => $faker->firstName],
        
    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Fuel::class, static function (Faker\Generator $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        'name' => ['en' => $faker->firstName],
        
    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\CarModel::class, static function (Faker\Generator $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'brand_id' => $faker->randomNumber(5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        'name' => ['en' => $faker->firstName],
        
    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\CarsColor::class, static function (Faker\Generator $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'color_code' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        'name' => ['en' => $faker->firstName],
        
    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Car::class, static function (Faker\Generator $faker) {
    return [
        'car_model_id' => $faker->randomNumber(5),
        'availability_label' => $faker->sentence,
        'price_1' => $faker->randomFloat,
        'price_7' => $faker->randomFloat,
        'price_30' => $faker->randomFloat,
        'price_31_more' => $faker->randomFloat,
        'deposit' => $faker->randomNumber(5),
        'km_included_per_day' => $faker->randomNumber(5),
        'overlimit_charge_per_km' => $faker->randomFloat,
        'min_day_reservation' => $faker->randomNumber(5),
        'free_delivery' => $faker->randomNumber(5),
        'registration_number' => $faker->sentence,
        'color_id' => $faker->sentence,
        'fuel_id' => $faker->randomNumber(5),
        'attribute_year' => $faker->randomNumber(5),
        'attribute_seats' => $faker->randomNumber(5),
        'attribute_1_to_100' => $faker->randomFloat,
        'attribute_max_speed' => $faker->randomNumber(5),
        'attribute_horsepower' => $faker->randomNumber(5),
        'attribute_transmission' => $faker->sentence,
        'attribute_doors' => $faker->randomNumber(5),
        'attribute_engine' => $faker->sentence,
        'attribute_baggage' => $faker->randomNumber(5),
        'status' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Currency::class, static function (Faker\Generator $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'sign' => $faker->sentence,
        'exchange_rate' => $faker->randomFloat,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
