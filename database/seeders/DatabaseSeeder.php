<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $cashierRole = Role::create(['name' => 'cashier']);

        // Create permissions
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'manage stock']);
        Permission::create(['name' => 'process sales']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(['view reports', 'manage stock', 'process sales']);
        $cashierRole->givePermissionTo(['manage stock', 'process sales']);

        // Create admin user
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole($adminRole);

        // Create cashier user
        $cashier = \App\Models\User::create([
            'name' => 'Cashier',
            'email' => 'cashier@example.com',
            'password' => bcrypt('password')
        ]);
        $cashier->assignRole($cashierRole);
    }
}
