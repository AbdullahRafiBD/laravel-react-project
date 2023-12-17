<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsFilter;
use App\Models\Section;
use App\Models\User;
// use Validator;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function registerUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            // echo '<pre>';
            // print_r($data);
            // die;

            $rules = [
                'name' => "required",
                'email' => "required|email|unique:users",
                'mobile' => "required",
                'password' => "required",
            ];
            $customMessages = [
                'name.required' => "Name is Required",
                'email.required' => "Email is Required",
                'email.email' => "Enter a valid email",
                'email.unique' => "Email must be Unique",
                'mobile.required' => "Mobile is Required",
                'password.required' => "Password is Required",
            ];
            $validator = Validator::make($data, $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = new User;
            $user->name = $data['name'];
            $user->mobile = $data['mobile'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->status = 1;
            $user->save();
            return response()->json(['status' => true, 'message' => 'User Register Successfully!'], 201);
        }
    }


    public function loginUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            // echo '<pre>';
            // print_r($data);
            // die;

            // Validation
            $rules = [
                'email' => "required|email|exists:users",
                'password' => "required",
            ];
            $customMessages = [
                'email.required' => "Email is Required",
                'email.email' => "Enter a valid email",
                'email.exists' => "Email does not exists",
                'password.required' => "Password is Required",
            ];
            $validator = Validator::make($data, $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Verify User email Details
            $userCount = User::where('email', $data['email'])->count();
            if ($userCount > 0) {
                // Fetch User Details
                $userDetails = User::where('email', $data['email'])->first();

                // Verify the password
                if (password_verify($data['password'], $userDetails->password)) {
                    return response()->json([
                        'userDetails' => $userDetails,
                        'status' => true,
                        'message' => 'User login successfully',
                    ], 201);
                } else {
                    $massage = 'Password is incorrect!';
                    return response()->json([
                        'status' => false,
                        'message' => $massage,
                    ], 422);
                }
            } else {
                $massage = 'Email is incorrect!';
                return response()->json([
                    'status' => false,
                    'message' => $massage,
                ], 422);
            }
        }
    }

    public function updateUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            // echo '<pre>';
            // print_r($data);
            // die;


            // Validation
            $rules = [
                'name' => "required",
            ];
            $customMessages = [
                'name.required' => "Name is Required",

            ];
            $validator = Validator::make($data, $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }


            // Verify User id Details
            $userCount = User::where('id', $data['id'])->count();
            if ($userCount > 0) {

                if (empty($data['city'])) {
                    $data['city'] = "";
                }
                if (empty($data['state'])) {
                    $data['state'] = "";
                }
                if (empty($data['country'])) {
                    $data['country'] = "";
                }
                if (empty($data['pincode'])) {
                    $data['pincode'] = "";
                }


                // Update User Details
                User::where('id', $data['id'])->update(
                    [
                        'name' => $data['name'],
                        'address' => $data['address'],
                        'city' => $data['city'],
                        'state' => $data['state'],
                        'country' => $data['country'],
                        'pincode' => $data['pincode'],

                    ]
                );

                // Fetch User Details
                $userDetails = User::where('id', $data['id'])->first();

                // Verify the password

                return response()->json([
                    'userDetails' => $userDetails,
                    'status' => true,
                    'message' => 'User Updated successfully',
                ], 201);
            } else {
                $massage = 'User does not exists!';
                return response()->json([
                    'status' => false,
                    'message' => $massage,
                ], 422);
            }
        }
    }


    public function cmsPage()
    {
        $currentRoute = url()->current();
        $currentRoute = str_replace("http://127.0.0.1:8000/api/", "", $currentRoute);
        // echo $currentRoute;
        // die;
        $cmsRoutes = CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
        if (in_array($currentRoute, $cmsRoutes)) {
            // echo 'page will Come';
            $cmsPageDetails = CmsPage::where('url', $currentRoute)->get();
            return response()->json([
                'cmsPageDetails' => $cmsPageDetails,
                'status' => true,
                'message' => 'Page Details Fetched Sucessfully!',
            ], 200);
        } else {
            $massage = 'Page does not exists!';
            return response()->json([
                'status' => false,
                'message' => $massage,
            ], 422);
        }
    }


    public function menu()
    {
        $categories = Section::with('categories')->get();
        return response()->json([
            'categories' => $categories,
            'status' => true,
            'message' => 'Page Details Fetched Sucessfully!',
        ], 200);
    }

    public function listing($url)
    {
        $categoryCount = Category::Where(['url' => $url, 'status' => 1])->count();
        if ($categoryCount > 0) {
            // echo 'Category Listing Working!';

            // Get Category Details
            $categoryDetails = Category::categoryDetails($url);
            // dd($categoryDetails);
            // echo 'Category Exists'; die;
            $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);



            // Checking for Dynamic Filters
            $productFilters = ProductsFilter::productFilters();
            foreach ($productFilters as $key => $filter) {
                // if filter selected
                if (isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])) {
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
                $categoryProducts->whereIn('id', $productIds);
            }

            // Checking For Color
            if (isset($data['color']) && !empty($data['color'])) {
                $productIds = Product::select('id')->whereIn('product_color', $data['color'])->pluck('id')->toArray();
                $categoryProducts->whereIn('id', $productIds);
            }



            // Checking For Price
            if (isset($data['price']) && !empty($data['price'])) {
                // echo '<pre>'; print_r($data['price']); die;
                foreach ($data['price'] as $key => $price) {
                    $priceArr = explode("-", $price);
                    $productIds[] = Product::select('id')->whereBetween('product_price', [$priceArr[0], $priceArr[1]])->pluck('id')->toArray();
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

            $categoryProducts = $categoryProducts->get();

            foreach ($categoryProducts as $key => $value) {
                $getDiscountPrice = Product::getDiscountPrice($categoryProducts[$key]['id']);
                if ($getDiscountPrice > 0) {
                    $categoryProducts[$key]['final_price'] = 'TAKA ' . $getDiscountPrice;
                } else {
                    $categoryProducts[$key]['final_price'] = 'TAKA ' . $categoryProducts[$key]['product_price'];
                }
                $categoryProducts[$key]['product_image'] = url("/front/images/product_images/small/" . $categoryProducts[$key]['product_image']);
            }

            return response()->json([
                'products' => $categoryProducts,
                'status' => true,
                'message' => 'Product Fetched Sucessfully!',
            ], 200);
        } else {
            $message = 'Category URL is Incorrect!';
            return response()->json([
                'status' => false,
                'message' => $message,
            ], 422);
        }
    }

    public function detail($id)
    {
        $productCount = Product::where(['id' => $id, 'status' => 1])->count();
        if ($productCount > 0) {
            $productDetails = Product::with(['section', 'category', 'brand', 'attributes' => function ($query) {
                $query->where('stock', '>', 0)->where('status', 1);
            }, 'images', 'vendor'])->where('id', $id)->get();

            foreach ($productDetails as $key => $value) {
                $getDiscountPrice = Product::getDiscountPrice($productDetails[$key]['id']);
                if ($getDiscountPrice > 0) {
                    $productDetails[$key]['final_price'] = 'TAKA ' . $getDiscountPrice;
                } else {
                    $productDetails[$key]['final_price'] = 'TAKA ' . $productDetails[$key]['product_price'];
                }
                $productDetails[$key]['product_image'] = url("/front/images/product_images/small/" . $productDetails[$key]['product_image']);
            }

            return response()->json([
                'product' => $productDetails,
                'status' => true,
                'message' => 'Product Fetched Sucessfully!',
            ], 200);
        } else {
            $message = 'Product Is Not Available!';
            return response()->json([
                'status' => false,
                'message' => $message,
            ], 422);
        }
    }


    public function addtoCart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();

            // Save Product In Carts Table
            $item = new Cart;
            $item->session_id = 0;
            $item->user_id = $data['user_id'];
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = 1;
            $item->source = 'App';
            $item->save();

            return response()->json([
                'status' => true,
                'message' => 'Product Added Sucessfully!',
            ], 200);
        }
    }
}
