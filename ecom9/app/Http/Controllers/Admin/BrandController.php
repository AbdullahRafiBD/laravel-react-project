<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Image;
use Session;

class BrandController extends Controller
{
    public function brands()
    {
        //sidebar selection
        Session::put('page', 'brands');

        $brands = Brand::get()->toArray();
        // dd($brands);
        return view('admin.brands.brands')->with(compact('brands'));
    }

    public function updateBrandStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Brand::where('id', $data['brand_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'brand_id' => $data['brand_id']]);
        }
    }

    public function addEditBrand(Request $request, $id = null)
    {
        //sidebar selection
        Session::put('page', 'brands');

        if ($id == '') {
            $title = 'Add Brand';
            $brand = new Brand;
            $message = 'Brand Added Successfully!';
        } else {
            $title = 'Edit Brand';
            $brand = Brand::find($id);
            // dd($brand);
            // echo '<pre>'; print_r($brand['brand_name']);die;
            $message = 'Brand updated Successfully!';
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;

            // validation
            $rules = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'url' => 'required',
            ];
            $this->validate($request, $rules);

            // Upload Brand Photo
            if ($request->hasFile('brand_image')) {
                $image_tmp = $request->file('brand_image');
                if ($image_tmp->isValid()) {
                    // # Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // # Generate Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/brand_images/' . $imageName;
                    // # Upload Image
                    Image::make($image_tmp)->save($imagePath);
                    $brand->brand_image = $imageName;
                }
            } else {
                $brand->brand_image = '';
            }

            $brand->name = $data['brand_name'];
            $brand->description = $data['description'];
            $brand->url = $data['url'];
            $brand->meta_title = $data['meta_title'];
            $brand->meta_description = $data['meta_description'];
            $brand->meta_keywords = $data['meta_keywords'];
            $brand->schema = $data['schema'];
            $brand->status = 1;
            $brand->save();

            return redirect('admin/brands')->with('success_message', $message);
        }

        return view('admin.brands.add_edit_brand')->with(compact('title', 'brand', 'message'));
    }


    public function deleteBrand($id)
    {
        //delete brand
        Brand::where('id', $id)->delete();
        $message = 'Brand has been deleted Successfully';
        return redirect()->back()->with('success_message', $message);
    }

    public function deleteBrandImage($id)
    {
        // get Brand Image
        $brandImage = Brand::select('brand_image')->where('id', $id)->first();

        // get Brand Image Path
        $brand_image_path = 'front/images/brand_images/';

        //delete Brand images From brand_images folder if exists
        if (file_exists($brand_image_path . $brandImage->brand_image)) {
            unlink($brand_image_path . $brandImage->brand_image);
        }

        // Delete Brand Image from Brands Database
        Brand::where('id', $id)->update(['brand_image' => '']);

        $message = 'Brand has been deleted Successfully!';
        return redirect()->back()->with('success_message', $message);
    }
}
