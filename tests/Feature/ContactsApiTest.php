<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use JWTAuth;


class ContactsApiTest extends TestCase
{
    use RefreshDatabase;

    public function getToken()
    {
        $credentials = ['UsrEmail'=>'test@email.gr','UsrPassword'=>'secret'];

        $User = new User;
        $User->UsrFirstname = 'admin';
        $User->UsrLastname = 'admin';
        $User->UsrEmail = 'test@email.gr';
        $User->UsrRoleID  = 1;
        $User->UsrPassword = Hash::make('secret');
        $User->save();

        $response = $this->post('api/login',$credentials);
        $token = $response->decodeResponseJson('token');

        return $token;
    }

    /** @test */
    public function contacts_list_with_correct_credentials()
    {
        $credentials = ['UsrEmail'=>'test@email.gr','UsrPassword'=>'secret'];

        $User = new User;
        $User->UsrFirstname = 'admin';
        $User->UsrLastname = 'admin';
        $User->UsrEmail = 'test@email.gr';
        $User->UsrRoleID  = 1;
        $User->UsrPassword = Hash::make('secret');
        $User->save();

        $response = $this->post('api/login',$credentials);
        $token = $response->decodeResponseJson('token');

        $response = $this->json(
            'GET',
            'api/contacts',
            array(),
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(200);
    }

    /** @test */
    public function contacts_list_with_wrong_credentials()
    {

        $response = $this->json(
            'GET',
            'api/contacts',
            array(),
            ['HTTP_Authorization' => 'Bearer '.'123']
        );

        $response->assertStatus(401);
    }

    /** @test */
    public function insert_a_new_contact()
    {
        $token = $this->getToken();

        $new_contact['ContactFirstname'] = 'George';
        $new_contact['ContactLastname'] = 'Manolopoulos';
        $response = $this->json(
            'POST',
            'api/add_contact',
            $new_contact,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(201);
        $this->assertCount(1, Contact::all() );
    }

    /** @test */
    public function get_an_existing_contact()
    {

        $token = $this->getToken();

        // First add a contact
        $new_contact['ContactFirstname'] = 'George';
        $new_contact['ContactLastname'] = 'Manolopoulos';
        $response = $this->json(
            'POST',
            'api/add_contact',
            $new_contact,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        // real test - get the contact
        $data = array();
        $response = $this->json(
            'GET',
            'api/contact/1',
            $data,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );


        $response->assertStatus(200);
    }

    /** @test */
    public function get_a_non_existing_contact()
    {
        $token = $this->getToken();

        // real test - get the contact
        $data = array();
        $response = $this->json(
            'GET',
            'api/contact/1',
            $data,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(404);
    }

    /** @test */
    public function delete_a_contact()
    {
        $token = $this->getToken();

        $new_contact['ContactFirstname'] = 'George';
        $new_contact['ContactLastname'] = 'Manolopoulos';
        $response = $this->json(
            'POST',
            'api/add_contact',
            $new_contact,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(201);

        $Contact = $response->decodeResponseJson('data');
        $this->assertCount(1, Contact::all() );

        $response = $this->json(
            'DELETE',
            'api/contact/'.$Contact['ContactID'],
            array(),
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(204);
        $this->assertCount(0, Contact::all() );
    }

    /** @test */
    public function update_a_contact()
    {
        $token = $this->getToken();

        $new_contact['ContactFirstname'] = 'George';
        $new_contact['ContactLastname'] = 'Manolopoulos';
        $response = $this->json(
            'POST',
            'api/add_contact',
            $new_contact,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(201);

        $Contact = $response->decodeResponseJson('data');
        $this->assertCount(1, Contact::all() );


        $edit_contact['ContactFirstname'] = 'Alfred';
        $edit_contact['ContactLastname'] = 'TheChicken';
        $response = $this->json(
            'PUT',
            'api/contact/'.$Contact['ContactID'],
            $edit_contact,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );


        $response->assertStatus(200);

        $Contact = Contact::findOrFail(1);
        $this->assertEquals($Contact->ContactFirstname, 'Alfred');
        $this->assertEquals($Contact->ContactLastname, 'TheChicken');
    }
}
