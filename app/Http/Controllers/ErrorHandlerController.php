<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ErrorHandlerController extends Controller
{
    public function index()
    {
        $code = 401;
        $message = "Sorry! You did not have permission to view this";
        return view('error.handle-error',compact('message','code'));
    }
}
