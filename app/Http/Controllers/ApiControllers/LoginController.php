<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use JWTAuth;

class LoginController extends Controller
{

    protected $UserRepository;

    public function __construct( UserRepository $User)
    {
        $this->UserRepository = $User;
    }

    public function login(LoginRequest $request)
    {
        if( ($User = $this->UserRepository->findByEmail( $request->UsrEmail) ) == null){
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


        if (!$token = JWTAuth::fromUser($User) ) {
            $results['success'] = false;
            $results['message'] = 'Unauthorized!';
            return response()->json($results,401);
        }


        $results['success'] = true;
        $results['message'] = 'Login Successfull';
        $results['token'] = $token;
        return response()->json($results,200);
        // return response()->json(['token'=>$token]);

    }
}
