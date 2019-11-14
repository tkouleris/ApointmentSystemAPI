<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Helper\Interfaces\IJwtHelper;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class AppointmentController extends Controller
{

    protected $UserRepository;
    protected $jwt;

    public function __construct( UserRepository $User, IJwtHelper $Jwt)
    {
        $this->UserRepository = $User;
        $this->jwt = $Jwt;
    }

    public function addAppointment(Request $request)
    {
        $token = $this->jwt->get_token_from_request( $request );

        $currentUser = $this->UserRepository->findByToken( $token );

        // TODO Appointmentment Repository
        $appnt = new Appointment;
        $appnt->ApntUsrID = $currentUser->UsrID;
        $appnt->ApntDate = new Carbon($request->ApntDate);
        $appnt->ApntContactID = $request->ApntContactID;
        $appnt->Comments = $request->Comments;
        $appnt->save();

        $results['success'] = true;
        return response()->json($results,201);
    }
}
