<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        Artisan::call('passport:install');
        Artisan::call('db:seed');
    }

    public function testUserCanGetTokenAfterRegistrationWithUserRole()
    {
        $role = Role::find(3);
        $data = [
            'name' => 'Test Finpay',
            'email' => 'test@shiftech-marine.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => $role->name
        ];

        $response = $this->postJson('/api/auth/register', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'access_token',
                'token_type',
                'expires_at',
                'user_type'
            ]);
    }
}
