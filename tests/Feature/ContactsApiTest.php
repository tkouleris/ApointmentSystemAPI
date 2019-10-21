<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\Hash;
use JWTAuth;


class ContactsApiTest extends TestCase
{
    use RefreshDatabase;

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
}
