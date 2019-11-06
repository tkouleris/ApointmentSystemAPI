<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use JWTAuth;


class UserCRUDApiTest extends TestCase
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
    public function create_new_user_by_role_other_than_admin()
    {
        $token = $this->getToken_user_role();

        $new_user['UsrFirstname'] = 'George';
        $new_user['UsrLastname'] = 'Manolopoulos';
        $new_user['UsrEmail'] = 'gmanolopoulos@gmail.com';
        $new_user['UsrPassword'] = 'secret';
        $new_user['UsrRoleID'] = 1;
        $response = $this->json('POST',
                                'api/add_user',
                                $new_user,
                                ['HTTP_Authorization' => 'Bearer '.$token]
                            );


        $response->assertStatus(401);
    }

    /** @test */
    public function create_new_user_by_admin()
    {
        $token = $this->getToken_admin_role();

        $new_user['UsrFirstname'] = 'George';
        $new_user['UsrLastname'] = 'Manolopoulos';
        $new_user['UsrEmail'] = 'gmanolopoulos@gmail.com';
        $new_user['UsrPassword'] = 'secret';
        $new_user['UsrRoleID'] = 1;
        $response = $this->json(
                    'POST',
                    'api/add_user',
                    $new_user,
                    ['HTTP_Authorization' => 'Bearer '.$token]
        );


        $response->assertStatus(201);
        $this->assertCount( 2, User::all() );
    }


    /** @test */
    public function create_new_user_by_admin_input_check()
    {
        $token = $this->getToken_admin_role();

        $new_user['UsrFirstname'] = 'George';
        $new_user['UsrLastname'] = 'Manolopoulos';
        $new_user['UsrEmail'] = 'gmanolopoulos@gmail.com';
        $new_user['UsrPassword'] = 'secret';
        $new_user['UsrRoleID'] = 1;
        $response = $this->json('POST',
                                'api/add_user',
                                $new_user,
                                ['HTTP_Authorization' => 'Bearer '.$token]
                            );


        $response->assertStatus(201);
        $this->assertCount( 2, User::all() );
    }

        /** @test */
        public function test_user_updates_his_information()
        {
            $token = $this->getToken_user_role();

            $update_args['UsrFirstname'] = 'Miltos';
            $update_args['UsrLastname'] = 'Makridis';

            $response = $this->json(
                    'POST',
                    'api/update_user',
                    $update_args,
                    ['HTTP_Authorization' => 'Bearer '.$token]
            );

            $response->assertStatus(200);

            $User = User::where('UsrEmail','test@email.gr')->first();

            $this->assertEquals($User->UsrFirstname, 'Miltos');
            $this->assertEquals($User->UsrLastname, 'Makridis');
        }

}
