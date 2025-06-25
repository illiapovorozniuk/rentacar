<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="Language",
 *     type="object",
 *     title="Language",
 *     required={"title", "code", "locale", "default"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Language ID"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Language title/name"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="string",
 *         description="Language code (e.g. en, uk, etc.)"
 *     ),
 *     @OA\Property(
 *         property="locale",
 *         type="string",
 *         description="Locale identifier"
 *     ),
 *     @OA\Property(
 *         property="default",
 *         type="boolean",
 *         description="Is default language flag"
 *     ),
 *     @OA\Property(
 *         property="resource_url",
 *         type="string",
 *         description="URL to the language resource"
 *     )
 * )
 */

class Language extends Model
{
    protected $fillable = [
        'title',
        'code',
        'locale',
        'default',

    ];


    protected $dates = [

    ];
    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/languages/'.$this->getKey());
    }
    public static function getLocales()
    {
        return Language::query()->pluck('code');
    }
    public function getLanguageCodes(){
        return Language::query()->get();
    }
    public function getCodes(){
        return $this::query()->pluck('code')->toArray();
    }
    public function getMainLanguage(){
        return Language::where('default', '=', 1)->value('code');
    }
    public function getLanguageByCode($code){
        return Language::where('code', '=', $code)->value('title');
    }
    public function getLangByCode($code){
        return Language::where('code', '=', $code)->first();
    }
    public function getNotDefaultLanguages(){
        return $this::query()->where('default', '=',0)->get();
    }
}
