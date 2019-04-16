<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    public static function passenger_with_ride_req_allowed()
    {
        // Passengers
        $passengers = Passenger::leftJoin('ride_requests',function ($join){
           $join->on('passengers.id','=','ride_requests.passenger_id');
        })->select([
            'ride_requests.passenger_id',
            'ride_requests.status',
            'passengers.id',
            'passengers.fname',
            'passengers.lname'
        ])->get();
//        // Passengers requested ride but the ride status is complete
//        $passenger_ride_processed = RideRequest::where('status','=','Processed')->
//        orWhere(function($where){
//            $where->where('status','Cancelled');
//        })->get();
//        if($passenger_ride_processed)
//        {
//            foreach ($passenger_ride_processed as $item)
//            {
//
//            }
//        }
//        echo"<pre>"; print_r($passengers->merge($passenger_ride_processed)); exit;
        return $passengers;
    }
}
