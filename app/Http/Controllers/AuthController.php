<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function __construct()

        {
            //  $this->middleware('auth', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);

            $this->middleware('auth:user_api', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);

            // $this->middleware('auth:customrs_api', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);
        }

        public function login(Request $request){
            
            $validated = $request->validate([
                'phone' => 'required|numeric',
                'password' => 'required|string',
            ]);
             
            if($validated){
                $credentials =  ['phone'=>$request->get('phone'),'password'=>$request->get('password')];

                //  $user = User::where('phone',$request['phone'])->get();
                if(Auth::attempt($credentials)){
                    $user = Auth::user();
                    // return $user->createToken('ApiToken')->accessToken;
                    return [
                        'status' => 'User Login Successfuly',
                        'code' => '200',
                        'data' => new UserResource($user),
                        'authorization' => [
                            'token' => $user->createToken('ApiToken')->accessToken,
                            'type' => 'bearer',
                        ]
                    ];
                }else{
                    return [
                        'status' => 'User Falid Credentials',
                        'code' => '401',
                    ];            
                }
            }
            
        }
        public function register(UserRequest $request){
        
          $user =  $request->validated();
          $user['password'] = bcrypt($user['password']);
        //   return $user ;
          $user = User::create($user); 
          return [
            'status' => 'User Create Successfuly',
            'code' => '200',
            'data' => new UserResource($user),
        ];
        }


       

public function forgetPassword(Request $request){

    $email = $request->validate([
        'email' => 'email|required|exists:users,email',
    ]);


    if($email){
        //  $user = User::whereemail($email)->first();
        $RCode = rand(100000,999999);
         User::Where('email', $request['email'])->update(['reset_code' => $RCode ,'code_created_at' => Carbon::now(), 'expiration_code' => Carbon::now()->addMinutes(60)]);
         $user = User::whereemail($email)->first();
        Mail::to($user->email)->queue(new ResetPassword($user));
        return [
            'status' => 'Email Reset Password will be Sent Successfuly',
            'code' => '200', 
            'data' => new UserResource($user),        
        ];
    }

}
 
public function resetPassword(Request $request)
{
     $request = $request->validate([
        'user_id' =>'required|exists:users,id',
        'code' => 'required|exists:users,reset_code' ,
        'password'=> 'string|required|confirmed',
        'password_confirmation' =>'required|string',
    ]);
    if($request){
        $user =User::whereId($request['user_id'])->whereResetCode($request['code'])->first();
        // return $user;
        if($user){
            if($user->expiration_code < Carbon::now()){
                return ([
                    'status' => 'Expiration Code',
                    'code' => 403,
                    
                ]);
            }
            elseif(Hash::check($request['password'] , $user->password)) {
                return ([
                    'status' => 'this is old password Change it',
                    'code' => 400,
                    
                ]);
            }
          else{
            $user->update([
                'password' => bcrypt($request['password']) ,
                'password_confirmation' => $request['password_confirmation'],
            ]);
            return ([
                'status' => 'Password Reset Successfly',
                'code' => 200,
                'data' => new UserResource($user),
            ]);
        }
       
        // return [
        //     'message' => ''
        // ];
    }else{
        return ([
            'status' => 'invalid code.',
            'code' => 500,
            
        ]);
    }

  }

}

 public function logout(Request $request){
           
            Auth::user()->token()->revoke();
            return [
                'status' => 'User Logout Successfuly',
                'code' => '200',         
            ];
        }
  

}
