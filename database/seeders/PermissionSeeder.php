<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public array $permissions = ['index', 'create', 'show', 'edit', 'update', 'destroy'];
    public array $controllers = ['User', 'Role', 'Permission', 'Category', 'MainCategory', 'News', 'Image'];
    public function run(): void
    {
        foreach ($this->controllers as $controller) {
            foreach ($this->permissions as $permission) {
                Permission::create(['name' => $controller . '-' . $permission]);
            }
        }
    }
}