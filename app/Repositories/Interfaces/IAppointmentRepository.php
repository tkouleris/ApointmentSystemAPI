<?php

namespace App\Repositories\Interfaces;

interface IAppointmentRepository extends IBaseRepository{
    public function delete( $id );
}