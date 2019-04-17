<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverLocation extends Model
{
    public function driver()
    {
        return $this->hasOne('App\Driver','driver_id');
    }

    // Once Relationship defined I can access $ride = DriverLocation::fine(1)->ride();
    // The above line will return A ride related to driverlocation id 1
}
