<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\DB;
class DriverController extends Controller
{
    public $successStatus = 200;
    public $driver ;
    public function __construct()
    {
        $this->driver = new Driver();
    }

    public function login(){
        if(Auth::guard('driver')->attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::guard('driver')->user();
            $success['token'] =  $user->createToken('driver_app')-> accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'phone' => 'required',
            'vehicle_type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user = Driver::create($input);
        $success['token'] =  $user->createToken('driver_app')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function details()
    {
        $user = Auth::guard('api_driver')->user();
        return response()->json(['success' => $user], $this->successStatus);
    }
    public function makeATrip(){
        $user = Auth::guard('api_driver')->user();
        $this->driver->where('id',$user->id)->update(['trip_count' => DB::Raw('trip_count + 1')]);
        return response()->json(['success' => "new trip added successfully"], $this->successStatus);
    }
    public function getMonopolists($duration_type = 'monthly'){
        return response()->json(['success' => $this->driver->getDriversDependOnDuration($duration_type)], $this->successStatus);
    }


}
