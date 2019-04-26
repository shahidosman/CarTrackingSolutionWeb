<?php

namespace App\Http\Controllers\Api;

use App\CompleteRide;
use App\CurrentRide;
use App\Driver;
use App\Ride;
use App\RideRequest;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DriverRideController extends Controller
{
    public function update_pick_up_loc(Request $request)
    {
        $rules = [
            'driver_id'=>'required|numeric',
            'latitude'=>'required',
            'longitude'=>'required'
        ];
        $input = $request->only('driver_id','latitude','longitude');

        $validator = Validator::make($input,$rules);
        if($validator->fails())
        {
            return response()->json(['success'=>false,'errors'=>$validator->errors()],400);
        }

        $user = Driver::find($input['driver_id']);
        if($user)
        {
            // One driver will only have one active ride
            $ride = Ride::where('driver_id','=',$user->id)->where('is_active','=',true)->first();
            if($ride)
            {
                // Updating Pick up Location
                $ride->pick_loc_lat = $input['latitude'];
                $ride->pick_loc_long = $input['longitude'];
                $ride->save();
                // Updating Ride request status to picked
                $ride_request = RideRequest::find($ride->request_id);
                if($ride_request)
                {
                    $ride_request->status = 'Picked';
                    $ride_request->save();
                }
                return response()->json(['success'=>true,'message'=>'Pick up Location Updated Successfully']);
            }
            else
                {
                    return response()->json(['success'=>false,'errors'=>'No Ride Assigned to Driver']);
                }
        }
        else
        {
            return response()->json(['success'=>false,'errors'=>'Invalid User']);
        }
    }

    public function ride_live_location(Request $request)
    {

        $rules = [
            'driver_id'=>'required|numeric',
            'latitude'=>'required',
            'longitude'=>'required'
        ];
        $input = $request->only('driver_id','latitude','longitude');

        $validator = Validator::make($input,$rules);
        if($validator->fails())
        {
            return response()->json(['success'=>false,'errors'=>$validator->errors()],400);
        }

        $user = Driver::find($input['driver_id']);
        if($user)
        {
            // One driver will only have one active ride
            $ride = Ride::where('driver_id','=',$user->id)->where('is_active','=',true)->first();
            if($ride)
            {
                // Getting Pick up Location
                $pick = array(array('latitude'=>$ride->pick_loc_lat,'longitude'=>$ride->pick_loc_long));
                $curr = CurrentRide::where('ride_id','=',$ride->id)->
                select(['curr_loc_lat AS latitude','curr_loc_long AS longitude'])->get()->toArray();
                $elapsed_dist = 0;
                $end_time = Carbon::now();
                $elapsed_time = $end_time->diff($ride->updated_at)->format('%H:%I:%S');
                if(count($curr)>0)
                {
                    $paths = array_merge($pick,$curr);
                    for($i=0;$i<count($paths);$i++)
                    {
                        if($i+1!=count($paths))
                        {
                            $distance_time = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$paths[$i]['latitude'].','.$paths[$i]['longitude'].'&destinations='.$paths[$i+1]['latitude'].','.$paths[$i+1]['longitude'].'&key='.env('GOOGLE_MAP'));
                            $data = json_decode($distance_time);
                            $code = $data->status;
                            $distance = ($code=="OK")?$data->rows[0]->elements[0]->distance->value:'';
                            if($distance!='')
                            {
                                $elapsed_dist = $elapsed_dist+$distance;
                            }
                        }
                    }
                }
                $current_ride = new CurrentRide();
                $current_ride->ride_id = $ride->id;
                $current_ride->curr_loc_lat = $input['latitude'];
                $current_ride->curr_loc_long = $input['longitude'];
                $current_ride->elapsed_dist = $elapsed_dist;
                $current_ride->elapsed_time = $elapsed_time;
                $current_ride->save();
                //ToDo Raise Event
                //ToDo Use Events for real time updation of map every 2 sec
                // Updating Ride request status to On Way
                $ride_request = RideRequest::find($ride->request_id);
                if($ride_request)
                {
                    $ride_request->status = 'On Way';
                    $ride_request->save();
                }
                return response()->json(['success'=>true,'message'=>'Current Location Added Successfully']);
            }
            else
            {
                return response()->json(['success'=>false,'errors'=>'No Ride Assigned to Driver']);
            }
        }
        else
        {
            return response()->json(['success'=>false,'errors'=>'Invalid User']);
        }
    }

    public function complete_ride(Request $request)
    {
        $rules = [
            'driver_id'=>'required|numeric',
            'latitude'=>'required',
            'longitude'=>'required'
        ];
        $input = $request->only('driver_id','latitude','longitude');

        $validator = Validator::make($input,$rules);
        if($validator->fails())
        {
            return response()->json(['success'=>false,'errors'=>$validator->errors()],400);
        }

        $user = Driver::find($input['driver_id']);
        if($user)
        {
            // One driver will only have one active ride
            $ride = Ride::where('driver_id','=',$user->id)->where('is_active','=',true)->first();
            if($ride)
            {
                // Getting Rick up Location
                $pick = array(array('latitude'=>$ride->pick_loc_lat,'longitude'=>$ride->pick_loc_long));
                $curr = CurrentRide::where('ride_id','=',$ride->id)->
                select(['curr_loc_lat AS latitude','curr_loc_long AS longitude'])->get()->toArray();
                $elapsed_dist = 0;
                $end_time = Carbon::now();
                $elapsed_time = $end_time->diff($ride->updated_at)->format('%H:%I:%S');
                if(count($curr)>0)
                {
                    $paths = array_merge($pick,$curr);
                    //Calculating distance
                    for($i=0;$i<count($paths);$i++)
                    {
                        if($i+1!=count($paths))
                        {
                            $distance_time = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$paths[$i]['latitude'].','.$paths[$i]['longitude'].'&destinations='.$paths[$i+1]['latitude'].','.$paths[$i+1]['longitude'].'&key='.env('GOOGLE_MAP'));
                            $data = json_decode($distance_time);
                            $code = $data->status;
                            $distance = ($code=="OK")?$data->rows[0]->elements[0]->distance->value:'';
                            if($distance!='')
                            {
                                $elapsed_dist = $elapsed_dist+$distance;
                            }
                        }
                    }
                }
                $ride->is_active = false;
                $ride->save();
                $complete_ride = new CompleteRide();
                $complete_ride->ride_id = $ride->id;
                $complete_ride->drop_loc_lat = $input['latitude'];
                $complete_ride->drop_loc_long = $input['longitude'];
                $complete_ride->total_distance = $elapsed_dist;
                $complete_ride->total_time = $elapsed_time;
                $complete_ride->price = 100;
                $complete_ride->video_url = "NA";
                $complete_ride->save();
                // Updating Ride request status to Processed
                $ride_request = RideRequest::find($ride->request_id);
                if($ride_request)
                {
                    $ride_request->status = 'Processed';
                    $ride_request->save();
                }
                return response()->json(['success'=>true,'message'=>'Complete Location Added Successfully']);
            }
            else
            {
                return response()->json(['success'=>false,'errors'=>'No Ride Assigned to Driver']);
            }
        }
        else
        {
            return response()->json(['success'=>false,'errors'=>'Invalid User']);
        }
    }

    public function ride_video(Request $request)
    {
        $rules = [
            'driver_id'=>'required|numeric',
            'url'=>'required'
        ];
        $input = $request->only('driver_id','url');

        $validator = Validator::make($input,$rules);
        if($validator->fails())
        {
            return response()->json(['success'=>false,'errors'=>$validator->errors()],400);
        }

        $user = Driver::find($input['driver_id']);
        if($user)
        {
            // One driver will only have one active ride
            $ride = Ride::join('complete_rides',function ($join){
                $join->on('rides.id','=','complete_rides.ride_id');
            })->select([
                'complete_rides.id',
                'complete_rides.video_url',
                'rides.driver_id'
            ])->where('rides.driver_id','=',$input['driver_id'])->where('complete_rides.video_url','=','NA')->get()->first();
            if($ride)
            {
                // Getting Rick up Location
                $complet_ride = CompleteRide::find($ride->id);
                if($complet_ride)
                {
                    $complet_ride->video_url = $input['url'];
                    $complet_ride->save();
                }
                return response()->json(['success'=>true,'message'=>'Video Url Updated Successfully']);
            }
            else
            {
                return response()->json(['success'=>false,'errors'=>'Cannot update video url before completing the ride']);
            }
        }
        else
        {
            return response()->json(['success'=>false,'errors'=>'Invalid User']);
        }
    }
}
