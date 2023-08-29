<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Resources\CustomrResource;
use App\Http\Requests\CustomrRequest;
use App\Models\Customr;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordCustomr;
use Carbon\Carbon;

class CustomrController extends Controller
{
    public function __construct()

    {
        //  $this->middleware('auth', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);

        $this->middleware('auth:user_api', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);

        $this->middleware('auth:customrs_api', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);
    }

    public function login(Request $request){
        
        $validated = $request->validate([
            'phone' => 'required|numeric',
            'password' => 'required|string',
        ]);
         
        if($validated){
            $credentials =  ['phone'=>$request->get('phone'),'password'=>$request->get('password')];

            //  $user = User::where('phone',$request['phone'])->get();
            if(Auth::guard('web_customrs')->attempt($credentials)){
                $customr = Auth::guard('web_customrs')->user();
                // $customr = Customr::wherephone($request['phone'])->get();
                // return $user->createToken('ApiToken')->accessToken;
                return [
                    'status' => 'Customr Login Successfuly',
                    'code' => '200',
                    'data' => new CustomrResource($customr),
                    'authorization' => [
                        'token' => $customr->createToken('ApiToken')->accessToken,
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
    public function register(CustomrRequest $request){
    
      $customr =  $request->validated();
      
      if($customr){
      $customr['password'] = bcrypt($customr['password']);
      $customr = Customr::create($customr); 
      return [
        'status' => 'Customr Create Successfuly',
        'code' => '200',
        'data' => new CustomrResource($customr),
    ];
    }else{
        return [
            'status' => 'Error Register',
            'code' => '400',
        ];
    }

    }

   

public function forgetPassword(Request $request){

$email = $request->validate([
    'email' => 'email|required|exists:customrs,email',
]);


if($email){
    //  $user = User::whereemail($email)->first();
    $RCode = rand(100000,999999);
    Customr::Where('email', $request['email'])->update(['reset_code' => $RCode ,'code_created_at' => Carbon::now(), 'expiration_code' => Carbon::now()->addMinutes(60)]);
     $customr = Customr::whereemail($email)->first();
    Mail::to($customr->email)->queue(new ResetPasswordCustomr($customr));
    return [
        'status' => 'Email Reset Password will be Sent Successfuly',
        'code' => '200', 
        'data' => new CustomrResource($customr),        
    ];
}

}

public function resetPassword(Request $request)
{
 $request = $request->validate([
    'customr_id' =>'required|exists:customrs,id',
    'code' => 'required|exists:customrs,reset_code' ,
    'password'=> 'string|required|confirmed',
    'password_confirmation' =>'required|string',
]);
if($request){
    $customr =Customr::whereId($request['customr_id'])->whereResetCode($request['code'])->first();
    //  return $customr;
    if($customr){
        if($customr->expiration_code < Carbon::now()){
            return ([
                'status' => 'Expiration Code',
                'code' => 403,
                
            ]);
        }
        elseif(Hash::check($request['password'] , $customr->password)) {
            return ([
                'status' => 'this is old password Change it',
                'code' => 400,
                
            ]);
        }
      else{
        $customr->update([
            'password' => bcrypt($request['password']) ,
            'password_confirmation' => $request['password_confirmation'],
        ]);
        return ([
            'status' => 'Password Reset Successfly',
            'code' => 200,
            'data' => new CustomrResource($customr),
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
            'status' => 'Customer Logout Successfuly',
            'code' => '200',         
        ];
    }



    public function index()
    {
       $customr = Customr::all() ;
       return ([
        'status' => 'All Customrs',
        'code' => 200,
        'data' =>  CustomrResource::collection($customr),
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customr $customr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customr $customr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customr $customr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customr $customr)
    {
        //
    }
}
