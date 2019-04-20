<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Driver extends Model implements JWTSubject
{

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function drivercar()
    {
        return $this->hasOne('App\DriverCar','driver_id');
    }

    public static function driver_ready_for_ride()
    {
        // Return a list of drivers ready for ride
        $drivers = Driver::leftJoin('rides',function ($join){
            $join->on('drivers.id','=','rides.driver_id');
        })->select([
            'drivers.id',
            'drivers.fname',
            'drivers.lname',
            'rides.is_active',
        ])->get();
        return $drivers;
    }

    // Once Relationship defined I can access $drivercar = Driver::fine(1)->drivercar();
    // The above line will return A drivecar related to driver whose id = 1
}
