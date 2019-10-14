<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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


    }
}
