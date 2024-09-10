<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = ['Dashboard','Members','Roles'];

        foreach ($modules as $module) {
            $module = Module::create(['name' => $module]);
        }
    }
}
