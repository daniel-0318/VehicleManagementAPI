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
      'email' => 'required|string|email|unique:users',
      'identificationNumber'=>'required|string',
      'identificationType'=>'required|in:CC,CE,RC',
      'lastname' => 'required|string|max:50',
      'name' => 'required|string|max:50',
      'password' => 'required|string|min:6',
      'phone'=>'required|string',
    ]);

    if($validator->fails()){
      return response()->json($validator->errors());
    }

    $user = User::create([
      'email' => $request->email,
      'identificationNumber' => $request->identificationNumber,
      'identificationType' => $request->identificationType,
      'lastname' => "$request->lastname",
      'name' => $request->name,
      'password' => Hash::make($request->password),
      'phone' => $request->phone,
    ]);

    $user->sendEmailVerificationNotification();

    return response()->json(['message' => 'Sucess'], 200);


  }

  public function show(){
    $user = Auth::user();
    return $user;
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
        'message' => 'user login',
        'status' => 'sucess',
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

  public function update(Request $request){
    $user = Auth::user();
    $user->update($request->all());
    return response()->json([
      'message' => 'user updated',
      'status' => 'success',
    ], 200);
  }
}
