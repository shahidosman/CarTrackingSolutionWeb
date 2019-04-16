<?php

namespace App\Http\Controllers\Api;

use App\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['login']]);
    }

    public function login(Request $request)
    {
        $rules = [
            'phone_number' => 'required|regex:/(447)[0-9]{9}/'
        ];

        $input = $request->only('phone_number');
        $validator = Validator::make($input,$rules);
        if($validator->fails())
        {
            return response()->json(['success'=>false,'errors'=>$validator->messages()],400);
        }

        $user = Driver::where('phone_number','=',$input)->select([
            'id','fname','lname','phone_number','profile_image'
        ])->first();
        $user->image_url = asset('css/uploads/'.$user->profile_image);
        if($user)
        {
            if(!$token = JWTAuth::fromUser($user))
            {
                return response()->json(['success'=>false,'errors'=>'Unauthrized'],401);
            }
            $user_info = $user;
            $data = array('success'=>true,'user_info'=>$user_info,'token'=>$this->responseWithToken($token));
            return response()->json(['success'=>true,'data'=>$data],200);
        }
        return response()->json(['success'=>false,'error'=>'Invalid Phone Number'],400);
    }

    protected function responseWithToken($token)
    {
        return array(
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        );
    }
}
