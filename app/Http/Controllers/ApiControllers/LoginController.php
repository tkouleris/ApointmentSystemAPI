<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        if( !$request->has('UsrEmail') || !$request->has('UsrPassword') )
        {
            $results['success'] = false;
            $results['message'] = 'Bad Request!';
            return response()->json($results,400);
        }

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


        $results['success'] = true;
        $results['data'] = $User;
        return response()->json($results,200);

    }
}
