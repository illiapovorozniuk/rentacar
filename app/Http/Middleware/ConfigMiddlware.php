<?php

namespace App\Http\Middleware;

use App\Models\BodyType;
use App\Models\Brand;
use App\Models\Currency;
use App\Models\Type;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;

class ConfigMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $brands = Brand::all();
        $bodies = BodyType::all();
        $types = Type::all();
        $currencies = Currency::all();
        $currentCurrency = session('currency');
        if ($currentCurrency == null) {
            $mainCurrency = Currency::where('exchange_rate', 1.00)->first();
            session(['currency' => $mainCurrency]);
            $currentCurrency = $mainCurrency;
        }

        Config::set('site.brands', $brands);
        Config::set('site.bodies', $bodies);
        Config::set('site.types', $types);
        Config::set('site.currencies', $currencies);
        Config::set('site.current_currency', $currentCurrency);

        return $next($request);
    }
}
