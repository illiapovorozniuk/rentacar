<?php

use Illuminate\Support\Facades\Route;
use App\Enums\Route as RouteEnum;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::namespace('App\Http\Controllers\Front')->group(function () {
    Route::get('/', 'SiteController@index')->name('home');
    Route::get('/'.RouteEnum::BRANDS->value, 'SiteController@brands')->name('brands');
    Route::get('/'.RouteEnum::BODIES->value, 'SiteController@bodyTypes')->name('body-types');
    Route::get('/'.RouteEnum::BRANDS->value.'/{slug}', 'SiteController@brand')->name('brand');
    Route::get('/'.RouteEnum::CAR->value.'/{id}', 'SiteController@car')->name('car');
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('brands')->name('brands/')->group(static function() {
            Route::get('/',                                             'BrandsController@index')->name('index');
            Route::get('/create',                                       'BrandsController@create')->name('create');
            Route::post('/',                                            'BrandsController@store')->name('store');
            Route::get('/{brand}/edit',                                 'BrandsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BrandsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{brand}',                                     'BrandsController@update')->name('update');
            Route::delete('/{brand}',                                   'BrandsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('body-types')->name('body-types/')->group(static function() {
            Route::get('/',                                             'BodyTypesController@index')->name('index');
            Route::get('/create',                                       'BodyTypesController@create')->name('create');
            Route::post('/',                                            'BodyTypesController@store')->name('store');
            Route::get('/{bodyType}/edit',                              'BodyTypesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BodyTypesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{bodyType}',                                  'BodyTypesController@update')->name('update');
            Route::delete('/{bodyType}',                                'BodyTypesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('types')->name('types/')->group(static function() {
            Route::get('/',                                             'TypesController@index')->name('index');
            Route::get('/create',                                       'TypesController@create')->name('create');
            Route::post('/',                                            'TypesController@store')->name('store');
            Route::get('/{type}/edit',                                  'TypesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TypesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{type}',                                      'TypesController@update')->name('update');
            Route::delete('/{type}',                                    'TypesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('fuels')->name('fuels/')->group(static function() {
            Route::get('/',                                             'FuelsController@index')->name('index');
            Route::get('/create',                                       'FuelsController@create')->name('create');
            Route::post('/',                                            'FuelsController@store')->name('store');
            Route::get('/{fuel}/edit',                                  'FuelsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'FuelsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{fuel}',                                      'FuelsController@update')->name('update');
            Route::delete('/{fuel}',                                    'FuelsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('car-models')->name('car-models/')->group(static function() {
            Route::get('/',                                             'CarModelsController@index')->name('index');
            Route::get('/create',                                       'CarModelsController@create')->name('create');
            Route::post('/',                                            'CarModelsController@store')->name('store');
            Route::get('/{carModel}/edit',                              'CarModelsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CarModelsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{carModel}',                                  'CarModelsController@update')->name('update');
            Route::delete('/{carModel}',                                'CarModelsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('cars-colors')->name('cars-colors/')->group(static function() {
            Route::get('/',                                             'CarsColorsController@index')->name('index');
            Route::get('/create',                                       'CarsColorsController@create')->name('create');
            Route::post('/',                                            'CarsColorsController@store')->name('store');
            Route::get('/{carsColor}/edit',                             'CarsColorsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CarsColorsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{carsColor}',                                 'CarsColorsController@update')->name('update');
            Route::delete('/{carsColor}',                               'CarsColorsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('cars')->name('cars/')->group(static function() {
            Route::get('/',                                             'CarsController@index')->name('index');
            Route::get('/create',                                       'CarsController@create')->name('create');
            Route::post('/',                                            'CarsController@store')->name('store');
            Route::get('/{car}/edit',                                   'CarsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CarsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{car}',                                       'CarsController@update')->name('update');
            Route::delete('/{car}',                                     'CarsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('currencies')->name('currencies/')->group(static function() {
            Route::get('/',                                             'CurrenciesController@index')->name('index');
            Route::get('/create',                                       'CurrenciesController@create')->name('create');
            Route::post('/',                                            'CurrenciesController@store')->name('store');
            Route::get('/{currency}/edit',                              'CurrenciesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CurrenciesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{currency}',                                  'CurrenciesController@update')->name('update');
            Route::delete('/{currency}',                                'CurrenciesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('pages')->name('pages/')->group(static function() {
            Route::get('/',                                             'PagesController@index')->name('index');
            Route::get('/create',                                       'PagesController@create')->name('create');
            Route::post('/',                                            'PagesController@store')->name('store');
            Route::get('/{page}/edit',                                  'PagesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PagesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{page}',                                      'PagesController@update')->name('update');
            Route::delete('/{page}',                                    'PagesController@destroy')->name('destroy');
        });
    });
});
