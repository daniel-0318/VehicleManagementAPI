<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\VehicleCollection;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
  public function index(Request $request){
    $user = Auth::user();
    $search = $request->get('search');
    $user_id = $user->id;

    // Si no se recibe un filtro, devolver todos los vehículos
    if (!$search) {
      $vehicles = Vehicle::where('user_id', $user->id)->latest()->paginate();
      return new VehicleCollection($vehicles);
    }
    $vehicles = Vehicle::where('user_id', $user_id);

    $vehicles->where(function ($query) use ($search ) {
      $query->orWhere('plate', 'like', '%'.$search.'%')
            ->orWhere('model_year', 'like' ,'%'.$search.'%')
            ->orWhere('configuration', 'like', '%'.$search.'%')
            ->orWhere('body_type', 'like', '%'.$search.'%');
    })->get();

    $vehicles = new VehicleCollection($vehicles->latest()->paginate());

    return $vehicles;
  }
  
  public function show($id){
    return Vehicle::findOrFail($id);
  }

  public function store(Request $request){
    $rules = [
      "plate" => "required|string|min:4",
      "model_year" => "required|numeric",
      "configuration" => "required|in:CA,2,3,4,2S2,2S3,2S4,3S3",
      "body_type" => "required|in:Furgón,Volco,Tanque,Estacas,Porta Contenedor",
      "image" => "string",
    ];

    $this->validate($request, $rules);
    $user = Auth::user();

    $field['plate'] = $request->plate;
    $field['model_year'] = $request->model_year;
    $field['configuration'] = $request->configuration;
    $field['body_type'] = $request->body_type;
    $field['image'] = $request->image_path;
    $field['user_id'] = $user->id;
    $vehicle = Vehicle::create($field);

    return response()->json([
      'data' => $vehicle,
      'message' => 'Vehicle created successfully',
      'status' => 'success',
    ], 201);

  }

  public function destroy($id){

    $vehicle = Vehicle::find($id);

    if (!$vehicle) {
      return response()->json([
        'error' => 'Vehicle no found',
        'status' => 'fail',
      ], 404);
    }
    $vehicle->delete();

    return response()->json([
      'message' => 'Vehicle deleted successfully',
      'status' => 'success',
    ], 200);
  }

}
