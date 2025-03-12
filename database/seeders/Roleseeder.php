<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roleseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create-post']);
        Permission::create(['name' => 'view-post']);
        Permission::create(['name' => 'update-post']);
        Permission::create(['name' => 'delete-post']);
        Permission::create(['name' => 'create-tag']);
        Permission::create(['name' => 'view-tag']);
        Permission::create(['name' => 'update-tag']);
        Permission::create(['name' => 'delete-tag']);
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'update-user']);
        Permission::create(['name' => 'delete-user']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(['create-post' ,'view-post','update-post','delete-post' ]);
    }


}
