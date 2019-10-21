<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;

class ContactController extends Controller
{
    public function getContacts()
    {
        $Contacts = Contact::all();

        $results['success'] = true;
        $results['data'] = $Contacts;
        return response()->json($results,200);
    }

    public function addContact(Request $request)
    {
        $Contact = Contact::create($request->input());

        $results['success'] = true;
        $results['data'] = $Contact;
        return response()->json($results,200);
    }
}
