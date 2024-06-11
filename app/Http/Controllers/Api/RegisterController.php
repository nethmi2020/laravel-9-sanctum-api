<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
class RegisterController extends BaseController
{
    public function register(Request $request ){

        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation error .', $validator->errors());
        }
        $input=$request->all();
        $input['password']=bcrypt($input['password']);
        $user=User::create($input);
        $success['token']=$user->createToken('MyApp')->plainTextToken;
        $success['name']=$user->name;

        return $this->sendResponse($success,'User registered successfully');
    }
}
