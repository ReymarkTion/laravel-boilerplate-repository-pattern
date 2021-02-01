<?php

namespace Tests\Unit;

use App\Repositories\PermissionRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanGetPermissions()
    {
        $permissions = $this->createPermissions([
            'can add',
            'can edit',
            'can delete'
        ]);

        $repository = app()->make(PermissionRepository::class);
        $all = $repository->all();

        $this->assertModelsInArray($all, $permissions);
    }

    /** @test */
    public function itCanUpdatePermission()
    {
        $permission = $this->createPermission([
            'name' => 'can be modified',
            'guard_name' => 'api'
        ]);

        $repository = app()->make(PermissionRepository::class);
        $repository->update($permission->id, [
            'name' => 'I did modify it'
        ]);

        $this->assertDatabaseHas('permissions', [
            'name' => 'I did modify it'
        ]);
    }
}
