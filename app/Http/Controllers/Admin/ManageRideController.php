<?php
namespace App\Http\Controllers\Admin;

use App\Driver;
use App\DriverLocation;
use App\Ride;
use App\RideRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CurrentRide;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
require base_path().'/vendor/autoload.php';
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
                    $distance_time = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$driver_curr_loc->latitude.','.$driver_curr_loc->longitude.'&destinations='.$ride_request->pick_loc_lat.','.$ride_request->pick_loc_long.'&key='.env('GOOGLE_MAP'));
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
            $driver = Driver::find($driver_id);
            $service_account = ServiceAccount::fromJsonFile(base_path().'/car-tracking-app-firebase-adminsdk-dvp3h-c743aa84ae.json');
            $firebase = (new Factory)
                ->withServiceAccount($service_account)
                ->withDatabaseUri('https://car-tracking-app.firebaseio.com/')->create();
            $database = $firebase->getDatabase();
            $update_pick_up = $database
                ->getReference('userData/'.$driver->phone_number.'/user_pick_loc')
                ->update([
                    'lat' => $ride_request->pick_loc_lat,
                    'lng' => $ride_request->pick_loc_long,
                ]);
            $update_dest_loc = $database
                ->getReference('userData/'.$driver->phone_number.'/user_drop_loc')
                ->update([
                    'lat' => $ride_request->dest_loc_lat,
                    'lng' => $ride_request->dest_loc_long,
                ]);
        }
        return redirect('/admin/assign-driver');
    }

    public function test_firebase()
    {
        $service_account = ServiceAccount::fromJsonFile(base_path().'/car-tracking-app-firebase-adminsdk-dvp3h-c743aa84ae.json');
        $firebase = (new Factory)
            ->withServiceAccount($service_account)
            ->withDatabaseUri('https://car-tracking-app.firebaseio.com/')->create();
        $database = $firebase->getDatabase();
        $newPost = $database
            ->getReference('userData/447123123125/user_pick_loc')
            ->update([
                'lat' => 31.528284,
                'lng' => 74.3164341,
            ]);
        $newPost = $database
            ->getReference('userData/447123123125/user_drop_loc')
            ->update([
                'lat' => 31.628284,
                'lng' => 74.4164341,
            ]);
        echo"<pre>"; print_r('var'); exit;
    }

    public function current_rides()
    {
        //ToDo Show a list of rides active,
        $rides = Ride::where('is_active','=',true)->get();
        $ride_options = [];
        foreach ($rides as $key=>$ride)
        {
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$ride->pick_loc_lat.','.$ride->pick_loc_long.'&sensor=false&key='.env('GOOGLE_MAP'));
            $output = json_decode($geocodeFromLatLong);
            $status = $output->status;
            $address = ($status=="OK")?$output->results[0]->formatted_address:'';
            $ride_options[($key)] = array(
                'driver_id'=>$ride->driver_id,
                'id'=>$ride->id,
                'pick_loc_address'=>$address
            );
        }
        //ToDo if driver picked up the ride show current location,estimated time and distance
        //ToDo to drop off location if this location is set on the map
        return view('admin.rides.current-rides',compact('ride_options'));
    }

    public function current_ride_location($id)
    {
        $ride = Ride::find($id);
        $ride_request = RideRequest::find($ride->request_id);
        $result = [];
        if($ride_request->status == "Picked" || $ride_request->status == "On Way")
        {
            $driver_curr_loc = CurrentRide::where('ride_id','=',$ride->id)->orderBy('created_at','desc')->first();
            if($driver_curr_loc!=null)
            {
                $driver = Driver::find($ride->driver_id);
                $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$driver_curr_loc->curr_loc_lat.','.$driver_curr_loc->curr_loc_long.'&sensor=false&key='.env('GOOGLE_MAP'));
                $output = json_decode($geocodeFromLatLong);
                $status = $output->status;
                $address = ($status=="OK")?$output->results[0]->formatted_address:'';
                $distance_time = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$ride_request->pick_loc_lat.','.$ride_request->pick_loc_long.'&destinations='.$driver_curr_loc->curr_loc_lat.','.$driver_curr_loc->curr_loc_long.'&key='.env('GOOGLE_MAP'));
                $data = json_decode($distance_time);
                $code = $data->status;
                $distance = ($code=="OK")?$data->rows[0]->elements[0]->distance->text:'';
                $duration = ($code=="OK")?$data->rows[0]->elements[0]->duration->text:'';
                $result[0] = array(
                    'id'=>$ride->id,
                    'driver_id'=>$driver->id,
                    'driver_name'=>$driver->fname. " " .$driver->lname,
                    'curr_loc_address'=>$address,
                    'curr_loc_lat'=>$driver_curr_loc->latitude,
                    'curr_loc_long'=>$driver_curr_loc->longitude,
                    'request_id'=>$ride_request->id,
                    'pick_loc_address'=>$ride_request->pick_loc_address,
                    'pick_loc_lat'=>$ride_request->pick_loc_lat,
                    'pick_loc_long'=>$ride_request->pick_loc_long,
                    'dest_loc_address'=>$ride_request->dest_loc_address,
                    'dest_loc_lat'=>$ride_request->dest_loc_lat,
                    'dest_loc_long'=>$ride_request->dest_loc_long,
                    'distance'=>$distance,
                    'duration'=>$duration,
                    'status'=>$ride_request->status
                );
            }
        }
        else {
            $driver_curr_loc = DriverLocation::where('driver_id','=',$ride->driver_id)
                ->orderBy('created_at','desc')->first();
            if($driver_curr_loc!=null)
            {
                $driver = Driver::find($ride->driver_id);
                $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$driver_curr_loc->latitude.','.$driver_curr_loc->longitude.'&sensor=false&key='.env('GOOGLE_MAP'));
                $output = json_decode($geocodeFromLatLong);
                $status = $output->status;
                $address = ($status=="OK")?$output->results[0]->formatted_address:'';
                $distance_time = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$driver_curr_loc->latitude.','.$driver_curr_loc->longitude.'&destinations='.$ride_request->pick_loc_lat.','.$ride_request->pick_loc_long.'&key='.env('GOOGLE_MAP'));
                $data = json_decode($distance_time);
                $code = $data->status;
                $distance = ($code=="OK")?$data->rows[0]->elements[0]->distance->text:'';
                $duration = ($code=="OK")?$data->rows[0]->elements[0]->duration->text:'';
                $result[0] = array(
                    'id'=>$ride->id,
                    'driver_id'=>$driver->id,
                    'driver_name'=>$driver->fname. " " .$driver->lname,
                    'curr_loc_address'=>$address,
                    'curr_loc_lat'=>$driver_curr_loc->latitude,
                    'curr_loc_long'=>$driver_curr_loc->longitude,
                    'request_id'=>$ride_request->id,
                    'pick_loc_address'=>$ride_request->pick_loc_address,
                    'pick_loc_lat'=>$ride_request->pick_loc_lat,
                    'pick_loc_long'=>$ride_request->pick_loc_long,
                    'dest_loc_address'=>$ride_request->dest_loc_address,
                    'dest_loc_lat'=>$ride_request->dest_loc_lat,
                    'dest_loc_long'=>$ride_request->dest_loc_long,
                    'distance'=>$distance,
                    'duration'=>$duration,
                    'status'=>$ride_request->status
                );
            }
        }

        return response()->json(['success'=>true,'data'=>$result]);
    }

    public function current_ride_travelled($id)
    {
        $locations = CurrentRide::where('ride_id','=',$id)->get();
        return response()->json($locations);
    }

    public function complete_rides()
    {
        $drivers = Driver::all();
        return view('admin.rides.complete-rides',compact('drivers'));
    }

    public function complete_rides_by_driver($id)
    {
        //ToDo we have only id of driver
    }

    public function show_complete_ride_path($id)
    {

    }
}
