<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CmsController extends Controller
{
    public function cmspages()
    {
        Session::put('page', 'cmspages');
        $cms_pages = CmsPage::get()->toArray();
        return view('admin.pages.cms_pages')->with(compact('cms_pages'));
    }

    public function updatePageStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>';
            // print_r($data);
            // die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            CmsPage::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    public function deletePage($id)
    {
        //delete page
        CmsPage::where('id', $id)->delete();
        $message = 'Page has been deleted Successfully';
        return redirect()->back()->with('success_message', $message);
    }


    public function addEditCmsPage(Request $request, $id = null)
    {
        Session::put('page', 'cmspages');
        if ($id == '') {
            $title = 'Add Page';
            $cmspage = new CmsPage;
            $message = 'Page Added Successfully!';
        } else {
            $title = 'Edit Page';
            $cmspage = CmsPage::find($id);
            // dd($cmspage);
            // echo '<pre>'; print_r($cmspage['page_name']);die;
            $message = 'Page updated Successfully!';
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            // echo '<pre>'; print_r(Auth::guard('admin')->user());die;

            // validation
            $rules = [
                'title' => 'required',
                'url' => 'required',
                'description' => 'required',
            ];
            $this->validate($request, $rules);




            // Save CMS Page details in Cms Page Table
            $cmspage->title = $data['title'];
            $cmspage->description = $data['description'];
            $cmspage->url = $data['url'];
            $cmspage->meta_title = $data['meta_title'];
            $cmspage->meta_description = $data['meta_description'];
            $cmspage->status = 1;
            $cmspage->save();

            return redirect('admin/cms-pages')->with('success_message', $message);
        }

        return view('admin.pages.add_edit_cmspage')->with(compact('cmspage', 'title', 'message'));
    }
}
