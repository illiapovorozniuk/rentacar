<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
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