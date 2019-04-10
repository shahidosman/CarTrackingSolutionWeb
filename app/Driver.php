<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function drivercar()
    {
        return $this->hasOne('App\DriverCar','driver_id');
    }

    // Once Relationship defined I can access $drivercar = Driver::fine(1)->drivercar();
    // The above line will return A drivecar related to driver whose id = 1
}
