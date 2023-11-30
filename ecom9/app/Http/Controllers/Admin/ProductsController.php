<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsFilter;
use App\Models\ProductsImage;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function products()
    {
        //sidebar selection
        Session::put('page', 'products');


        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if ($adminType=='vendor') {
            $vendorStatus = Auth::guard('admin')->user()->status;
            // vendor Account status check
            if ($vendorStatus==0) {
                return redirect('admin/update-vendor-details/personal')->with('error_message', 'Your Vendor Account is Not Approved Yet');
            }
        }


        // $products = Product::with(['section', 'category'])->get()->toArray();
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        }, 'category'=>function($query){
            $query->select('id','category_name');
        }]);
        if ($adminType== 'vendor') {
            $products = $products->where('vendor_id',$vendor_id);
        }
        $products = $products->get()->toArray();
        // dd($products);
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        //delete Product
        Product::where('id', $id)->delete();
        $message = 'Product has been deleted Successfully';
        return redirect()->back()->with('success_message', $message);
    }

    public function addEditProduct(Request $request, $id = null)
    {
        //sidebar selection
        Session::put('page', 'products');

        if ($id == '') {
            $title = 'Add Product';
            $product = new Product;
            $message = 'Product Added Successfully!';
        } else {
            $title = 'Edit Product';
            $product = Product::find($id);
            // dd($product);
            // echo '<pre>'; print_r($product['product_name']);die;
            $message = 'Product updated Successfully!';
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            // echo '<pre>'; print_r(Auth::guard('admin')->user());die;

            // validation
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required',
                'product_code' => 'required',
                'product_color' => 'required',
                'product_price' => 'required',
                'product_url' => 'required',
            ];
            $this->validate($request, $rules);

            //Upload Product Image After Resize
            // Small: 250x250 , Medium: 500x500 , Large: 1000x1000
            if ($request->hasFile('product_image')) {
                $image_tmp = $request->file('product_image');
                if ($image_tmp->isValid()) {
                    // # Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $originalName = $image_tmp->getClientOriginalName();
                    // # Generate Image Name
                    $imageName = $originalName .'-'. rand(111, 99999) . '.' . $extension;
                    $largeImagePath = 'front/images/product_images/large/' . $imageName;
                    $mediumImagePath = 'front/images/product_images/medium/' . $imageName;
                    $smallImagePath = 'front/images/product_images/small/' . $imageName;
                    // # Upload the Large, Medium, Small Images After Resize
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);

                    // Insert Image Name in Product Table
                    $product->product_image = $imageName;
                }
            }

            //Upload Product Video After Resize
            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {
                    // Upload video in Video Folder
                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = $video_name . '-'. rand(111, 99999). '.'. $extension;
                    $videoPath = 'front/videos/product_videos/';
                    $video_tmp->move($videoPath,$videoName);
                    // Insert Video Name in Product Table
                    $product->product_video = $videoName;
                }
            }


            // Save Product details in Products Table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];

            // add Filters Value
            $productFilters = ProductsFilter::productFilters();
            foreach ($productFilters as $filter) {
                // echo $data[$filter['filter_column']];
                // die;
                $filterAvailable = ProductsFilter::filterAvailable($filter['id'], $data['category_id']);
                if ($filterAvailable=='Yes') {
                    if (isset($filter['filter_column']) && $data[$filter['filter_column']]) {
                        $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                    }
                }
            }

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;

            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;
            if ($adminType =='vendor') {
                $product->vendor_id = $vendor_id;
            } else {
                $product->vendor_id = 0;
            }

            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_old_price = $data['product_old_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->group_code = $data['group_code'];
            $product->product_short_description = $data['product_short_description'];
            $product->product_long_description = $data['product_long_description'];
            $product->product_url = $data['product_url'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->schema = $data['schema'];
            $product->status = 1;
            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            } else {
                $product->is_featured = 'No';
            }

            if (!empty($data['is_bestseller'])) {
                $product->is_bestseller = $data['is_bestseller'];
            } else {
                $product->is_bestseller = 'No';
            }

            $product->save();

            return redirect('admin/products')->with('success_message', $message);

        }



        // Get Section with Categories and sub categories
        $categories = Section::with('categories')->get()->toArray();
        // dd($categories);

        // get all Brand
        $brands = Brand::where('status',1)->get()->toArray();


        return view('admin.products.add_edit_product')->with(compact('title', 'product', 'message', 'categories', 'brands'));
    }


    public function deleteProductImage($id)
    {
        // get Product Image
        $productImage = Product::select('product_image')->where('id', $id)->first();

        // get Product Image Path
        $large_image_path = 'front/images/product_images/large/';
        $medium_image_path = 'front/images/product_images/medium/';
        $small_image_path = 'front/images/product_images/small/';

        //delete Product  large images From product_images folder if exists
        if (file_exists($large_image_path . $productImage->product_image)) {
            unlink($large_image_path . $productImage->product_image);
        }
        //delete Product  medium images From product_images folder if exists
        if (file_exists($medium_image_path . $productImage->product_image)) {
            unlink($medium_image_path . $productImage->product_image);
        }
        //delete Product  small images From product_images folder if exists
        if (file_exists($small_image_path . $productImage->product_image)) {
            unlink($small_image_path . $productImage->product_image);
        }

        // Delete Product Image from Products Database
        Product::where('id', $id)->update(['product_image' => '']);

        $message = 'Product Image has been deleted Successfully!';
        return redirect()->back()->with('success_message', $message);
    }

    public function deleteProductVideo($id){
        // get Product Video
        $productVideo = Product::select('product_video')->where('id', $id)->first();

        // get Product Image Path
        $video_path = 'front/videos/product_videos/';

        //delete Product  Video From product_video folder if exists
        if (file_exists($video_path . $productVideo->product_video)) {
            unlink($video_path . $productVideo->product_video);
        }

        // Delete Product Video from Products Database
        Product::where('id', $id)->update(['product_video' => '']);

        $message = 'Product Video has been deleted Successfully!';
        return redirect()->back()->with('success_message', $message);
    }

    public function addAttributes(Request $request, $id){
        //sidebar selection
        Session::put('page', 'products');

        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);
        // $product = json_decode(json_encode($product),true);
        // dd($product);
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;

            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {

                    // SKU dublicate Check
                    $skuCount = ProductsAttribute::where('sku',$value)->count();
                    if ($skuCount>0) {
                        return redirect()->back()->with('error_message', 'SKU already exists! Please Add Another SKU');
                    }

                    // Size dublicate Check
                    $sizeCount = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if ($sizeCount > 0) {
                        return redirect()->back()->with('error_message', 'Size already exists! Please Add Another Size');
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            return redirect()->back()->with('success_message', 'Product Attribute has been added Successfully!');
        }

        // dd($product);
        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }



    public function updateAttributeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'attribute_id' => $data['attribute_id']]);
        }
    }

    public function editAttribute(Request $request){
        //sidebar selection
        Session::put('page', 'products');

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            foreach ($data['attributeId'] as $key => $attribute) {
                if (!empty($attribute)) {
                    ProductsAttribute::where(['id'=> $data['attributeId'][$key]])->update(['price'=> $data['price'][$key], 'stock' => $data['stock'][$key], 'sku' => $data['sku'][$key]]);
                }
            }
            return redirect()->back()->with('success_message', 'Product Attribute has been Updated Successfully!');
        }
    }

    public function deleteAttribute($id)
    {
        //delete Product
        ProductsAttribute::where('id', $id)->delete();
        $message = 'Product has been deleted Successfully';
        return redirect()->back()->with('success_message', $message);
    }

    public function addImages(Request $request, $id){
        //sidebar selection
        Session::put('page', 'products');

        $product = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image')->with('images')->find($id);
        // $product = json_decode(json_encode($product),true);
        // dd($product);

        if ($request->isMethod('post')) {
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                // echo '<pre>'; print_r($images); die;
                foreach ($images as $key => $image) {
                    // generate temp Image name
                    $image_tmp = Image::make($image);
                    // Get Image Name
                    $image_name = $image->getClientOriginalName();
                    // # Get Image Extension
                    $extension = $image->getClientOriginalExtension();
                    // # Generate Image Name
                    $imageName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
                    $largeImagePath = 'front/images/product_images/large/' . $imageName;
                    $mediumImagePath = 'front/images/product_images/medium/' . $imageName;
                    $smallImagePath = 'front/images/product_images/small/' . $imageName;
                    // # Upload the Large, Medium, Small Images After Resize
                    Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500, 500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);

                    // Insert Image Name in Product Table
                    $image = new ProductsImage();
                    $image->image = $imageName;
                    $image->product_id = $id;
                    $image->status = 1;
                    $image->save();
                }
            }
            return redirect()->back()->with('success_message', 'Image Has been Added Successfully!');
        }

        return view('admin.images.add_images')->with(compact('product'));

    }

    public function updateImageStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsImage::where('id', $data['image_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'image_id' => $data['image_id']]);
        }
    }

    public function deleteImage($id)
    {
        // get Product Image
        $productImage = ProductsImage::select('image')->where('id', $id)->first();

        // get Product Image Path
        $large_image_path = 'front/images/product_images/large/';
        $medium_image_path = 'front/images/product_images/medium/';
        $small_image_path = 'front/images/product_images/small/';

        //delete Product  large images From product_images folder if exists
        if (file_exists($large_image_path . $productImage->image)) {
            unlink($large_image_path . $productImage->image);
        }
        //delete Product  medium images From images folder if exists
        if (file_exists($medium_image_path . $productImage->image)) {
            unlink($medium_image_path . $productImage->image);
        }
        //delete Product  small images From images folder if exists
        if (file_exists($small_image_path . $productImage->image)) {
            unlink($small_image_path . $productImage->image);
        }

        // Delete Product Image from Products Database
        ProductsImage::where('id', $id)->delete();

        $message = 'Product Image has been deleted Successfully!';
        return redirect()->back()->with('success_message', $message);
    }
}
