<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login_register');
    }

    public function userRegister(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'mobile' => 'required|numeric|digits:11',
                'email' => 'required|email|max:150|unique:users',
                'password' => 'required|min:6',
                'accept' => 'required'
            ], [
                'accept.required' => 'Please accept our Term and Conditions'
            ]);

            if ($validator->passes()) {
                // Register The User
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                /* Activate the user only when User Confirming his email Account --> */

                $email=$data['email'];
                $messageData = ['name'=> $data['name'], 'mobile' => $data['mobile'], 'email' => $data['email'], 'code' => base64_encode($data['email'])];
                Mail::send('emails.confirmation', $messageData,function($message)use($email){
                    $message->to($email)->subject('Confirm your Zet Digital Account');
                });

                // Redirect back user with success Message
                $redirectTo = url('user/login-register');
                return response()->json(['type' => 'success', 'url' => $redirectTo, 'message' => 'Please Confirm your Email to active Account']);


                /* Simply Register the user Without Confirming his email Account --> */

                // Send Register Email
                // $email=$data['email'];
                // $messageData = ['name'=> $data['name'], 'mobile' => $data['mobile'], 'email' => $data['email']];
                // Mail::send('emails.register', $messageData,function($message)use($email){
                //     $message->to($email)->subject('welcome to Zet Digital');
                // });

                // if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                //     $redirectTo = url('cart');
                //     // Update User Cart with User Id
                //     if (!empty(Session::get('session_id'))) {
                //         $user_id = Auth::user()->id;
                //         $session_id = Session::get('session_id');
                //         Cart::where('session_id', $session_id)->update(['user_id' => $user_id]);
                //     }
                //     return response()->json(['type' => 'success', 'url' => $redirectTo]);
                // }


            } else {
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
        }
    }

    public function userLogin(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;

            // validation
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required|min:6'
            ]);

            if ($validator->passes()) {
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

                    if (Auth::user()->status == 0) {
                        Auth::logout();
                        return response()->json(['type' => 'incorrect', 'message' => 'Your Account is not Activated! Please Confirm yor Email.']);
                    }

                    // Update User Cart with User Id
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id' => $user_id]);
                    }

                    $redirectTo = url('cart');
                    return response()->json(['type' => 'success', 'url' => $redirectTo]);
                } else {
                    return response()->json(['type' => 'incorrect', 'message' => 'Incorrect Email or Password!']);
                }
            } else {
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
        }
    }

    public function userLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function confirmAccount($code)
    {
        $email = base64_decode($code);
        $userCount = User::where('email',$email)->count();
        if ($userCount>0) {
            $userDetails = User::where('email',$email)->first();
            if ($userDetails->status==1) {
                // redirect the User Login/register page with error message
                return redirect('user/login-register')->with('error_message','Your Account is already Activated. You can login Now');
            }else {
                User::where('email',$email)->update(['status'=>1]);

                // Send Register Welcome Email
                $messageData = ['name'=> $userDetails->name, 'mobile' => $userDetails->mobile, 'email' => $email];
                Mail::send('emails.register', $messageData,function($message)use($email){
                    $message->to($email)->subject('welcome to Zet Digital');
                });

                // redirect the User Login/register page with Success message
                return redirect('user/login-register')->with('success_message', 'Your Account is Activated. You can login Now');
            }
        }else {
            abort(404);
        }
    }
}
