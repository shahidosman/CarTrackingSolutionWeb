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

    // Once Relationship defined I can access $drivercar = Driver::fine(1)->drivercar();
    // The above line will return A drivecar related to driver whose id = 1
}
