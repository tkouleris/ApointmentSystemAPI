<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use JWTAuth;

class LoginController extends Controller
{

    public function login(LoginRequest $request)
    {
        // if( !$request->has('UsrEmail') || !$request->has('UsrPassword') )
        // {
        //     $results['success'] = false;
        //     $results['message'] = 'Bad Request!';
        //     return response()->json($results,400);
        // }

        $User = User::where('UsrEmail','=', $request->input('UsrEmail'))
                    ->first();

        if( $User == null){
            $results['success'] = false;
            $results['message'] = 'Unauthorized!';
            return response()->json($results,401);
        }


        if( !Hash::check( $request->UsrPassword, $User->UsrPassword) )
        {
            $results['success'] = false;
            $results['message'] = 'Unauthorized!';
            return response()->json($results,401);
        }


        if (!$token =JWTAuth::fromUser($User) ) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return response()->json(['token'=>$token]);

    }
}
