<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Contact;
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
    public function test_contacts_list_with_correct_credentials()
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


        $response = $this->json('GET',
                                'api/contacts',
                                array()
                                ,['HTTP_Authorization' => 'Bearer '.$token]
                            );

        $response->assertStatus(200);
    }

    /** @test */
    public function test_contacts_list_with_wrong_credentials()
    {

        $response = $this->json('GET',
                                'api/contacts',
                                array()
                                ,['HTTP_Authorization' => 'Bearer '.'123']
                            );

        $response->assertStatus(401);
    }

    public function test_insert_a_new_contact()
    {
        // $this->withoutExceptionHandling();

        $token = $this->getToken();

        $new_contact['ContactFirstname'] = 'George';
        $new_contact['ContactLastname'] = 'Manolopoulos';
        $response = $this->json('POST',
                                'api/add_contact',
                                $new_contact,
                                ['HTTP_Authorization' => 'Bearer '.$token]
                            );


        $response->assertOK();
        $this->assertCount(1, Contact::all() );
    }
}
