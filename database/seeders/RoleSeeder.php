<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Role::create(['name' => 'Admin']);
        \App\Models\Role::create(['name' => 'Manager']);
        \App\Models\Role::create(['name' => 'QA']);
        \App\Models\Role::create(['name' => 'InternDeveloper']);
        \App\Models\Role::create(['name' => 'SeniorDeveloper']);
        \App\Models\Role::create(['name' => 'Employee']);
        \App\Models\Role::create(['name' => 'Designer']);
    }
}
