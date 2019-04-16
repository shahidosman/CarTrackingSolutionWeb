<?php

namespace App\Http\Controllers\Admin;

use App\Driver;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageDriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = Driver::all();
        $existing = null;
        return view('admin.drivers.index',compact('record','existing'));
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
            'fname' => 'required|regex:/^[a-zA-Z]+$/u|max:120|min:3',
            'lname' => 'required|regex:/^[a-zA-Z]+$/u|max:120|min:3',
            'email' => 'required|email',
            'phone_number' => 'required|regex:/(447)[0-9]{9}/',
            'license' => 'required',
            'city' => 'required|regex:/^[a-z A-Z]+$/u|max:120|min:1',
            'country' => 'required|regex:/^[a-z A-Z]+$/u|max:120|min:1',
            'address' => 'required',
            'zip' => 'required|numeric',
            'profile_image' => 'required|image',
            'license_image' => 'required|image',
        ]);
        if($request->input('id'))
        {
            $id = $request->input('id');
            $existing = Driver::find($id);
            if($existing)
            {
                $existing->fname = $request->input('fname');
                $existing->lname = $request->input('lname');
                $existing->email = $request->input('email');
                $existing->phone_number = $request->input('phone_number');
                $existing->license = $request->input('license');
                $existing->city = $request->input('city');
                $existing->country = $request->input('country');
                $existing->zip = $request->input('zip');
                $ex_profile_image_path = public_path()."/css/uploads/".$existing->profile_image;
                if(File::exists($ex_profile_image_path))
                {
                    File::delete($ex_profile_image_path);
                }
                $ex_license_image_path = public_path()."/css/uploads/".$existing->license_image;
                if(File::exists($ex_license_image_path))
                {
                    File::delete($ex_license_image_path);
                }
                    $profile_image = $request->file('profile_image');
                    $name = rand(100,10000).'_'.$profile_image->getClientOriginalName();

                    $profile_image->move(public_path('css/uploads'),$name);
                    $existing->profile_image = $name;

                    $license_image = $request->file('license_image');
                    $name = rand(100,10000).'_'.$license_image->getClientOriginalName();

                   $license_image->move(public_path('css/uploads'),$name);

                    $existing->license_image = $name;
                $existing->save();
            }
            return redirect('admin/drivers');
        }
        //Unique Email and Unique Driver Each Time
        $this->validate($request,[
            'fname' => 'required|regex:/^[a-zA-Z]+$/u|max:120|min:3',
            'lname' => 'required|regex:/^[a-zA-Z]+$/u|max:120|min:3',
            'email' => 'required|email|unique:drivers',
            'phone_number' => 'required|unique:drivers|regex:/(447)[0-9]{9}/',
            'license' => 'required',
            'city' => 'required|regex:/^[a-z A-Z]+$/u|max:120|min:3',
            'country' => 'required|regex:/^[a-z A-Z]+$/u|max:120|min:3',
            'address' => 'required',
            'zip' => 'required|numeric',
            'profile_image' => 'required|image',
            'license_image' => 'required|image',
        ]);

        $driver = new Driver();
        $driver->fname = $request->input('fname');
        $driver->lname = $request->input('lname');
        $driver->email = $request->input('email');
        $driver->phone_number = $request->input('phone_number');
        $driver->license = $request->input('license');
        $driver->city = $request->input('city');
        $driver->country = $request->input('country');
        $driver->address = $request->input('address');
        $driver->zip = $request->input('zip');
            $profile_image = $request->file('profile_image');
            $name = rand(100,10000).'_'.$profile_image->getClientOriginalName();

            $profile_image->move(public_path('css/uploads'),$name);
            $driver->profile_image = $name;

            $license_image = $request->file('license_image');
            $name = rand(100,10000).'_'.$license_image->getClientOriginalName();

            $license_image->move(public_path('css/uploads'),$name);
            $driver->license_image = $name;
        $driver->save();
        return redirect('admin/drivers');
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
        $existing = Driver::find($id);
        $record = Driver::all();
        if($existing)
        {
            return view('admin.drivers.index',compact('existing','record'));
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
        $ex = Driver::find($id);
        if($ex)
        {
            $ex_profile_image_path = public_path()."/css/uploads/".$ex->profile_image;
            if(File::exists($ex_profile_image_path))
            {
                File::delete($ex_profile_image_path);
            }
            $ex_license_image_path = public_path()."/css/uploads/".$ex->license_image;
            if(File::exists($ex_license_image_path))
            {
                File::delete($ex_license_image_path);
            }
            $ex->delete();
            return response()->json(['data'=>true]);
        }
        else
        {
            return response()->json(['data'=>false]);
        }
    }

    public function tracker()
    {
        return view('admin.drivers.live-location');
    }
}
