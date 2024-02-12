<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['prefix'=>'v1', "middleware"=>'auth:sanctum'],function(){
    Route::apiResource("vehicles",VehicleController::class);
    Route::put('user/update', [AuthController::class, 'update']);
    Route::get('user/show', [AuthController::class, 'show']);
    Route::get('logout', [AuthController::class, 'logout']);
    
});
