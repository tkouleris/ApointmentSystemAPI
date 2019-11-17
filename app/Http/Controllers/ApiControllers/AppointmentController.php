<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\Interfaces\IJwtHelper;
use App\Models\Appointment;
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

    public function updateAppointment(Appointment $appointment, Request $request)
    {
        $upd_appnt = $this->AppntRepository->update($appointment->ApntID, $request->input());

        $results['success'] = true;
        $results['data'] = $upd_appnt;
        return response()->json($results,200);
    }

    public function deleteAppointment(Appointment $appointment, Request $request)
    {
        $token = $this->jwt->get_token_from_request( $request );
        $currentUser = $this->UserRepository->findByToken( $token );


        if( ($appointment->ApntUsrID != $currentUser->UsrID) && !$currentUser->isAdmin() )
        {
            $results['success'] = false;
            return response()->json($results,401);
        }

        $deleted_appnt = $this->AppntRepository->delete( $appointment->ApntID);

        $results['success'] = true;
        return response()->json($results,204);
    }

    public function getAppointments(Request $request)
    {
        $results['success'] = true;
        $results['data'] = $this->AppntRepository->list( array() );
        return response()->json($results,200);
    }

    public function getAppointment(Appointment $appointmnet)
    {
        $results['success'] = true;
        $results['data'] = $appointmnet;
        return response()->json($results,200);
    }
}
