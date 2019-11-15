<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Repositories\Interfaces\IAppointmentRepository;

class AppointmentRepository implements IAppointmentRepository{

    protected $Appointment;

    public function __construct( Appointment $AppointmentModel )
    {
        $this->Appointment = $AppointmentModel;
    }

    public function list( $args )
    {
        return $this->Appointment::all();
    }

    public function findById( $id )
    {
        return $this->Appointment::findOrFail( $id );
    }


    public function create( $data )
    {
        return $this->Appointment::create( $data );
    }

    public function update( $id, $data )
    {
        $this->Appointment::where('ApntID',$id)->update($data);
        return $this->Appointment::findOrFail($id);
    }

    public function delete( $id )
    {
        return $this->Appointment::destroy($id);
    }
}