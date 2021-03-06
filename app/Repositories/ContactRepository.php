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
        $this->Contact::where('ContactID',$id)
            ->update($data);

        return $this->Contact::where('ContactID',$id)->first();

    }

    public function delete( $id )
    {
        return $this->Contact::destroy($id);
    }
}