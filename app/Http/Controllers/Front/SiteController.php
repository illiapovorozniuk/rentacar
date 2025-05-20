<?php

namespace App\Http\Controllers\Front;

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
        if($home_page->faq != null){
            $faqs =  json_decode($home_page->faq);
        }else{
            $faqs = [];
        }

        $cars = Car::all();
        $cars = Car::carsInfo($cars->toArray());

        return view('front.index', compact('home_page','h1', 'title', 'content', 'description', 'cover', 'brands', 'cars','faqs'));
    }

    public function brands(){
        $page = Page::where('type', PageType::BRANDS->value)->first();
        $title = $page->title;
        $h1 = $page->h1;
        $content = $page->content;
        $description = $page->description;
        $cover = $page->getMedia('cover');
        $brands = Brand::all();
        if($page->faq != null){
            $faqs =  json_decode($page->faq);
        }else{
            $faqs = [];
        }

        return view('front.brands', compact('page','h1', 'title', 'content', 'description', 'cover', 'brands'));
    }
}
