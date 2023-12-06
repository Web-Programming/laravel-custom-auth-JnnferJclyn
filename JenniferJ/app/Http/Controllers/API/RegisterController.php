<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class RegisterController extends BaseController
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'level' => 'required'
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /** */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'  =>  'required',
            'password' => 'required',
           // 'device_name' => 'required',
        ]);

         if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::where('username', $request->username)->first();

        if(! $user || !Hash::check($request->password, $user->password)){
            return $this->sendError('Validation Error' , 'The provided credential are incorrect');
        }
        
     //   $success['token'] = $user->createToken($request->device_name)->plainTextToken;
        $success['name'] = $user->name;
        return $this->sendresponse($success, 'User register successfully');
        
        // if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        //     $user = Auth::user();
        //     $success['token'] = $user->createToken('MyApp')->plainTextToken;
        //     $success['name'] = $user->name;

        //     return $this->sendResponse($success, 'User login successfully.');
        // } else {
        //     return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        // }
    }
}
