<?php

namespace App\Http\Controllers\Admin;

use App\Driver;
use App\DriverLocation;
use App\Ride;
use App\RideRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageRideController extends Controller
{
    public function assign_driver()
    {
        $ride_requests = RideRequest::where('status','=','New')->get();
        return view('admin.rides.index',compact('ride_requests','record'));
    }

    public function driver_for_ride($id)
    {
        $ride_request = RideRequest::find($id);
        // Left Join between drivers and rides:
        $drivers = Driver::driver_ready_for_ride();
        $result = [];
        foreach ($drivers as $key=>$driver)
        {
            if($driver->is_active==null || $driver->is_active==false)
            {
                $driver_curr_loc = DriverLocation::where('driver_id','=',$driver->id)
                    ->orderBy('created_at','desc')->first();
                if($driver_curr_loc!=null)
                {
                    $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$driver_curr_loc->latitude.','.$driver_curr_loc->longitude.'&sensor=false&key='.env('GOOGLE_MAP'));
                    $output = json_decode($geocodeFromLatLong);
                    $status = $output->status;
                    $address = ($status=="OK")?$output->results[0]->formatted_address:'';
                    $distance_time = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$driver_curr_loc->latitude.','.$driver_curr_loc->longitude.'&destinations='.$driver_curr_loc->latitude.','.$driver_curr_loc->longitude.'&key='.env('GOOGLE_MAP'));
                    $data = json_decode($distance_time);
                    $code = $data->status;
                    $distance = ($code=="OK")?$data->rows[0]->elements[0]->distance->text:'';
                    $duration = ($code=="OK")?$data->rows[0]->elements[0]->duration->text:'';
                    $result[($key)] = array(
                        'driver_id'=>$driver->id,
                        'driver_name'=>$driver->fname. " " .$driver->lname,
                        'curr_loc_address'=>$address,
                        'curr_loc_latitude'=>$driver_curr_loc->latitude,
                        'curr_loc_longitude'=>$driver_curr_loc->longitude,
                        'request_id'=>$ride_request->id,
                        'pick_loc_address'=>$ride_request->pick_loc_address,
                        'pick_loc_lat'=>$ride_request->pick_loc_lat,
                        'pick_loc_long'=>$ride_request->pick_loc_long,
                        'distance'=>$distance,
                        'duration'=>$duration
                    );
                }
            }
        }
        return response()->json(['success'=>true,'data'=>$result]);
    }

    public function send_driver($driver_id,$request_id)
    {
        // ToDo Send Push Notification and Hit to the node To show location on mobile App Map
        $ride_request = RideRequest::find($request_id);
        if($ride_request)
        {
            $ride_request->status = "Driver Assigned";
            $ride_request->save();
            $ride = new Ride();
            $ride->request_id = $ride_request->id;
            $ride->pick_loc_lat = $ride_request->pick_loc_lat;
            $ride->pick_loc_long = $ride_request->pick_loc_long;
            $ride->pick_up_at = Carbon::now();
            $ride->driver_id = $driver_id;
            $ride->save();
        }
        return redirect('/admin/assign-driver');
    }

    public function current_rides()
    {
        //ToDo Show a list of rides active,
        // ToDo On change of selection show driver_name,current_status {Driver On Way or picker ride}
        // ToDo if driver is on the way to ride
            // ToDo Show driver current location on map as well as ride pick up location
            // ToDo Show estimated time and distance to ride pick up
        //ToDo if driver picked up the ride show current location,estimated time and distance
        //ToDo to drop off location if this location is set on the map
    }

    public function complete_rides()
    {
        //ToDo Show a list of complete rides A clue is to show ride with ride
        //ToDo request whose status is complet
        //ToDo On Change of selection show a table
        //ToDo Show driver_name,pick_up_loc,drop_off_loc,est distance, est time,
        //ToDo Show three buttons, Video stream, show path
    }
}
