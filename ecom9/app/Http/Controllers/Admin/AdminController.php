<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Vendor;
use App\Models\VendorsBankDetail;
use App\Models\VendorsBusinessDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Image;
use Session;


class AdminController extends Controller
{
    public function dashboard()
    {
        //sidebar selection
        Session::put('page', 'dashboard');

        return view("admin.dashboard");
    }

    public function updateAdminPassword(Request $request)
    {
        //sidebar selection
        Session::put('page', 'update_admin_password');

        // echo '<pre>';print_r(Auth::guard('admin')->user()); die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            // check if current password interted by admin is correct
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                // check if new password is match with confirm password
                if ($data['confirm_password'] == $data['new_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Password has been updated Successfully!');
                } else {
                    return redirect()->back()->with('error_message', 'Your New password is not matching with confirm Password!');
                }
            } else {
                return redirect()->back()->with('error_message', 'Your current password is Incurrect!');
            }
        }


        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toarray();
        return view("admin.settings.update_admin_password")->with(compact('adminDetails'));
    }

    public function updateAdminDetails(Request $request)
    {
        //sidebar selection
        Session::put('page', 'update_admin_details');

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'admin_mobile' => 'required|numeric',
            ];
            $this->validate($request, $rules);

            // Upload Admin Photo
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    // # Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // # Generate Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'admin/images/photos/' . $imageName;
                    // # Upload Image
                    Image::make($image_tmp)->save($imagePath);
                }
            } else if (!empty($data['current_admin_image'])) {
                $imageName = $data['current_admin_image'];
            } else {
                $imageName = '';
            }


            // Update admin details
            Admin::where('id', Auth::guard('admin')->user()->id)->update(['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $imageName]);
            return redirect()->back()->with('success_message', 'Details has been updated Successfully!');
        }
        return view("admin.settings.update_admin_details");
    }

    public function updateVendorDetails($slug, Request $request)
    {
        if ($slug == 'personal') {

            //sidebar selection
            Session::put('page', 'update_personal_details');

            if ($request->isMethod('post')) {
                $data = $request->all();
                // echo '<pre>'; print_r($data);die;

                $rules = [
                    'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                    'vendor_mobile' => 'required|numeric',
                    'vendor_address' => 'required',
                    'vendor_city' => 'required',
                    'vendor_state' => 'required',
                    'vendor_country' => 'required',
                    'vendor_pincode' => 'required',
                ];
                $this->validate($request, $rules);

                // Upload Admin Photo
                if ($request->hasFile('vendor_image')) {
                    $image_tmp = $request->file('vendor_image');
                    if ($image_tmp->isValid()) {
                        // # Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        // # Generate Image Name
                        $imageName = rand(111, 99999) . '.' . $extension;
                        $imagePath = 'admin/images/photos/' . $imageName;
                        // # Upload Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                } else if (!empty($data['current_vendor_image'])) {
                    $imageName = $data['current_vendor_image'];
                } else {
                    $imageName = '';
                }


                // Update in admins table
                Admin::where('id', Auth::guard('admin')->user()->id)->update(['name' => $data['vendor_name'], 'mobile' => $data['vendor_mobile'], 'image' => $imageName]);
                // // Update in vendors table
                Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->update(['name' => $data['vendor_name'], 'mobile' => $data['vendor_mobile'], 'address' => $data['vendor_address'], 'city' => $data['vendor_city'], 'state' => $data['vendor_state'], 'country' => $data['vendor_country'], 'pincode' => $data['vendor_pincode'],]);
                return redirect()->back()->with('success_message', 'Details has been updated Successfully!');
            }
            // $vendorDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toarray();
            $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toarray();
            // echo '<pre>';print_r($vendorDetails); die;
        } elseif ($slug == 'business') {

            //sidebar selection
            Session::put('page', 'update_business_details');

            if ($request->isMethod('post')) {
                $data = $request->all();
                // echo '<pre>'; print_r($data);die;

                $rules = [
                    'shop_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                    'shop_address' => 'required',
                    'shop_city' => 'required',
                    'shop_state' => 'required',
                    'shop_country' => 'required',
                    'shop_pincode' => 'required',
                    'shop_mobile' => 'required|numeric',
                    'shop_website' => 'required',
                    'shop_email' => 'required',
                    'address_proof' => 'required',
                    // 'address_proof_image' => 'required',
                    'business_license_number' => 'required',
                    'gst_number' => 'required',
                    'pan_number' => 'required',
                ];
                $this->validate($request, $rules);

                // Upload Admin Photo
                if ($request->hasFile('address_proof_image')) {
                    $image_tmp = $request->file('address_proof_image');
                    if ($image_tmp->isValid()) {
                        // # Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        // # Generate Image Name
                        $imageName = rand(111, 99999) . '.' . $extension;
                        $imagePath = 'admin/images/proofs/' . $imageName;
                        // # Upload Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                } else if (!empty($data['current_address_proof_image'])) {
                    $imageName = $data['current_address_proof_image'];
                } else {
                    $imageName = '';
                }

                // Insert or Update in vendors Business Table table
                $vendorCount = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
                if ($vendorCount>0) {
                    // // Update in vendors Business Table table
                    VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update(['shop_name' => $data['shop_name'], 'shop_address' => $data['shop_address'], 'shop_city' => $data['shop_city'], 'shop_state' => $data['shop_state'], 'shop_country' => $data['shop_country'], 'shop_pincode' => $data['shop_pincode'], 'shop_mobile' => $data['shop_mobile'], 'shop_website' => $data['shop_website'], 'shop_email' => $data['shop_email'], 'address_proof' => $data['address_proof'], 'address_proof_image' => $imageName, 'business_license_number' => $data['business_license_number'], 'gst_number' => $data['gst_number'], 'pan_number' => $data['pan_number'],]);
                } else {
                    // // Insert in vendors Business Table table
                    VendorsBusinessDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'shop_name' => $data['shop_name'], 'shop_address' => $data['shop_address'], 'shop_city' => $data['shop_city'], 'shop_state' => $data['shop_state'], 'shop_country' => $data['shop_country'], 'shop_pincode' => $data['shop_pincode'], 'shop_mobile' => $data['shop_mobile'], 'shop_website' => $data['shop_website'], 'shop_email' => $data['shop_email'], 'address_proof' => $data['address_proof'], 'address_proof_image' => $imageName, 'business_license_number' => $data['business_license_number'], 'gst_number' => $data['gst_number'], 'pan_number' => $data['pan_number']]);
                }
                // // Update in vendors Business Table table
                // VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update(['shop_name' => $data['shop_name'], 'shop_address' => $data['shop_address'], 'shop_city' => $data['shop_city'], 'shop_state' => $data['shop_state'], 'shop_country' => $data['shop_country'], 'shop_pincode' => $data['shop_pincode'], 'shop_mobile' => $data['shop_mobile'], 'shop_website' => $data['shop_website'], 'shop_email' => $data['shop_email'], 'address_proof' => $data['address_proof'], 'address_proof_image' => $imageName, 'business_license_number' => $data['business_license_number'], 'gst_number' => $data['gst_number'], 'pan_number' => $data['pan_number'],]);
                return redirect()->back()->with('success_message', 'Details has been updated Successfully!');
            }

            $vendorCount = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
            if ($vendorCount > 0) {
                $vendorDetails = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toarray();
            } else {
                $vendorDetails = array();
            }
            // $vendorDetails = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toarray();
            // echo '<pre>';print_r($vendorDetails); die;



        } elseif ($slug == 'bank') {

            //sidebar selection
            Session::put('page', 'update_bank_details');

            if ($request->isMethod('post')) {
                $data = $request->all();
                // echo '<pre>'; print_r($data);die;

                $rules = [
                    'account_holder_name' => 'required',
                    'bank_name' => 'required',
                    'account_number' => 'required',
                    'bank_ifsc_code' => 'required',
                ];
                $this->validate($request, $rules);

                // Insert or Update Bank Data
                $vendorCount = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
                if ($vendorCount > 0) {
                    // // Update in vendors Bank Details Table table
                    VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name' => $data['account_holder_name'], 'bank_name' => $data['bank_name'], 'account_number' => $data['account_number'], 'bank_ifsc_code' => $data['bank_ifsc_code']]);
                } else {
                    // // Insert in vendors Bank Details Table table
                    VendorsBankDetail::insert(['vendor_id' => Auth::guard('admin')->user()->vendor_id,'account_holder_name' => $data['account_holder_name'], 'bank_name' => $data['bank_name'], 'account_number' => $data['account_number'], 'bank_ifsc_code' => $data['bank_ifsc_code']]);
                }

                // // Update in vendors Bank Table
                // VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name' => $data['account_holder_name'], 'bank_name' => $data['bank_name'], 'account_number' => $data['account_number'], 'bank_ifsc_code' => $data['bank_ifsc_code'],]);
                return redirect()->back()->with('success_message', 'Details has been updated Successfully!');
            }

            $vendorCount = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
            if ($vendorCount > 0) {
                $vendorDetails = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toarray();
            } else {
                $vendorDetails = array();
            }

            // $vendorDetails = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toarray();
            // echo '<pre>';print_r($vendorDetails); die;
        }

        $countries = Country::where('status', 1)->get()->toArray();

        return view("admin.settings.update_vendor_details")->with(compact('slug', 'vendorDetails', 'countries'));
    }

    public function checkAdminPassword(Request $request)
    {
        $data = $request->all();
        // echo '<pre>';print_r($data); die;
        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }

    public function login(Request $request)
    {
        // echo $pasword = Hash::make('123456789'); die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data);
            // die;

            // validation
            // $validated = $request->validate([
            //     'email' => 'required|email|max:255',
            //     'password' => 'required',
            // ]);
            // or
            // validation with custome rules
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            $customMessages = [
                // add custome message here
                'email.required' => 'Email Address is required',
                'email.email' => 'Valid Email Address is required',
                'password.required' => 'Password is required',
            ];
            $this->validate($request, $rules, $customMessages);


            // if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1,])) {
            //     return redirect('admin/dashboard');
            // } else {
            //     return redirect()->back()->with('error_message', 'Invalid email or password');
            // }

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                if (Auth::guard('admin')->user()->type == "vendor" && Auth::guard('admin')->user()->confirm == "No") {
                    return redirect()->back()->with('error_message', 'Please Confirm Your Vendor Email To Activate Your Account');
                } elseif (Auth::guard('admin')->user()->type != "vendor" && Auth::guard('admin')->user()->status == "0") {
                    return redirect()->back()->with('error_message', 'Your Admin Account Is Not Active');
                } else {
                    return redirect('admin/dashboard');
                }
            } else {
                return redirect()->back()->with('error_message', 'Invalid email or password');
            }
        }
        return view("admin.login");
    }

    public function admins($type = null)
    {
        $admins = Admin::query();
        if (!empty($type)) {
            $admins = $admins->where('type', $type);
            $title = ucfirst($type) . "s";

            //sidebar selection
            Session::put('page', 'view_' . strtolower($title));
        } else {
            $title = "All Admins/Subadmin/Vendors";

            //sidebar selection
            Session::put('page', 'view_all');
        }

        $admins = $admins->get()->toArray();
        // dd($admins);
        return view("admin.admins.admins")->with(compact('admins', 'title'));
    }

    public function viewVendorDetails($id)
    {
        // $vendorDetails = Admin::where('id',$id)->first();
        $vendorDetails = Admin::with('vendorPersonal', 'vendorBusiness', 'vendorBank')->where('id', $id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails), true);
        // dd($vendorDetails);
        return view("admin.admins.view_vendor_details")->with(compact('vendorDetails'));
    }

    public function updateAdminStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Admin::where('id', $data['admin_id'])->update(['status' => $status]);

            // send Vendor Approval Message
            $adminDetails = Admin::where('id', $data['admin_id'])->first()->toArray();
            // $adminType = Auth::guard('admin')->user()->type;
            if ($adminDetails['type'] == 'vendor' && $status == 1) {

                //update vendor Status
                Vendor::where('id', $adminDetails['vendor_id'])->update(['status' => $status]);

                // Send Confirmation Email
                $email = $adminDetails['email'];
                $messageData = [
                    'email' => $adminDetails['email'],
                    'name' => $adminDetails['name'],
                    'mobile' => $adminDetails['mobile'],
                ];
                Mail::send('emails.vendor_approved', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Vendor Account is Approved');
                });
            }

            return response()->json(['status' => $status, 'admin_id' => $data['admin_id']]);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
