<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    public static function passenger_ride_processed()
    {
        $passenger_not_in_any_ride = Passenger::leftJoin('ride_requests',function ($join){
           $join->on('passengers.id','=','ride_requests.passenger_id')->where('ride_requests.status','=','Processed');
        })->select([
            'ride_requests.passenger_id',
            'passengers.id',
            'passengers.fname',
            'passengers.lname'
        ])->get();
        return $passenger_not_in_any_ride;
    }
}
