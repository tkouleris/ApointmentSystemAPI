<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
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
        $response = $this->json('POST',
                                'api/add_user',
                                $new_user,
                                ['HTTP_Authorization' => 'Bearer '.$token]
                            );


        $response->assertStatus(201);
        $this->assertCount( 2, User::all() );
    }

    /** @test */
    // public function test_login_attempt_with_wrong_credentials()
//     {
// //        $this->withoutExceptionHandling();

//         $credentials = ['UsrEmail'=>'test@email.gr','UsrPassword'=>'secret1'];

//         $User = new User;
//         $User->UsrFirstname = 'admin';
//         $User->UsrLastname = 'admin';
//         $User->UsrEmail = 'test@email.gr';
//         $User->UsrRoleID  = 1;
//         $User->UsrPassword = Hash::make('secret');
//         $User->save();

//         $response = $this->post('api/login',$credentials);


//         $response->assertStatus(401);
//     }

    /** @test */
    // public function test_login_attempt_with_correct_credentials()
    // {
    //     $credentials = ['UsrEmail'=>'test@email.gr','UsrPassword'=>'secret'];

    //     $User = new User;
    //     $User->UsrFirstname = 'admin';
    //     $User->UsrLastname = 'admin';
    //     $User->UsrEmail = 'test@email.gr';
    //     $User->UsrRoleID  = 1;
    //     $User->UsrPassword = Hash::make('secret');
    //     $User->save();

    //     $response = $this->post('api/login',$credentials);

    //     $response->assertStatus(200);
    //     $this->assertArrayHasKey('token', $response->decodeResponseJson() );
    // }

}
