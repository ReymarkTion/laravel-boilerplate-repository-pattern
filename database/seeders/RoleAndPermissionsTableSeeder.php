<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionsTableSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->createPermissions([
            'user.add',
            'user.update',
            'user.get',
            'user.delete',
            'user.create-role',
            'user.update-role',
            'user.approve',
            'profile.update',
            'profile.get',
            'blog.post',
            'blog.read',
            'blog.update',
            'blog.delete',
        ]);

        $admin = new Role();
        $admin->name = 'admin';
        $admin->guard_name = 'api';
        $admin->save();
        $admin->givePermissionTo(Permission::all());

        $merchant = new Role();
        $merchant->name = 'merchant';
        $merchant->guard_name = 'api';
        $merchant->save();
        $merchant->givePermissionTo([
            'user.add',
            'user.update',
            'user.get',
            'user.delete',
            'user.approve',
            'profile.update',
            'profile.get',
        ]);

        $user = new Role();
        $user->name = 'user';
        $user->guard_name = 'api';
        $user->save();
        $user->givePermissionTo([
            'user.approve',
            'profile.update',
        ]);
    }

    private function createPermission(array $attributes = [])
    {
        $permission = new Permission();
        $permission->fill($attributes);
        $permission->save();

        return $permission;
    }

    private function createPermissions(array $permissionNames = [])
    {
        foreach ($permissionNames as $permissionName) {
            $permission = $this->createPermission([
                'name' => $permissionName,
                'guard_name' => 'api'
            ]);
        }
    }
}
