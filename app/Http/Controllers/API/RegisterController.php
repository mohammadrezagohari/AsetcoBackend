<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Useraddress;
use App\Models\City;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
       $request->validate([
           'name'              => ['required'],
           'email'             => ['required','email'],
           'mobile'            => ['required','ir_mobile'],
           'national_identity' => ['required','ir_national_code'],
           'gender'            => ['required','in:men,women'],
           'province_id'       => ['required'],
           'city_id'           => ['required'],
           'detail_address'    => ['required'],
           'password'          => ['required','min:6'],
           'c_password'        => ['required','same:password'],

       ]);
        $input              = $request->all();
        $input['password']  = bcrypt($input['password']);
        $input['activated'] = false;
        $user               = User::create($input);

       $user->Useraddress()->create([
           'province_id'=>$request->province_id,
           'city_id'=>$request->city_id,
           'detail_address'=>$request->detail_address,
       ]);

        $success['token']   = $user->createToken('MyApp')->plainTextToken;
        $success['name']    = $user->name;
        return response()->json([$success, 'User register successfully.'], 200);
    }

}
