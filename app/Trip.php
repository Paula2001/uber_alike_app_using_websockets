<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['user_id','driver_id' , 'start_long', 'start_lat', 'target_long', 'target_lat', 'fair', 'trip_status','distance'];

}
