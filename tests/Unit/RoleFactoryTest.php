<?php

namespace Tests\Unit;

use App\Factories\RoleFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleFactoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanCreateRole()
    {
        $factory = app()->make(RoleFactory::class);

        $role = $factory->create([
            'name' => 'My Role',
            'guard_name' => 'api'
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'My Role',
            'guard_name' => 'api'
        ]);
    }
}