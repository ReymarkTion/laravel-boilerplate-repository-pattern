<?php

namespace Tests\Unit;

use App\Repositories\UserRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanGetUsers()
    {
        $users = $this->createUsers();
        $repository = app()->make(UserRepository::class);
        $getUsers = $repository->all();

        $this->assertModelsInArray($getUsers, $users);
    }

    /** @test */
    public function itCanGetUser()
    {
        $user = $this->createUser();
        $repository = app()->make(UserRepository::class);
        $getUser = $repository->get($user->id);

        $this->assertEquals($getUser->name, $user->name);
    }

    /** @test */
    public function itCanUpdateUser()
    {
        $user = $this->createUser();
        $repository = app()->make(UserRepository::class);
        $updateUser = $repository->update($user->id, [
            'name' => 'My Name',
            'email' => 'myemail@shiftech-marine.com',
            'password' => 'mypassword'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'My Name',
            'email' => 'myemail@shiftech-marine.com'
        ]);

        $this->assertTrue(Hash::check('mypassword', $updateUser->password));
    }

    /** @test */
    public function itCanDeleteUser()
    {
        $user = $this->createUser();
        $repository = app()->make(UserRepository::class);
        $deleteUser = $repository->delete($user->id);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}