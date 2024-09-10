<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionInRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //permission assign to dlc
        $dlc = Role::whereName('Test-User')->first();
        $dlc->syncPermissions(
            [
                'test_access',
            ]
        );
    }
}
