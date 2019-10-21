<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $primaryKey = 'ContactID' ;

    protected $fillable = [
        'ContactFirstname', 'ContactLastname', 'ContactEmail', 'ContactAddress', 'ContactPostCode',
        'ContactCity', 'ContactCellphone'
    ];

}
