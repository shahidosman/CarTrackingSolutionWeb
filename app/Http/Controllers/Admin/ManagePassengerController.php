<?php

namespace App\Http\Controllers\Admin;

use App\Passenger;
use App\RideRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Mockery\Generator\StringManipulation\Pass\Pass;

class ManagePassengerController extends Controller
{
    public function index()
    {
        $record = Passenger::all();
        $existing = null;
        return view('admin.passengers.index',compact('record','existing'));
    }

    public function create(Request $request)
    {
        echo"<pre>"; print_r('var'); exit;
    }

    public function destroy($id)
    {
        $ex = Passenger::find($id);
        if($ex)
        {
            $ex->delete();
            return response()->json(['data'=>true]);
        }
        else
            {
            return response()->json(['data'=>false]);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'fname' => 'required|regex:/^[a-zA-Z]+$/u|max:120|min:3',
            'lname' => 'required|regex:/^[a-zA-Z]+$/u|max:120|min:3',
            'email' => 'required|email',
            'phone_num' => 'required|regex:/(447)[0-9]{9}/'
        ]);
        if($request->input('id'))
        {
            $id = $request->input('id');
            $existing = Passenger::find($id);
            if($existing)
            {
                $existing->fname = $request->input('fname');
                $existing->lname = $request->input('lname');
                $existing->email = $request->input('email');
                $existing->phone_num = $request->input('phone_num');
                $existing->save();
            }
            return redirect('admin/passengers');
        }
        $this->validate($request,[
           'fname' => 'required|regex:/^[a-zA-Z]+$/u|max:120|min:3',
           'lname' => 'required|regex:/^[a-zA-Z]+$/u|max:120|min:3',
           'email' => 'required|email|unique:passengers',
            'phone_num' => 'required|regex:/(447)[0-9]{9}/'
        ]);

        $passenger = new Passenger();
        $passenger->fname = $request->input('fname');
        $passenger->lname = $request->input('lname');
        $passenger->email = $request->input('email');
        $passenger->phone_num = $request->input('phone_num');
        $passenger->save();
        return redirect('admin/passengers');
    }

    public function edit($id)
    {
        $existing = Passenger::find($id);
        $record = Passenger::all();
        if($existing)
        {
            return view('admin.passengers.index',compact('existing','record'));
        }
        else
            {
                return redirect('error');
            }
    }

    public function show($id)
    {
echo"<pre>"; print_r('var'); exit;
    }

    public function update(Request $request, $id)
    {
        echo"<pre>"; print_r('var'); exit;
    }

    public function delete($id)
    {
        echo"<pre>"; print_r('var'); exit;
    }

    public function ride_requests()
    {
        $passenger_options = Passenger::passenger_with_ride_req_allowed();
        $existing = null;
        return view('admin.passengers.ride-request',compact('passenger_options','existing'));
    }

    public function store_ride_request(Request $request)
    {
        $this->validate($request,[
            'passenger_id' => 'required',
            'pick_loc_address' => 'required',
            'pick_loc_lat' => 'required',
            'pick_loc_long' => 'required',
            'request_mode' => 'required',
        ]);
        // Edit
        if($request->input('id'))
        {
            $id = $request->input('id');
            $existing = RideRequest::find($id);
            if($existing)
            {
                $existing->passenger_id = $request->input('passenger_id');
                $existing->pick_loc_address = $request->input('pick_loc_address');
                $existing->pick_loc_lat = $request->input('pick_loc_lat');
                $existing->pick_loc_long = $request->input('pick_loc_long');
                $existing->dest_loc_address = $request->input('dest_loc_address');
                $existing->dest_loc_lat = $request->input('dest_loc_lat');
                $existing->dest_loc_long = $request->input('dest_loc_long');
                $existing->request_mode = $request->input('request_mode');
                $existing->save();
            }
            return redirect('admin/ride-request');
        }

        $ride_request = new RideRequest();
        $ride_request->passenger_id = $request->input('passenger_id');
        $ride_request->pick_loc_address = $request->input('pick_loc_address');
        $ride_request->pick_loc_lat = $request->input('pick_loc_lat');
        $ride_request->pick_loc_long = $request->input('pick_loc_long');
        $ride_request->dest_loc_address = $request->input('dest_loc_address');
        $ride_request->dest_loc_lat = $request->input('dest_loc_lat');
        $ride_request->dest_loc_long = $request->input('dest_loc_long');
        $ride_request->request_mode = $request->input('request_mode');
        $ride_request->status = "New";
        $ride_request->save();
        Session::flash('success','Data has been saved successfully');
        return redirect('admin/ride-request');
    }
}
