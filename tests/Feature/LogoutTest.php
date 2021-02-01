<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        Artisan::call('passport:install');
    }

    public function testUserCanLogoutWithAuthenticatedAccount()
    {
        $user = $this->createNormalUser([
            'email' => 'normaluser@shiftech-marine.com',
            'password' => bcrypt('password'),
            'status' => 1
        ]);

        Passport::actingAs($user);
        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'User Logout Successfully'
            ]);
    }

    public function testUserCannotLogoutWithNonAuthenticatedAccount()
    {
        $user = $this->createNormalUser([
            'email' => 'normaluser@shiftech-marine.com',
            'password' => bcrypt('password'),
            'status' => 1
        ]);

        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(401);
    }
}