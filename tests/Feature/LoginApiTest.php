<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_login_attempt_without_credentials()
    {
        $response = $this->post('api/login');

        $response->assertStatus(400);
    }

    public function test_login_attempt_with_wrong_credentials()
    {
        $response = $this->post('api/login',
                                ['UsrEmail'=>'test@email.gr'
                                ,'UsrPassword'=>'secret']);

        $response->assertStatus(401);
    }


    public function test_login_attempt_with_correct_credentials()
    {
        $response = $this->post('api/login',
                                ['UsrEmail'=>'admin@as.com'
                                ,'UsrPassword'=>'secret']);

        $response->assertStatus(200);
    }
}
