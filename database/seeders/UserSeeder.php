<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $user = User::create([
            'name' => 'Duran Can YILMAZ',
            'email' => 'test@gmail.com',
            'password' => Hash::make('123456')
        ]);
        $user->assignRole('Super Admin');
        $role = Role::find(1);
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
    }
}