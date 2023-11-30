<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Validator;

class VendorController extends Controller
{
    public function loginRegister(){
        return view('front.vendors.login_register');
    }

    public function vendorRegister(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;

            // validation Vendor
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:admins|unique:vendors',
                'mobile' => 'required|min:11|numeric|unique:admins|unique:vendors',
                'accept' => 'required',
            ];
            $customMessages = [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.unique' => 'Email must be Unique',
                'mobile.required' => 'Mobile is required',
                'mobile.unique' => 'Mobile must be Unique',
                'accept.required' => 'Please Accept T&C',
            ];

            // $this->validate($request, $rules);
            $validator = Validator::make($data, $rules, $customMessages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }

            DB::beginTransaction();

            // create Vendor Account

            // Insert the Vendor Details In vendor table
            $vendor = new Vendor;
            $vendor->name = $data['name'];
            $vendor->mobile = $data['mobile'];
            $vendor->email = $data['email'];
            $vendor->status = 0;
            // Set default Time zone for Dhaka
            date_default_timezone_set('asia/dhaka');
            $vendor->created_at = date("Y-m-d H:i:s");
            $vendor->updated_at = date("Y-m-d H:i:s");
            $vendor->save();

            $vendor_id = DB::getPdo()->lastInsertId();

            // Insert the Vendor Details In Admin table
            $admin = new Admin;
            $admin->name = $data['name'];
            $admin->type = 'vendor';
            $admin->vendor_id = $vendor_id;
            $admin->mobile = $data['mobile'];
            $admin->email = $data['email'];
            $admin->password = bcrypt($data['password']);
            $admin->status = 0;
            // Set default Time zone for Dhaka
            date_default_timezone_set('asia/dhaka');
            $admin->created_at = date("Y-m-d H:i:s");
            $admin->updated_at = date("Y-m-d H:i:s");
            $admin->save();

            // Send Confirmation Email
            $email = $data['email'];
            $messageData = [
                'email' => $data['email'],
                'name' => $data['name'],
                'code' => base64_encode($data['email']),
            ];
            Mail::send('emails.vendor_confirmation', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Confirm Your Vendor Account');
            });


            DB::commit();




            // Redirect back Vendor With Success Message
            $message = 'Thanks For Registering as Vendor. Please Confirm Your Email To Active Your Account.';
            return redirect()->back()->with('success_message', $message);

        }
    }

    public function vendorConfirm($email){
        // Decode Vendor Email
        // echo $email = base64_decode($email); die;
        $email = base64_decode($email);
        // Check Vendor Email exists
        $vendorCount = Vendor::where('email',$email)->count();
        if ($vendorCount>0) {
            // vendor Email is already active or not
            $vendorDetails = Vendor::where('email', $email)->first();
            if ($vendorDetails->confirm=='Yes') {
                $message = 'Your Vendor Account is Already Confirmed. You can Login.';
                return redirect('vendor/login-register')->with('error_message', $message);
            }else {
                // update Confirm Column to Yes Both admins and vendors tables to Active
                Admin::where('email',$email)->update(['confirm'=>'Yes']);
                Vendor::where('email',$email)->update(['confirm'=>'Yes']);

                // Send Register Email
                $messageData = [
                        'email' => $email,
                        'name' => $vendorDetails->name,
                        'mobile' => $vendorDetails->mobile,
                    ];
                Mail::send('emails.vendor_confirmed', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Your Vendor Account Confirmed');
                });

                // Redirect to Vendor Login/Register page with Success message
                $message = 'Your Vendor Email Account is Confirmed. You can Login and add your Personal, Business and Bank Details to Active Your Vendor Account to Add Products';
                return redirect('vendor/login-register')->with('success_message', $message);
            }
        }else {
            abort(404);
        }
    }
}
