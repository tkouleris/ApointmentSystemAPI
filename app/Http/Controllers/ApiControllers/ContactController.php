<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IContactRepository;
use App\Models\Contact;

class ContactController extends Controller
{

    protected $ContactRepository;

    public function __construct( IContactRepository $Contact )
    {
        $this->ContactRepository = $Contact;
    }

    public function getContacts()
    {
        $results['success'] = true;
        $results['data'] = $this->ContactRepository->list( array() );
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
