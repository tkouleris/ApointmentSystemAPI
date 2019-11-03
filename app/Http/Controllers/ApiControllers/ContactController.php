<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;

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
        return response()->json($results,201);
    }

    public function getContact(Contact $contact)
    {
        $results['success'] = true;
        $results['data'] = $contact;
        return $results;
    }
}
