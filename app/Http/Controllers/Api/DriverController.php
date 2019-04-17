<?php

namespace App\Http\Controllers\Api;

use App\Driver;
use App\DriverLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class DriverController extends Controller
{
    public function save_token(Request $request)
    {
        $rules = [
            'id'=>'required|numeric',
            'fcm_token'=>'required'
        ];
        $input = $request->only('id','fcm_token');
        $validator = Validator::make($input,$rules);
        if($validator->fails())
        {
            return response()->json(['success'=>false,'errors'=>$validator->message()],400);
        }

        $user = Driver::find($input['id']);
        if($user)
        {
            $user->fcm_token = $input['fcm_token'];
            $user->save();
            return response()->json(['success'=>true,'message'=>'Saved Successfully'],200);
        }
        else {
            return response()->json(['success'=>false,'errors'=>'Unauthorized'],401);
        }
    }

    public function live_location(Request $request)
    {
        $rules = [
            'id'=>'required|numeric',
            'longitude'=>'required',
            'latitude'=>'required'
        ];
        $input = $request->only('id','longitude','latitude');

        $validator = Validator::make($input,$rules);
        if($validator->fails())
        {
            return response()->json(['success'=>false,'errors'=>$validator->message()],400);
        }

        $user = Driver::find($input['id']);
        if($user)
        {
            $driver_location = new DriverLocation();
            $driver_location->driver_id = $input['id'];
            $driver_location->longitude = $input['longitude'];
            $driver_location->latitude = $input['latitude'];
            $driver_location->save();
            // ToDO Raise Event With Current Longitude and Latitude For Real Time map for the driver
            return response()->json(['success'=>true,'message'=>'Saved Successfully'],200);
        }
        else {
            return response()->json(['success'=>false,'errors'=>'Unauthorized'],401);
        }
    }
}
