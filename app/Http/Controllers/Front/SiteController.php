<?php

namespace App\Http\Controllers\Front;

use App\Models\BodyType;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Page;
use App\Enums\PageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home_page = Page::where('type', PageType::DEFAULT->value)->first();
        $title = $home_page->title;
        $h1 = $home_page->h1;
        $content = $home_page->content;
        $description = $home_page->description;
        $cover = $home_page->getMedia('cover');
        $brands = Brand::all();
        if ($home_page->faq != null) {
            $faqs = json_decode($home_page->faq);
        } else {
            $faqs = [];
        }

        $cars = Car::all();
        $cars = Car::carsInfo($cars->toArray());

        return view('front.index', compact('home_page', 'h1', 'title', 'content', 'description', 'cover', 'brands', 'cars', 'faqs'));
    }

    public function brands()
    {
        $page = Page::where('type', PageType::BRANDS->value)->first();
        if ($page == null) {
            abort(404);
        }
        $title = $page->title;
        $h1 = $page->h1;
        $content = $page->content;
        $description = $page->description;
        $cover = $page->getMedia('cover');
        $brands = Brand::all();
        if ($page->faq != null) {
            $faqs = json_decode($page->faq);
        } else {
            $faqs = [];
        }

        return view('front.brands', compact('page', 'h1', 'title', 'content', 'description', 'cover', 'brands'));
    }

    public function bodyTypes()
    {
        $page = Page::where('type', PageType::BODIES->value)->first();
        if ($page == null) {
            abort(404);
        }
        $title = $page->title;
        $h1 = $page->h1;
        $content = $page->content;
        $description = $page->description;
        $cover = $page->getMedia('cover');
        $bodies = BodyType::all();
        if ($page->faq != null) {
            $faqs = json_decode($page->faq);
        } else {
            $faqs = [];
        }

        return view('front.bodies', compact('page', 'h1', 'title', 'content', 'description', 'cover', 'bodies'));
    }

    public function car($id)
    {
        if (!is_numeric($id)) {
            abort(404);
        }
        $car = Car::query()->where('id', $id)->where('status', 1)->firstOrFail();
        $car = $car->carInfo();

        $locale = app()->getLocale();
        $h1 = ucwords($car->brand_slug) . ' ' . (json_decode($car->car_model_name)->$locale ?? '') . ' ' . $car->attribute_year . ' ' . (json_decode($car->color_name)->$locale ?? '');
        $car_title = ucwords($car->brand_slug) . ' ' . (json_decode($car->car_model_name)->$locale ?? '') . ' ' . $car->attribute_year;
        $photos = $car->photos;
        $touched_cars = Car::all()->where('status', 1)->where('id', '!=', $car->id)->take(4)->toArray();
        $touched_cars = Car::carsInfo($touched_cars);
        $data = $car;

        return view('front.car', compact('data', 'h1', 'car_title', 'photos', 'touched_cars'));
    }

    public function brand($slug)
    {
        $brand = Brand::getBrandBySlug($slug);
        if ($brand == null) {
            abort(404);
        }
        $data = Car::getCarsByBrandId($brand->id);
        $data = Car::carsInfo($data->toArray());
        $brand_page = Page::where('type', PageType::BRAND->value)->first();
        if ($brand_page == null) {
            abort(404);
        }
        $touched_cars = Car::all()->where('status', 1)->where('car_brand_id', '!=', $brand->id)->take(4)->toArray();
        $touched_cars = Car::carsInfo($touched_cars);
        $h1 = str_replace('{slug}',$brand->name,$brand_page->h1);
        $title = str_replace('{slug}',$brand->name,$brand_page->title);
        $content = str_replace('{slug}',$brand->name,$brand_page->content);
        $description = $brand_page->description;
        $curret_locale = app()->getLocale();
        $faq_slug_replacement = $brand->name;
        if ($brand_page->faq != null) {
            $faqs = json_decode($brand_page->faq);
        } else {
            $faqs = [];
        }

        return view('front.plp', compact('data', 'h1', 'title', 'content', 'description', 'brand', 'faqs', 'touched_cars', 'faq_slug_replacement'));

    }
}
