<?php

namespace App\Http\Controllers\Admin;

use App\Passenger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
