<?php

namespace App\Http\Controllers\API;

use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Libraries\DistanceCalculator\DistanceCalculator as Distance;
use Illuminate\Support\Facades\DB;
use Validator;


class TripController extends Controller
{
    private $successStatus = 200;
    private $trip;
    public function __construct()
    {
        $this->trip = new Trip();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['distance'] = round(Distance::GreatCircleDistance(
                (real)$request->start_lat,
                (real)$request->start_long,
                (real)$request->target_lat,
                (real)$request->target_long),PHP_ROUND_HALF_DOWN);

        if((string)$input['distance'] == 'NAN'){
            return response()->json(['error'=>"The long or The lat is not correct"], 401);
        }
        $input['fair'] = Distance::calculateFair($input['distance']);
        $input['trip_status'] = 'binding';
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'start_long' => 'required',
            'start_lat' => 'required',
            'target_long' => 'required',
            'target_lat' => 'required',
            'fair' => 'required',
            'distance'=> 'required',
            'trip_status' => 'required|in:binding,on_road,finished'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        Trip::create($input);
        $success['status'] =  'trip saved';
        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id\
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getNearestTrips(Request $request ){
        $driver_lat = $request->lat;
        $driver_long=$request->long;
        $longest_distance = (float) $request->longest_distance ;
          return $this->trip
              ->where( DB::raw("ROUND( (6371*ACOS(COS(RADIANS(start_lat))) * (COS(RADIANS($driver_lat))) * (COS(RADIANS($driver_long) - RADIANS(start_long))) + ((SIN(RADIANS(start_lat))) * (SIN(RADIANS($driver_lat)))))/1000)")  ,'<=' ,$longest_distance)->get();
    }
    public function pickTrip($id){
        $success['message'] ='Trip updated successfully' ;
        $user = Auth::guard('api_driver')->user();
        $bool = Trip::where('id', $id)
            ->update(['driver_id' => $user->id]);
        if($bool){
            return response()->json(['success' => $success], $this->successStatus);
        }else{
            return response()->json(['error' => ['message' => 'invalid request ']],401);
        }

    }
   
}
