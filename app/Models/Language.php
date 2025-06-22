<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

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
