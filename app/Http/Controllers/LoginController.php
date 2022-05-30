<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;


class LoginController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }



        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            $success['roles'] = DB::table('roles')->where('roles.id','=',$user->role_id)->selectRaw('roles.permissions')->get()[0];

            return response()->json($success);
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'كلمة السر او الايميل خاطئ']);
        }
    }

}
