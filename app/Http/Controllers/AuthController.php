<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        public function login(Request $request){
            
            $validated = $request->validate([
                'phone' => 'required|numeric',
                'password' => 'required|string',
            ]);
             
            if($validated){
                $credentials =  ['phone'=>$request->get('phone'),'password'=>$request->get('password')];

                 $user = User::where('phone',$request['phone'])->get();
                if(Auth::attempt($credentials)){
                    return [
                        'status' => 'User Login Successfuly',
                        'code' => '200',
                        'data' => new UserResource($user),
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




    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
