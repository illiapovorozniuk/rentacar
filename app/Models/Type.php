<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

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
