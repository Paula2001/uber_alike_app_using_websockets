<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Driver extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $guard = 'driver';
    protected $fillable = ['name','email','password','vehicle_type','phone'] ;
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getDriversDependOnDuration($duration_type = 'monthly'){
        $y = Date('Y');
        $cu_month = Date('m');
        $from = "$y-".(($duration_type === 'yearly')?$cu_month:'1')."-1";
        $to = "$y-".(($duration_type === 'yearly')?$cu_month:'12')."-31";
        $total_trips = Driver::select('trip_count')->sum('trip_count');
        $result = Driver::where(DB::Raw("(trip_count / $total_trips ) * 100" ) ,'>', 10);
        return ($duration_type === 'all_time')?
            $result->get()
            :
            $result->whereBetween('created_at', [$from.' 00:00:00',$to.' 23:59:59'])->get();
    }
}
