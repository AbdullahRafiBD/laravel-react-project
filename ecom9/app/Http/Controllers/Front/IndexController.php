<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $sliderBanners = Banner::where('type', 'Slider')->where('status',1)->get()->toArray();
        $fix_1Banners = Banner::where('type', 'Fixed_1')->where('status',1)->get()->toArray();
        // dd($fix_1Banners);
        $fix_2Banners = Banner::where('type', 'Fixed_2')->where('status',1)->get()->toArray();
        $fix_3Banners = Banner::where('type', 'Fixed_3')->where('status',1)->get()->toArray();
        $newProducts = Product::orderBy('id','Desc')->where('status', 1)->limit(8)->get()->toArray();
        // dd($newProducts);
        $bestSellers = Product::where(['is_bestseller'=>'Yes', 'status'=> 1])->inRandomOrder()->get()->toArray();
        $discountedProducts = Product::where('product_discount', '>',0)->where('status',1)->limit(6)->inRandomOrder()->get()->toArray();
        $featuredProducts = Product::where(['is_featured' => 'Yes', 'status' => 1])->inRandomOrder()->get()->toArray();
        // dd($featuredProducts);
        return view('front.index')->with(compact('sliderBanners', 'fix_1Banners', 'fix_2Banners', 'fix_3Banners', 'newProducts', 'bestSellers', 'discountedProducts', 'featuredProducts'));
    }

}
