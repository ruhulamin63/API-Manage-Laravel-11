<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['guard_name' => 'web', 'name' => 'Admin'],
        ];

        foreach ($roles as $key => $role) {
            $role = Role::where('name', $role['name'])->exists();
            if($role){
                unset($roles[$key]);
            }
        }

        Role::insert($roles);

        $modules = [
            'Roles' => [
                ['name' => 'roles_access', 'guard_name' => 'web'],
                ['name' => 'roles_create', 'guard_name' => 'web'],
                ['name' => 'roles_edit', 'guard_name' => 'web'],
                ['name' => 'roles_delete', 'guard_name' => 'web'],
                ['name' => 'permission_assign', 'guard_name' => 'web'],
            ],

            'User' => [
                ['name' => 'user_access', 'guard_name' => 'web'],
                ['name' => 'user_create', 'guard_name' => 'web'],
                ['name' => 'user_edit', 'guard_name' => 'web'],
                ['name' => 'user_delete', 'guard_name' => 'web'],
            ],
        ];

        foreach ($modules as $key => $permissions) {
            $module = Module::where('name', $key)->first();
            if(!$module){
                $module = Module::create(['name' => $key]);
            }
            foreach ($permissions as $permission){
                $permissionCheck = Permission::where('name', $permission['name'])->exists();
                if(!$permissionCheck){
                    Permission::create(['name' => $permission['name'], 'guard_name' => $permission['guard_name'], 'module_id' => $module->id]);
                }
            }
        }
    }
}
