<?php

namespace App\Http\Controllers\ApiControllers;

use App\Helper\Interfaces\IJwtHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;

class UserController extends Controller
{

    protected $UserRepository;
    protected $jwt;

    public function __construct( UserRepository $User, IJwtHelper $Jwt)
    {
        $this->UserRepository = $User;
        $this->jwt = $Jwt;
    }

    public function addUser(CreateUserRequest $request)
    {
        $token = $this->jwt->get_token_from_request( $request );

        $currentUser = $this->UserRepository->findByToken( $token );
        if( !$currentUser->isAdmin() )
        {
            $results['success'] = false;
            $results['message'] = "Not authorized!";
            return response()->json($results,401);
        }

        $request->merge([
            'UsrPassword' => Hash::make($request->input('UsrPassword')),
        ]);
        $this->UserRepository->create( $request->input() );


        $results['success'] = true;
        return response()->json($results,201);
    }
}
