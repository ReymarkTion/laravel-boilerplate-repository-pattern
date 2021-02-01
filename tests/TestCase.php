<?php

namespace Tests;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp() : void
    {
        parent::setUp();
    }

    protected function createUser(array $attributes = [])
    {
        $user = User::factory()->create($attributes);

        return $user;
    }

    protected function createNormalUser(array $attributes = [])
    {
        $permissions = $this->createPermissions([
            'manage profile',
            'view transaction report'
        ]);

        $role = $this->createRole([
            'name' => 'user',
            'guard_name' => 'api'
        ]);

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        $user = User::factory()->create($attributes);
        $user->assignRole($role);

        return $user;
    }

    protected function createAdminUser(array $attributes = [])
    {
        $permissions = $this->createPermissions([
            'add user',
            'edit user',
            'get user',
            'delete user',
            'approve user',
            'manage transactions',
            'view withdrawal history',
            'view payment transaction',
            'view transaction report',
            'manage profile'
        ]);

        $role = $this->createRole([
            'name' => 'admin',
            'guard_name' => 'api'
        ]);

        $user = $this->createUser($attributes);

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        $user->assignRole($role);

        return $user;
    }

    protected function createVendor(array $attributes = [])
    {
        $permissions = $this->createPermissions([
            'edit',
        ]);

        $role = $this->createRole([
            'name' => 'vendor',
            'guard_name' => 'api'
        ]);

        $user = $this->createUser($attributes);

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        $user->assignRole($role);

        return $user;
    }

    protected function createRole(array $attributes = [])
    {
        $role = Role::factory()->create($attributes);

        return $role;
    }

    protected function createRoles(array $roleNames = [])
    {
        $roles = [];
        foreach ($roleNames as $role) {
            $role = $this->createRole([
                'name' => $role,
                'guard_name' => 'api'
            ]);
            array_push($roles, $role);
        }

        return $roles;
    }

    protected function createPermission(array $attributes = [])
    {
        $permission = Permission::factory()->create($attributes);

        return $permission;
    }

    protected function createPermissions(array $permissionNames = [])
    {
        $permissions = [];
        foreach ($permissionNames as $permissionName) {
            $permission = $this->createPermission([
                'name' => $permissionName,
                'guard_name' => 'api'
            ]);
            array_push($permissions, $permission);
        }

        return $permissions;
    }

    protected function createUsers($numberToCreate = 5)
    {
        $users = [];

        for ($counter = 0; $counter < $numberToCreate; $counter++) {
            $user = $this->createUser();
            array_push($users, $user);
        }

        return $users;
    }

    public function assertModelsInArray($array, $models)
    {
        foreach ($array as $element) {
            $matched = false;
            foreach ($models as $model) {
                if (isset($element->id)) {
                    if ($model->id == $element->id) {
                        $matched = true;
                        break;
                    }
                }
            }
            $this->assertTrue($matched);
        }
    }
}
