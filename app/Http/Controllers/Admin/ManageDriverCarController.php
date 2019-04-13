<?php

namespace App\Http\Controllers\Admin;

use App\Driver;
use App\DriverCar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageDriverCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $existing = null;
        $drivers_options = DriverCar::drivers_with_no_cars();
        $record = DriverCar::drivers_with_cars();
        return view('admin.driver-cars.index',compact('existing','drivers_options','record'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'driver_id' => 'required',
            'make' => 'required|regex:/^[a-z A-Z]+$/u|max:120|min:3',
            'model' => 'required|regex:/^[a-z A-Z]+$/u|max:120|min:3',
            'year' => 'required|numeric',
            'reg_no' => 'required',
            'purchase_date' => 'required',
            'curr_condition' => 'required',
        ]);
        if($request->input('id'))
        {
            $id = $request->input('id');
            $existing = DriverCar::find($id);
            if($existing)
            {
                $existing->driver_id = $request->input('driver_id');
                $existing->make = $request->input('make');
                $existing->model = $request->input('model');
                $existing->year = $request->input('year');
                $existing->reg_no = $request->input('reg_no');
                $existing->purchase_date = $request->input('purchase_date');
                $existing->curr_condition = $request->input('curr_condition');
                $existing->save();
            }
            return redirect('admin/driver-cars');
        }

        $driver_car = new DriverCar();
        $driver_car->driver_id = $request->input('driver_id');
        $driver_car->make = $request->input('make');
        $driver_car->model = $request->input('model');
        $driver_car->year = $request->input('year');
        $driver_car->reg_no = $request->input('reg_no');
        $driver_car->purchase_date = $request->input('purchase_date');
        $driver_car->curr_condition = $request->input('curr_condition');
        $driver_car->save();
        return redirect('admin/driver-cars');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $existing = DriverCar::find($id);
        if($existing)
        {
            $existing->driver_id = 0;
            $existing->save();
            $drivers_options = DriverCar::drivers_with_no_cars();
            $record = DriverCar::drivers_with_cars();
            return view('admin.driver-cars.index',compact('existing','record','drivers_options'));
        }
        else
        {
            return redirect('error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ex = DriverCar::find($id);
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
}
