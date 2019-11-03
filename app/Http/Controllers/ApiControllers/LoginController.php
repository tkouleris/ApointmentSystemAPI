<?php

namespace App\Http\Controllers\ApiControllers;

use App\Helper\Interfaces\IJwtHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use JWTAuth;

class LoginController extends Controller
{

    protected $UserRepository;
    protected $jwt;

    public function __construct( UserRepository $User, IJwtHelper $Jwt)
    {
        $this->UserRepository = $User;
        $this->jwt = $Jwt;
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
    }

    public function logout(Request $request)
    {
        $token = $this->jwt->get_token_from_request( $request );
        $this->jwt->invalidate_token( $token );

        $results['success'] = true;
        $results['message'] = 'Logged out';
        return response()->json($results,200);
    }
}
