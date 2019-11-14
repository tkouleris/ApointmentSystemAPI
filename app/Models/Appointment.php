<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    protected $primaryKey = 'ApntID' ;

    protected $fillable = [
        'ApntDate', 'ApntContactID', 'ApntUsrID', 'Comments'
    ];
}
