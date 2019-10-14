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
}
