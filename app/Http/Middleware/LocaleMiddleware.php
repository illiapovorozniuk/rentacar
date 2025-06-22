<?php

namespace App\Http\Middleware;

use App\Models\Language;
use App\Services\Front\SetSiteService;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    protected $main_lang;
    protected $languages;

    public function __construct()
    {
        $this->main_lang = Language::query()->where('default', 1)->value('code');
        $this->languages = Language::query()->pluck('code')->toArray();
    }

    public function isDatabaseReady()
    {
        return env('APP_ENV') !== 'test';
    }

    public static function getLocale()
    {
        $uri = Request::path();
        $segmentsURI = explode('/', $uri);

        $languages = Language::all()->pluck('code')->toArray();
        $mainLang = Language::query()->where('default', '=', 1)->value('code');
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], $languages)) {
            if ($segmentsURI[0] != $mainLang) return $segmentsURI[0];
        }
    }

    public function handle($request, Closure $next)
    {
        $lang = $this->getLocale();

        if ($lang) {
            App::setLocale($lang);
            Session::put('locale', $lang);
        } else {
            App::setLocale($this->main_lang);
            Session::put('locale', $this->main_lang);
        }

        $languages =Language::all();
        Config::set('app.fallback_locale', $this->main_lang);
        Config::set("app.available_locales", $languages);
        return $next($request);
    }
    }
