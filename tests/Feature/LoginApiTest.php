<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use JWTAuth;


class LoginApiTest extends TestCase
{
    use RefreshDatabase;

    public function getToken_admin_role()
    {
        $credentials = ['UsrEmail'=>'test@email.gr','UsrPassword'=>'secret'];

        $User = new User;
        $User->UsrFirstname = 'admin';
        $User->UsrLastname = 'admin';
        $User->UsrEmail = 'test@email.gr';
        $User->UsrRoleID  = 1; // Admin
        $User->UsrPassword = Hash::make('secret');
        $User->save();

        $response = $this->post('api/login',$credentials);
        $token = $response->decodeResponseJson('token');

        return $token;
    }

    public function test_login_attempt_without_credentials()
    {
        $response = $this->post('api/login');

        $response->assertStatus(400);
    }

    /** @test */
    public function test_login_attempt_with_wrong_credentials()
    {
//        $this->withoutExceptionHandling();

        $credentials = ['UsrEmail'=>'test@email.gr','UsrPassword'=>'secret1'];

        $User = new User;
        $User->UsrFirstname = 'admin';
        $User->UsrLastname = 'admin';
        $User->UsrEmail = 'test@email.gr';
        $User->UsrRoleID  = 1;
        $User->UsrPassword = Hash::make('secret');
        $User->save();

        $response = $this->post('api/login',$credentials);

        $response->assertStatus(401);
    }

    /** @test */
    public function test_login_attempt_with_correct_credentials()
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

        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response->decodeResponseJson() );
    }

    public function test_logout()
    {
        $token = $this->getToken_admin_role();

        $response = $this->json(
            'POST',
            'api/logout',
            array(),
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(200);


        $response = $this->json(
            'GET',
            'api/contacts',
            array(),
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(401);
    }
}
