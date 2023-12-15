<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
}
