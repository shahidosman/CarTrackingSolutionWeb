<?php

namespace App;

use function foo\func;
use Illuminate\Database\Eloquent\Model;

class DriverCar extends Model
{
    public static function drivers_with_no_cars()
    {
        $drivers_with_no_cars = Driver::leftJoin('driver_cars', function ($join){
            $join->on('drivers.id','=','driver_cars.driver_id');
        })->select([
            'driver_cars.driver_id',
           'drivers.id',
           'drivers.fname',
           'drivers.lname'
        ])->get();
        return $drivers_with_no_cars;
    }

    public static function drivers_with_cars()
    {
        $driver_with_cars = Driver::join('driver_cars',function ($join){
            $join->on('drivers.id','=','driver_cars.driver_id');
        })->select([
            'driver_cars.id as id',
            'drivers.id as driver_id',
            'drivers.fname as driver_fname',
            'drivers.lname as driver_lname',
            'driver_cars.reg_no as reg_no',
            'driver_cars.model as model',
            'driver_cars.make as make',
            'driver_cars.year as year',
            'driver_cars.purchase_date as purchase_date',
            'driver_cars.curr_condition as curr_condition',
        ])->get();
        return $driver_with_cars;
    }
}
