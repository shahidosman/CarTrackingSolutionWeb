<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RideRequest extends Model
{
    public function ride()
    {
        return $this->hasOne('App\Ride','request_id');
    }

    // Once Relationship defined I can access $ride = RideRequest::fine(1)->ride();
    // The above line will return A ride related to riderequest id 1
}
