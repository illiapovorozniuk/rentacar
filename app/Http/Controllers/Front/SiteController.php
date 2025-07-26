<?php

namespace App\Http\Controllers\Front;

use App\Models\BodyType;
use App\Models\Brand;
use App\Models\Car;
use App\Models\City;
use App\Models\Page;
use App\Enums\PageType;
use App\Models\Type;
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
     * @OA\Get(
     *     path="/",
     *     summary="Show the application dashboard",
     *     tags={"Site"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
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

        $cars = Car::all()->take(16);
        $cars = Car::carsInfo($cars->toArray());

        return view('front.index', compact('home_page', 'h1', 'title', 'content', 'description', 'cover', 'brands', 'cars', 'faqs'));
    }

    /**
     * @OA\Get(
     *     path="/brands",
     *     summary="Show all brands",
     *     tags={"Site"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/body-types",
     *     summary="Show all body types",
     *     tags={"Site"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     )
     * )
     */
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

    public function bodyType($slug)
    {
        $body = BodyType::getBodyTypeBySlug($slug);
        if ($body == null) {
            abort(404);
        }
        $sortBy = request('sortBy', 'default');
        $carQuery = Car::query()->where('car_body_type_id', $body->id);
        if ($sortBy === 'price_asc') {
            $carQuery->orderBy('price_1', 'asc');
        } elseif ($sortBy === 'price_desc') {
            $carQuery->orderBy('price_1', 'desc');
        }
        $data = $carQuery->paginate(5);
        $pagin_links = $data->appends(request()->query())->links();
        $data = Car::carsInfo($data->toArray(), $sortBy);

        $body_page = Page::where('type', PageType::BODY->value)->first();
        if ($body_page == null) {
            abort(404);
        }
        $touched_cars = Car::all()->where('status', 1)->where('car_body_type_id', '!=', $body_page->id)->whereNotIn('id',$data->pluck('id'))->shuffle()->take(4)->toArray();
        $touched_cars = Car::carsInfo($touched_cars);
        $h1 = str_replace('{slug}',$body->name,$body_page->h1);
        $title = str_replace('{slug}',$body->nafme,$body_page->title);
        $content = str_replace('{slug}',$body->name,$body_page->content);
        $description = $body_page->description;
        $curret_locale = app()->getLocale();
        $faq_slug_replacement = $body->name;
        if ($body_page->faq != null) {
            $faqs = json_decode($body_page->faq);
        } else {
            $faqs = [];
        }
//        dd($faqs);
        return view('front.plp', compact('data', 'h1', 'title', 'content', 'description', 'body', 'faqs', 'touched_cars', 'faq_slug_replacement','pagin_links'));

    }

    public function types()
    {
        $page = Page::where('type', PageType::TYPES->value)->first();
        if ($page == null) {
            abort(404);
        }
        $title = $page->title;
        $h1 = $page->h1;
        $content = $page->content;
        $description = $page->description;
        $cover = $page->getMedia('cover');
        $types = Type::all();
        if ($page->faq != null) {
            $faqs = json_decode($page->faq);
        } else {
            $faqs = [];
        }

        return view('front.types', compact('page', 'h1', 'title', 'content', 'description', 'cover', 'types'));
    }

    public function type($slug)
    {
        $type = Type::getTypeBySlug($slug);
        if ($type == null) {
            abort(404);
        }
        $sortBy = request('sortBy', 'default');
        $models = $type->carModel()->get();
        $modelIds = $models->pluck('id')->toArray();
        $carQuery = Car::whereIn('car_model_id', $modelIds);
        if ($sortBy === 'price_asc') {
            $carQuery->orderBy('price_1', 'asc');
        } elseif ($sortBy === 'price_desc') {
            $carQuery->orderBy('price_1', 'desc');
        } elseif ($sortBy === 'min_day_reservation') {
            $carQuery->orderBy('min_day_reservation', 'asc');
        }
        $data = $carQuery->paginate(5);
        if(count($data) == 0){
            abort(404);
        }
        $pagin_links = $data->appends(request()->query())->links();
        $data = Car::carsInfo($data->toArray(), $sortBy);
        $type_page = Page::where('type', PageType::TYPE->value)->first();
        if ($type_page == null) {
            abort(404);
        }
        $touched_cars = Car::all()->where('status', 1)->whereNotIn('id',$data->pluck('id'))->shuffle()->take(4)->toArray();
        $touched_cars = Car::carsInfo($touched_cars);
        $h1 = str_replace('{slug}',$type->name,$type->h1);
        $title = str_replace('{slug}',$type->nafme,$type_page->title);
        $content = str_replace('{slug}',$type->name,$type_page->content);
        $description = $type_page->description;
        $curret_locale = app()->getLocale();
        $faq_slug_replacement = $type->name;
        if ($type_page->faq != null) {
            $faqs = json_decode($type_page->faq);
        } else {
            $faqs = [];
        }
        return view('front.plp', compact('data', 'h1', 'title', 'content', 'description', 'type', 'faqs', 'touched_cars', 'faq_slug_replacement','pagin_links'));

    }
    /**
     * @OA\Get(
     *     path="/car/{id}",
     *     summary="Show car details",
     *     tags={"Site"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Car ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found"
     *     )
     * )
     */
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
        $touched_cars = Car::all()->where('status', 1)->where('id', '!=', $car->id)->shuffle()->take(4)->toArray();
        $touched_cars = Car::carsInfo($touched_cars);
        $data = $car;

        return view('front.car', compact('data', 'h1', 'car_title', 'photos', 'touched_cars'));
    }

    /**
     * @OA\Get(
     *     path="/brand/{slug}",
     *     summary="Show cars by brand",
     *     tags={"Site"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Brand slug",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Brand not found"
     *     )
     * )
     */
    public function brand($slug)
    {
        $brand = Brand::getBrandBySlug($slug);
        if ($brand == null) {
            abort(404);
        }
        $sortBy = request('sortBy', 'default');
        $carQuery = Car::query()->where('car_brand_id', $brand->id);
        if ($sortBy === 'price_asc') {
            $carQuery->orderBy('price_1', 'asc');
        } elseif ($sortBy === 'price_desc') {
            $carQuery->orderBy('price_1', 'desc');
        } elseif ($sortBy === 'min_day_reservation') {
            $carQuery->orderBy('min_day_reservation', 'asc');
        }
        $data = $carQuery->paginate(5);
        $pagin_links = $data->appends(request()->query())->links();
        $data = Car::carsInfo($data->toArray(), $sortBy);
        $brand_page = Page::where('type', PageType::BRAND->value)->first();
        if ($brand_page == null) {
            abort(404);
        }
        $touched_cars = Car::all()->where('status', 1)->where('car_brand_id', '!=', $brand->id)->shuffle()->take(4)->toArray();
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

        return view('front.plp', compact('data', 'h1', 'title', 'content', 'description', 'brand', 'faqs', 'touched_cars', 'faq_slug_replacement', 'pagin_links'));

    }

    public function city($slug)
    {
        $city = City::getCityBySlug($slug);
        if ($city == null) {
            abort(404);
        }
//        $data = Car::getCarsByBrandId($brand->id);
//        $data = Car::carsInfo($data->toArray());
        $data = Car::query()->where('city_id', $city->id)->paginate(5);
        $pagin_links = $data->links();
        $data = Car::carsInfo($data->toArray());

        $touched_cars = Car::all()->where('status', 1)->where('city_id', '!=', $city->id)->take(4)->toArray();
        $touched_cars = Car::carsInfo($touched_cars);
        $title= '';
        $h1 ='';
        $faqs = [];
//        $h1 = str_replace('{slug}',$city->name,$brand_page->h1);
//        $title = str_replace('{slug}',$brand->name,$brand_page->title);
//        $content = str_replace('{slug}',$brand->name,$brand_page->content);
//        $description = $brand_page->description;

        return view('front.plp', compact('data','h1','title', 'city','faqs',  'touched_cars',  'pagin_links'));

    }
}
