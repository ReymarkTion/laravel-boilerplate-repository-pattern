<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Repositories\RoleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanGetRoles()
    {
        $roles = $this->createRoles([
            'sample add',
            'sample edit',
            'sample delete'
        ]);

        $repository = app()->make(RoleRepository::class);
        $allRoles = $repository->all();

        $this->assertModelsInArray($allRoles, $roles);
    }

    /** @test */
    public function itCanUpdateRole()
    {
        $role = $this->createRole([
            'name' => 'wrong role',
            'guard_name' => 'api'
        ]);

        $repository = app()->make(RoleRepository::class);
        $updateRole = $repository->update($role->id, [
            'name' => 'correct role'
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'correct role'
        ]);
    }

    /** @test */
    public function itCanDeleteRole()
    {
        $role = $this->createRole([
            'name' => 'Bye Role'
        ]);

        $repository = app()->make(RoleRepository::class);
        $deleteRole = $repository->delete($role->id);

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
            'name' => 'Bye Role'
        ]);
    }
}