<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsFilter;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ProductsController extends Controller
{
    public function listing(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>';
            // print_r($data);
            // die;

            // echo 'test'; die;
            $url = $data['url'];
            $_GET['sort'] = $data['sort'];

            // echo '$url'; die;
            $categoryCount = Category::Where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                // Get Category Details
                $categoryDetails = Category::categoryDetails($url);
                // dd($categoryDetails);
                // echo 'Category Exists'; die;
                // meaning -> multiple data where er jonne --> whereIn()
                // $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1)->get()->toArray();

                // paginations
                // $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1)->simplePaginate(3);
                // $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1)->cursorPaginate(3);
                // $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1)->paginate(3);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                // Checking for Fabric
                // if (isset($data['fabric']) && !empty($data['fabric'])) {
                //     $categoryProducts->whereIn('products.fabric', $data['fabric']);
                // }

                // Checking for Dynamic Filters
                $productFilters = ProductsFilter::productFilters();
                foreach ($productFilters as $key => $filter) {
                    // if filter selected
                    if (isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']]) ) {
                        $categoryProducts->whereIn($filter['filter_column'], $data[$filter['filter_column']]);
                    }
                }



                // Check For Sort
                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort'] == 'product_latest') {
                        $categoryProducts->orderby('products.id', 'Desc');
                    } elseif ($_GET['sort'] == 'price_lowest') {
                        $categoryProducts->orderby('products.product_price', 'Asc');
                    } elseif ($_GET['sort'] == 'price_highest') {
                        $categoryProducts->orderby('products.product_price', 'Desc');
                    } elseif ($_GET['sort'] == 'name_a_z') {
                        $categoryProducts->orderby('products.product_name', 'Asc');
                    } elseif ($_GET['sort'] == 'name_z_a') {
                        $categoryProducts->orderby('products.product_name', 'Desc');
                    }
                }

                // Checking For Size
                if (isset($data['size']) && !empty($data['size'])) {
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size', $data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('id',$productIds);
                }

                // Checking For Color
                if (isset($data['color']) && !empty($data['color'])) {
                    $productIds = Product::select('id')->whereIn('product_color', $data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('id',$productIds);
                }

                // // Checking For Price
                // if (isset($data['price']) && !empty($data['price'])) {
                //     // echo '<pre>'; print_r($data['price']); die;
                //     $implodePrices = implode('-',$data['price']);
                //     $explodePrices = explode('-', $implodePrices);
                //     // echo '<pre>'; print_r($explodePrices); die;
                //     $min = reset($explodePrices);
                //     $max = end($explodePrices);
                //     $productIds = Product::select('id')->whereBetween('product_price', [$min,$max])->pluck('id')->toArray();
                //     $categoryProducts->whereIn('products.id', $productIds);
                // }

                // Checking For Price
                if (isset($data['price']) && !empty($data['price'])) {
                    // echo '<pre>'; print_r($data['price']); die;
                    foreach ($data['price'] as $key => $price) {
                        $priceArr = explode("-",$price);
                        $productIds[] = Product::select('id')->whereBetween('product_price',[$priceArr[0], $priceArr[1]])->pluck('id')->toArray();
                    }
                    // echo '<pre>';print_r($productIds);die;
                    $productIds = call_user_func_array('array_merge', $productIds);
                    // echo '<pre>';print_r($productIds);die;
                    $categoryProducts->whereIn('products.id', $productIds);
                }

                // Checking For Brand
                if (isset($data['brand']) && !empty($data['brand'])) {
                    $productIds = Product::select('id')->whereIn('brand_id', $data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('id', $productIds);
                }

                $categoryProducts = $categoryProducts->paginate(30);

                // dd($categoryProducts);

                return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
            } else {
                abort(404);
            }

        } else {
            // echo 'test'; die;
            $url = Route::getFacadeRoot()->current()->uri();
            // echo '$url'; die;
            $categoryCount = Category::Where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                // Get Category Details
                $categoryDetails = Category::categoryDetails($url);
                // dd($categoryDetails);
                // echo 'Category Exists'; die;
                // meaning -> multiple data where er jonne --> whereIn()
                // $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1)->get()->toArray();

                // paginations
                // $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1)->simplePaginate(3);
                // $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1)->cursorPaginate(3);
                // $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1)->paginate(3);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                // Check For Sort
                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort'] == 'product_latest') {
                        $categoryProducts->orderby('products.id', 'Desc');
                    } elseif ($_GET['sort'] == 'price_lowest') {
                        $categoryProducts->orderby('products.product_price', 'Asc');
                    } elseif ($_GET['sort'] == 'price_highest') {
                        $categoryProducts->orderby('products.product_price', 'Desc');
                    } elseif ($_GET['sort'] == 'name_a_z') {
                        $categoryProducts->orderby('products.product_name', 'Asc');
                    } elseif ($_GET['sort'] == 'name_z_a') {
                        $categoryProducts->orderby('products.product_name', 'Desc');
                    }
                }
                $categoryProducts = $categoryProducts->paginate(30);

                // dd($categoryProducts);

                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
            } else {
                abort(404);
            }
        }
    }


    public function vendorListing($vendorid){
        // get vendor Shop Name
        $getVendorShop = Vendor::getVendorShop($vendorid);
        // echo $getVendorShop; die;

        // Get Vendor Products
        $vendorProducts = Product::with('brand')->where('vendor_id', $vendorid)->where('status', 1);
        $vendorProducts = $vendorProducts->paginate(30);
        // dd($vendorProducts);
        return view('front.products.vendor_listing')->with(compact('getVendorShop', 'vendorProducts'));
    }

    public function detail($id){
        // $productDetails = Product::with('section','category', 'brand', 'attributes', 'images')->find($id)->toArray();
        $productDetails = Product::with(['section','category', 'brand', 'attributes' =>function($query){
            $query->where('stock','>',0)->where('status',1);
        }, 'images', 'vendor'])->find($id)->toArray();
        // dd($productDetails);
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        // dd($categoryDetails);

        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');
        // echo $totalStock;
        // die;

        // Get Similar Products
        $similarProducts = Product::with('brand')->where('category_id', $productDetails['category']['id'])->where('id','!=',$id)->limit(4)->inRandomOrder()->get()->toArray();
        // dd($similarProducts);


        // Get Session For Recently Viewed Product
        if (empty(Session::get('session_id'))) {
            $session_id = md5(uniqid(rand(), true));
            // echo $session_id;die;
        } else {
            $session_id = Session::get('session_id');
        }
        Session::put('session_id', $session_id);
        // Insert Product in Table if not already exists
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=>$id, 'session_id' => $session_id,])->count();
        if ($countRecentlyViewedProducts==0) {
            DB::table('recently_viewed_products')->insert(['product_id' => $id, 'session_id' => $session_id,]);
        }
        // Get Recently Viewed Products Ids
        $recentProductsIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)->where('session_id', $session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
        // dd($recentProductsIds);

        // Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('brand')->whereIn('id', $recentProductsIds)->get()->toArray();
        // dd($recentlyViewedProducts);

        // Get group Products (Products Color)
        $groupProducts = array();
        if (!empty($productDetails['group_code'])) {
            $groupProducts = Product::select('id','product_image')->where('id', '!=', $id)->where(['group_code' => $productDetails['group_code'], 'status' => 1])->get()->toArray();
            // dd($groupProducts);
        }

        return view('front.products.detail')->with(compact('productDetails', 'categoryDetails', 'totalStock', 'similarProducts', 'recentlyViewedProducts', 'groupProducts'));
    }


    public function getProductPrice(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>';print_r($data);die;
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);
            return $getDiscountAttributePrice;
        }
    }

    public function cartAdd(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;

            // Check product Stock are available or not
            $getProductStock = ProductsAttribute::getProductStock($data['product_id'], $data['size']);
            // echo $getProductStock; die;
            if ($getProductStock<$data['quantity']) {
                return redirect()->back()->with('error_message','Required Quantity is not available');
            }

            // Generate Session Id if Not Exists
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            // Check Products is Already Exists in the user cart
            if (Auth::check()) {
                // User is Logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=> $data['product_id'],'size'=> $data['size'], 'user_id' => $user_id])->count();
            } else {
                // User is not Logged in
                $user_id = 0;
                $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'session_id' => $session_id])->count();
            }

            // Save Products Into cart Table
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();
            return redirect()->back()->with('success_message', 'Product Has Been Added In Cart');
        }
    }
    public function cart(){

        $getCartItems = Cart::getCartItems();
        // dd($getCartItems);

        return view('front.products.cart')->with(compact('getCartItems'));
    }

    public function cartUpdate(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>';print_r($data);die;

            // Get Cart Details
            $cartDetails = Cart::find($data['cartid']);

            // get Available Product Stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=> $cartDetails['product_id'], 'size' => $cartDetails['size']])->first()->toArray();
            // echo '<pre>'; print_r($availableStock);die;
            // Check If desired stock from user is Available
            if ($data['qty']> $availableStock['stock']) {
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Product Stock is not Available',
                    'view' => (string)View::make('front.products.cart_items')->with(compact('getCartItems'))
                ]);
            }

            // check if Product Size is Available
            $availableSize = ProductsAttribute::where(['product_id' => $cartDetails['product_id'], 'size' => $cartDetails['size'],'status'=>1])->count();
            if ($availableSize==0) {
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Product Size is not Available. Please Remove this product',
                    'view' => (string)View::make('front.products.cart_items')->with(compact('getCartItems'))
                ]);
            }

            // Update the quantity
            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $getCartItems = Cart::getCartItems();
            return response()->json([
                'status'=>true,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    public function cartDelete(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>';print_r($data);die;
            Cart::where('id',$data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            return response()->json([
                'view' => (string)View::make('front.products.cart_items')->with(compact('getCartItems'))
            ]);
        }
    }
}
