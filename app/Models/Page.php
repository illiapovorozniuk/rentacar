<?php

namespace App\Models;

use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use HasTranslations;
    use HasTranslations;

    protected $fillable = [
        'title',
        'link',
        'type',
        'h1',
        'description',
        'content',
        'enabled',
        'faq',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];
    // these attributes are translatable
    public $translatable = [
        'title',
        'h1',
        'description',
        'content',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/pages/'.$this->getKey());
    }

    /* ************************ Media ************************* */
    public function registerMediaCollections(): void {
        $this->addMediaCollection('cover');
    }


    public function registerMediaConversions(Media $media = null): void {
        $this->autoRegisterThumb200();
        $this->addMediaConversion('minifiedWebp')
            ->performOnCollections('cover')
            ->format(Manipulations::FORMAT_WEBP)
            ->optimize()
            ->quality(70);
    }
}
