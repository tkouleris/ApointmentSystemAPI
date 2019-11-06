<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IContactRepository;
use App\Models\Contact;

class ContactRepository implements IContactRepository
{

    protected $Contact;

    public function __construct( Contact $ContactModel )
    {
        $this->Contact = $ContactModel;
    }

    public function list( $args )
    {
        return $this->Contact::all();
    }

    public function findById( $id )
    {
        $this->Contact::findOrFail( $id );
    }

    public function create( $data )
    {
        return $this->Contact::create( $data );
    }

    public function update( $id, $data )
    {
        // TODO
    }

    public function delete( $id )
    {
        // TODO
    }
}