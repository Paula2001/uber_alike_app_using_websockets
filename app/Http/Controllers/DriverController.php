<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class DriverController extends Controller
{
    private $driver;
    public function __construct()
    {
        $this->middleware('auth:driver')->except(['showRegisterForm','showLoginForm','store','login','jsonMonopolists']);
        $this->driver = new Driver();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        return view('driver.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        Driver::create(['name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'vehicle_type' => $request->vehicle_type,
                        'password' => Hash::make($request->password),
                        ]);
        if (Auth::guard('driver')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/driver');
        }

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
    public function ShowLoginForm(){
        if(auth()->guard('driver')->check()){
            return redirect()->intended('/driver');
        }
        return view('driver.authDrivers.login');
    }
    public function login(Request $request){
        if (Auth::guard('driver')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {

            return redirect()->intended('/driver');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'invalid credentials',
            ]);
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone'=>['numeric','required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    public function showRegisterForm(){
        if(auth()->guard('driver')->check()){
            return redirect()->intended('/driver');
        }
        return view('driver.authDrivers.register');
    }
    public function getMonopolists($duration_type){
        return $this->driver->getDriversDependOnDuration($duration_type);
    }

    public function jsonMonopolists($durations_type){
        $data = $this->getMonopolists($durations_type);
        return DataTables::of($data)->make(true);
    }

}
