<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CompleteRide extends Model
{
    static function getCompleteRide($id)
    {
        $query = "SELECT *, rides.id as ride_id  
                FROM rides
                INNER JOIN complete_rides
                ON rides.id = complete_rides.ride_id 
                INNER JOIN drivers
                ON rides.driver_id = drivers.id
                where rides.driver_id = '".$id."'
                ";
        $results = DB::select( DB::raw($query) );
        return $results;
    }
}
