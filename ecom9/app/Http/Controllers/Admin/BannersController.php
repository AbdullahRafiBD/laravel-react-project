<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Image;
use Session;

class BannersController extends Controller
{
    public function banners(){
        $banners = Banner::get()->toArray();
        // dd($banners); die;
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function updateBannerStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Banner::where('id', $data['banner_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'banner_id' => $data['banner_id']]);
        }
    }

    public function deleteBanner($id)
    {
    // Get Banner Image
    $bannerImage = Banner::where('id',$id)->first();
    // Get Banner image path
    $banner_image_path = 'front/images/banner_images/';
    // Delete Banner Image If exists in folder
    if (file_exists($banner_image_path. $bannerImage->image)) {
        unlink($banner_image_path . $bannerImage->image);
    }
        // delete banner image from banner table
        Banner::where('id', $id)->delete();
        $message = 'Banner has been deleted Successfully';
        return redirect()->back()->with('success_message', $message);

    }

    public function addEditBanner(Request $request, $id = null){

        //sidebar selection
        Session::put('page', 'banners');

        if ($id == '') {
            $title = 'Add Banner';
            $banner = new Banner;
            $message = 'Banner Added Successfully!';
        } else {
            $title = 'Edit Banner';
            $banner = Banner::find($id);
            // dd($banner);
            // echo '<pre>'; print_r($banner['brand_name']);die;
            $message = 'Banner updated Successfully!';
        }

        // if ($request->isMethod('post')) {
        //     $data = $request->all();
        //     echo '<pre>'; print_r($data);die;
        // }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;

            // validation


            // Upload Banner Photo
            if ($data['type']== 'Slider') {
                $width = '1920';
                $height = '720';
            }
            elseif
            ($data['type'] == 'Fixed_1') {
                $width = '1110';
                $height = '236';
            }
            elseif
            ($data['type'] == 'Fixed_2') {
                $width = '1110';
                $height = '236';
            }
            elseif
            ($data['type'] == 'Fixed_3') {
                $width = '1110';
                $height = '720';
            }

            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    // # Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // # Generate Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/banner_images/' . $imageName;
                    // # Upload Image
                    Image::make($image_tmp)->resize($width,$height)->save($imagePath);
                    $banner->image = $imageName;
                }
            }

            $banner->type = $data['type'];
            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            $banner->status = 1;
            $banner->save();

            return redirect('admin/banners')->with('success_message', $message);
        }


        return view('admin.banners.add_edit_banner')->with(compact('title', 'banner', 'message'));
    }
}
