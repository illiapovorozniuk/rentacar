<?php

namespace App\Http\Middleware;

use App\Models\BodyType;
use App\Models\Brand;
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

        Config::set('site.brands', $brands);
        Config::set('site.bodies', $bodies);

        return $next($request);
    }
}
