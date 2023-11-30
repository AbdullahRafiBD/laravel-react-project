<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Image;
use Session;

class CategoryController extends Controller
{
    public function categories(){
        //sidebar selection
        Session::put('page','categories');

        $categories = Category::with(['section','parentcategory'])->get()->toArray();
        // dd($categories);
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            if ($data['status']=='Active') {
                $status = 0;
            }else {
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request,$id=null){

        //sidebar selection
        Session::put('page','categories');

        if ($id=='') {
            $title = 'Add Category';
            $category = new Category;
            $getCategories = array();
            $message = 'Category Added Successfully!';
        } else {
            $title = 'Edit Category';
            $category = Category::find($id);
            // dd($category);
            // echo '<pre>'; print_r($category['category_name']);die;
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$category['section_id']])->get();
            // echo '<pre>'; print_r($getCategories);die;
            // dd($getCategories);
            $message = 'Category updated Successfully!';
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;

            if ($data['category_discount']=='') {
                $data['category_discount'] = 0;
            }

            // validation
            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
            ];
            $this->validate($request, $rules);

            // Upload Category Photo
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    // # Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // # Generate Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/category_images/' . $imageName;
                    // # Upload Image
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image = $imageName;
                }
            } else {
                $category->category_image = '';
            }

            $category->category_name = $data['category_name'];
            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->schema = $data['schema'];
            $category->status = 1;
            $category->save();

            return redirect('admin/categories')->with('success_message',$message);

        }

        // Get All Sections
        $getSections = Section::get()->toArray();

        return view('admin.categories.add_edit_category')->with(compact('title','category','message','getSections','getCategories'));

    }

    public function appendCategoryLevel(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo $data['section_id'];die;
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$data['section_id']])->get()->toArray();
            // dd($getCategories);
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }


    public function deleteCategory($id){
        //delete section
        Category::where('id',$id)->delete();
        $message = 'Category has been deleted Successfully';
        return redirect()->back()->with('success_message',$message);
    }

    public function deleteCategoryImage($id){
        // get Category Image
        $categoryImage = Category::select('category_image')->where('id',$id)->first();

        // get Category Image Path
        $category_image_path = 'front/images/category_images/';

        //delete Category images From category_images folder if exists
        if (file_exists($category_image_path.$categoryImage->category_image)) {
            unlink($category_image_path.$categoryImage->category_image);
        }

        // Delete Category Image from Categories Database
        Category::where('id',$id)->update(['category_image'=>'']);

        $message = 'Category has been deleted Successfully!';
        return redirect()->back()->with('success_message',$message);
    }



}
