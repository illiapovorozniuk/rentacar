<?php

namespace App\Http\Controllers\Front;

use App\Models\Brand;
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
        return view('front.index', compact('home_page','h1', 'title', 'content', 'description', 'cover', 'brands'));
    }
}
