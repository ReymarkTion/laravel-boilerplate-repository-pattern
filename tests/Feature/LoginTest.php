<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        Artisan::call('passport:install');
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = $this->createNormalUser([
            'email' => 'normaluser@shiftech-marine.com',
            'password' => bcrypt('password'),
            'status' => 1
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'message',
                'access_token',
                'token_type',
                'expires_at',
                'user_type'
            ]);
    }

    public function testUserCannotLoginWithIncorrectCredentials()
    {
        $user = $this->createNormalUser([
            'email' => 'normaluser@shiftech-marine.com',
            'password' => bcrypt('password'),
            'status' => 1
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'drowssap'
        ]);

        $response->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'Invalid credentials'
            ]);
    }

    public function testUserCannotLoginWithInactiveAccount()
    {
        $user = $this->createNormalUser([
            'email' => 'normaluser@shiftech-marine.com',
            'password' => bcrypt('password'),
            'status' => 0
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Your account requires approval, please contact admin.'
            ]);
    }
}