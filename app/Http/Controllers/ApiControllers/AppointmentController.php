<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\Interfaces\IJwtHelper;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Interfaces\IAppointmentRepository;
use Carbon\Carbon;


class AppointmentController extends Controller
{

    protected $UserRepository;
    protected $AppntRepository;
    protected $jwt;

    public function __construct( IUserRepository $User, IAppointmentRepository $appointment, IJwtHelper $Jwt)
    {
        $this->UserRepository = $User;
        $this->AppntRepository = $appointment;
        $this->jwt = $Jwt;
    }

    public function addAppointment(Request $request)
    {

        $token = $this->jwt->get_token_from_request( $request );

        $currentUser = $this->UserRepository->findByToken( $token );
        $request->merge(['ApntUsrID' => $currentUser->UsrID]);
        $request->merge(['ApntDate' => new Carbon($request->ApntDate)]);

        $results['success'] = true;
        $results['data'] = $this->AppntRepository->create( $request->input());
        return response()->json($results,201);
    }
}
