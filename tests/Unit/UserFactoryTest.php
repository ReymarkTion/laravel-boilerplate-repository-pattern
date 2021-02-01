<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserFactoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanCreateUser()
    {
        $factory = app()->make(UserFactory::class);
        $user = $factory->create([
            'name' => 'John Doe',
            'email' => 'jdoe@shiftech-marine.com',
            'password' => 'jdoepass'
        ]);

        $this->assertTrue(Hash::check('jdoepass', $user->password));
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'jdoe@shiftech-marine.com',
        ]);
    }
}
