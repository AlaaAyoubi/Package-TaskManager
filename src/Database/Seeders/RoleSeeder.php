<?php

namespace Alaa\TaskManager\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = config ('constants.roles');

        foreach ($roles as $role){
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
