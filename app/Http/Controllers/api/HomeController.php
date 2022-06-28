<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfileModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;

use Illuminate\Support\Facades\Validator;

class HomeController extends EmailController
{
    public function index(Request $req)
    {
        $data = User::get();
        dd($data);
    }
    public function register(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8',
        // ]);

        // $user = User::create([
        //     'name' => $validatedData['name'],
        //     'email' => $validatedData['email'],
        //     'password' => Hash::make($validatedData['password']),
        // ]);

        // $token = $user->createToken('auth_token')->plainTextToken;

        // return response()->json([
        //     'access_token' => $token,
        //     'token_type' => 'Bearer',
        // ]);
        
        //Mz
        $user = User::where('email', $request->email)->first();
		
		if($user)
		{
		   return response()->json([
               'message' => 'Email already exists',
            ], 401); 
		}
        $rules = array(
			'username' => ['required'],
            'email' => ['required','email', 'unique:users'],
            'password' => ['required'],
            'country_id' => ['required'],
		);
		$validator = Validator::make($request->all(), $rules);
		
		if ($validator->fails()) {
		    return response()->json(['errors'=>$validator->errors()],422);
		}
		//Mz
		
		
        // $this->validate($request, [
        //     'username' => ['required'],
        //     'email' => ['required', 'unique:users'],
        //     'password' => ['required'],
        //     // 'user_role' => ['required'],
        //     'country_id' => ['required'],
        // ]);
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->user_role = 0;
        if($user->save())
        {
       
        $profile = new ProfileModel();
        $profile->user_id = $user->id;
        $profile->full_name = $user->username;
        $profile->country_id = $request->country_id;
        $profile->phone = $request->phone;
        // $profile->country = $req->country;
        $profile->save();
      
        //mz --- mail shoot stopped bz (test-links stop)
        
        // //to shoot an email
        // $this->verifyEmail($user->id);
        return response()->json([
            'message' => 'Registered Successfully'
         ],200);
        }
        else
        {
           return response()->json([
            'message' => 'Error'
         ],419); 
        }
        
        //return back()->with('success','Account created successfully!');
    }
    public function login(Request $request)
    {
        //Mz
        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
		);
	
		$validator = Validator::make($request->all(), $rules);
		
		if ($validator->fails()) {
		    return response()->json(['errors'=>$validator->errors()],422);
		}
		//Mz
	    	
		$user = User::where('email', $request->email)->first();
		
		if(!$user)
		{
		   return response()->json([
                'message' => 'Invalid Email'
            ], 401); 
		}
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid password'
            ], 401);
        }

    
        if($user->status==1)
        {
           $token = $user->createToken('auth_token')->plainTextToken;
           $role;
            if($user->user_role==0)
            {
                $user->role='tourist';
            }
            else if($user->user_role==1)
            {
                $user->role='guide';
            }
            else
            {
               $user->role='admin'; 
            }
            
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'data'=>$user
            ]); 
        }
        else
        {
            return response()->json([
                'message' => 'Email not verfied'
            ],401);
        }
        
    }
    public function loginRequired()
    {
        if(!auth()->user()){
                return response()->json([
                'message' => 'Login Required'
             ],401 );
        }
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();

            return response()->json([
            'message' => 'Tokens Revoked'
         ],200);
    }
}