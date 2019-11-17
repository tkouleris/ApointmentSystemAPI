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
        $credentials = ['UsrEmail'=>'admin@email.gr','UsrPassword'=>'secret'];

        $User = new User;
        $User->UsrFirstname = 'admin';
        $User->UsrLastname = 'admin';
        $User->UsrEmail = 'admin@email.gr';
        $User->UsrRoleID  = 1; // Admin
        $User->UsrPassword = Hash::make('secret');
        $User->save();

        $response = $this->post('api/login',$credentials);
        $token = $response->decodeResponseJson('token');

        return $token;
    }

    public function getToken_user_role()
    {
        $credentials = ['UsrEmail'=>'user@email.gr','UsrPassword'=>'secret'];

        $User = new User;
        $User->UsrFirstname = 'user';
        $User->UsrLastname = 'user';
        $User->UsrEmail = 'user@email.gr';
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

    /**
    * @test
    */
    public function update_appointment()
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

        $appnt = Appointment::where('ApntID',1)->first();

        $upd_params['ApntContactID'] = 2;
        $upd_params['ApntDate'] = '2021-01-01 11:54:00';
        $response = $this->json(
            'PUT',
            'api/appointment/'.$appnt->ApntID,
            $upd_params,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(200);

        $appnt = Appointment::where('ApntID',1)->first();

        $this->assertEquals($appnt->ApntContactID, 2);

    }

    /**
    * @test
    */
    public function delete_appointment_by_admin()
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

        $token = $this->getToken_admin_role();


        $response = $this->json(
            'DELETE',
            'api/appointment/1',
            $data_params,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(204);
        $this->assertCount(0, Appointment::all() );
    }

    /**
    * @test
    */
    public function delete_appointment_by_user_other_than_the_one_created_the_appointment()
    {

        $token = $this->getToken_admin_role();

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

        $token = $this->getToken_user_role();

        $response = $this->json(
            'DELETE',
            'api/appointment/1',
            $data_params,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(401);
        $this->assertCount( 1, Appointment::all() );
    }

    /** @test */
    public function appointments_list_with_correct_credentials()
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
            'api/appointments',
            array(),
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(200);
    }

    public function test_get_an_existing_appointment()
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

        // real test - get the appointment
        $data = array();
        $response = $this->json('GET',
            'api/appointment/1',
            $data,
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(200);
    }
}
