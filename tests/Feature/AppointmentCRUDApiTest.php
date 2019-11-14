<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use JWTAuth;


class AppointmentCRUDApiTest extends TestCase
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

    public function getToken_user_role()
    {
        $credentials = ['UsrEmail'=>'test@email.gr','UsrPassword'=>'secret'];

        $User = new User;
        $User->UsrFirstname = 'admin';
        $User->UsrLastname = 'admin';
        $User->UsrEmail = 'test@email.gr';
        $User->UsrRoleID  = 2; // User
        $User->UsrPassword = Hash::make('secret');
        $User->save();

        $response = $this->post('api/login',$credentials);
        $token = $response->decodeResponseJson('token');

        return $token;
    }

    /**
    * @test
    */
    public function create_new_appointment()
    {
        $token = $this->getToken_user_role();

        $data_params['ApntDate'] = '2019-01-01 11:54:00';
        $data_params['ApntContactID'] = 1;
        $data_params['Comments'] = 'Examination';
        $response = $this->json(
                        'POST',
                        'api/add_appointment',
                        $data_params,
                        ['HTTP_Authorization' => 'Bearer '.$token]
                    );


        $response->assertStatus(201);
        $this->assertCount( 1, Appointment::all() );
    }


}
