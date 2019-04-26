<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Driver;
use App\Passenger;
class AdminDashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $record = Passenger::passenger_rides();
        $drivers = count(Driver::all());
        $passengers = count(Passenger::all());
        $driver_ready_for_ride = 0;
        $driver_data = Driver::driver_ready_for_ride();
        foreach ($driver_data as $key=>$driver)
        {
            if($driver->is_active == null || $driver->is_active == false)
            {
                $driver_ready_for_ride ++;
            }
        }
        $driver_not_online = $drivers - $driver_ready_for_ride;
        return view('admin.dashboard',compact('record','drivers','driver_ready_for_ride','passengers','driver_not_online'));
    }
}
