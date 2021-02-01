<?php

namespace Tests\Unit;

use App\Factories\PermissionFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionFactoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanCreatePermission()
    {
        $factory = app()->make(PermissionFactory::class);

        $role = $factory->create([
            'name' => 'Can Add',
            'guard_name' => 'api'
        ]);

        $this->assertDatabaseHas('permissions', [
            'name' => 'Can Add',
            'guard_name' => 'api'
        ]);
    }
}
