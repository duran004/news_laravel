<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Admin',
            'User',
            'Editor'
        ];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
        $user = User::find(1);
        $user->assignRole('Super Admin');
    }
}
