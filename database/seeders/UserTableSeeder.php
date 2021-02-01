<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', '=', 'admin')->first();
        $merchantRole = Role::where('name', '=', 'merchant')->first();
        $userRole = Role::where('name', '=', 'user')->first();

        $admin = new User();
        $admin->name = "Administrator";
        $admin->email = "admin@shiftech-marine.com";
        $admin->password = bcrypt("password123");
        $admin->status = 1;
        $admin->save();
        $admin->assignRole($adminRole);

        $merchant = new User();
        $merchant->name = "Merchant";
        $merchant->email = "merchant@shiftech-marine.com";
        $merchant->password = bcrypt("password123");
        $merchant->status = 1;
        $merchant->save();
        $merchant->assignRole($merchantRole);

        $user = new User();
        $user->name = "User";
        $user->email = "user@shiftech-marine.com";
        $user->password = bcrypt("password123");
        $user->status = 1;
        $user->save();
        $user->assignRole($userRole);
    }
}
