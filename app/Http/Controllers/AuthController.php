<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{

  public function register(Request $request){

    $validator = Validator::make($request->all(),[
      'name' => 'required|string|max:50',
      'lastName' => 'required|string|max:50',
      'email' => 'required|string|email|unique:users',
      'password' => 'required|string|min:6',
    ]);

    if($validator->fails()){
      return response()->json($validator->errors());
    }

    $user = User::create([
      'name' => $request->name,
      'lastName' => "$request->lastName",
      'email' => $request->email,
      'phone' => $request->phone,
      'identificationType' => $request->identificationType,
      'identificationNumber' => $request->identificationNumber,
      'password' => Hash::make($request->password),
    ]);

    $user->sendEmailVerificationNotification();

    return response()->json(['message' => 'Sucess'], 200);


  }

  public function validateLogin(Request $request) {
    return $request->validate([
      "email" => "required|email",
      "password" => "required",
    ]);
  }


  public function login(Request $request){
    $this->validateLogin($request);

    if (Auth::attempt($request->only("email", "password"))) {
      return response()->json([
        'token' => $request->user()->createToken('auth_token')->plainTextToken,
        'message' => 'Sucess',
        'status' => 'fail',
      ], 200);
    }

    return response()->json([
      'message' => 'Unauthorized',
      'status' => 'success',
    ], 401);
  }

  public function logout(){
    Auth::logout();
    return response()->json(['message'=> 'Sucess'],200);
  }
}
