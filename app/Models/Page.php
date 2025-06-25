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
/**
 * @OA\Schema(
 *     schema="Page",
 *     type="object",
 *     title="Page",
 *     required={"title", "link", "type", "h1", "description", "content", "enabled"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Page ID"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Page title"
 *     ),
 *     @OA\Property(
 *         property="link",
 *         type="string",
 *         description="Page URL slug"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Page type (e.g. static, dynamic)"
 *     ),
 *     @OA\Property(
 *         property="h1",
 *         type="string",
 *         description="Main heading of the page"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Meta description of the page"
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         description="HTML content of the page"
 *     ),
 *     @OA\Property(
 *         property="enabled",
 *         type="boolean",
 *         description="Page visibility status"
 *     ),
 *     @OA\Property(
 *         property="faq",
 *         type="string",
 *         description="Optional JSON-encoded FAQ content"
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
 *         description="URL to the admin resource page"
 *     )
 * )
 */

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
