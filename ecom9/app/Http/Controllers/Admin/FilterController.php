<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductsFilter;
use App\Models\ProductsFiltersValue;
use App\Models\Section;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class FilterController extends Controller
{
    public function filters(){
        //sidebar selection
        // Session::put('page', 'filters');

        $filters = ProductsFilter::get()->toArray();
        // dd($filters);

        return view('admin.filters.filters')->with(compact('filters'));
    }

    public function filtersValues(){
        //sidebar selection
        // Session::put('page', 'filters');

        $filters_values = ProductsFiltersValue::get()->toArray();
        // dd($filters_values);

        return view('admin.filters.filters_values')->with(compact('filters_values'));
    }

    public function updateFilterStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsFilter::where('id', $data['filter_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'filter_id' => $data['filter_id']]);
        }
    }

    public function updateFilterValueStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsFiltersValue::where('id', $data['filter_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'filter_id' => $data['filter_id']]);
        }
    }

    public function addEditFilter(Request $request, $id = null){
        //sidebar selection
        // Session::put('page', 'filters');

        if ($id == '') {
            $title = 'Add Filter Column';
            $filter = new ProductsFilter;
            $message = 'Filter Added Successfully!';
        } else {
            $title = 'Edit Filter Column';
            $filter = ProductsFilter::find($id);
            // dd($brand);
            // echo '<pre>'; print_r($brand['brand_name']);die;
            $message = 'Filter updated Successfully!';
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;

            $cat_ids = implode(',',$data['cat_ids']);

            // save Filter Column details in Product filter details
            $filter->cat_ids = $cat_ids;
            $filter->filter_name = $data['filter_name'];
            $filter->filter_column = $data['filter_column'];
            $filter->status = 1;
            $filter->save();

            // add Filter Column in Products table
            DB::statement('Alter table products add '. $data['filter_column']. ' varchar(255) after product_long_description');

            return redirect('admin/filters')->with('success_message', $message);
        }

        // Get Section with Categories and sub categories
        $categories = Section::with('categories')->get()->toArray();
        // dd($categories);

        return view('admin.filters.add_edit_filter')->with(compact('title', 'filter', 'message', 'categories'));
    }


    public function addEditFilterValue(Request $request, $id = null){
        //sidebar selection
        // Session::put('page', 'filters');

        if ($id == '') {
            $title = 'Add Filter Value';
            $filter = new ProductsFiltersValue;
            $message = 'Filter Value Added Successfully!';
        } else {
            $title = 'Edit Filter Value';
            $filter = ProductsFiltersValue::find($id);
            // dd($brand);
            // echo '<pre>'; print_r($brand['brand_name']);die;
            $message = 'Filter Value updated Successfully!';
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;

            // save Filter Value details in Product filter Value details
            $filter->filter_id = $data['filter_id'];
            $filter->filter_value = $data['filter_value'];
            $filter->status = 1;
            $filter->save();

           return redirect('admin/filters-values')->with('success_message', $message);
        }

        // Get filters
        $filters = ProductsFilter::where('status',1)->get()->toArray();


        return view('admin.filters.add_edit_filter_value')->with(compact('title', 'filter', 'message', 'filters'));
    }

    public function categoryFilters(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // dd($data);
            // echo '<pre>'; print_r($data);die();
            $category_id = $data['category_id'];
            return response()->json([
                'view'=>(string)View::make('admin.filters.category_filters')->with(compact('category_id'))
            ]);
        }
    }
}
