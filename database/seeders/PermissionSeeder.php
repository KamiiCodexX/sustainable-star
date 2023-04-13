<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            [
                'owner_id' => 1,
                'delegates_id' => 1,
                'create_permission' => 1,
                'update_permission' => 1,
                'delete_permission' => 1,
            ],
            [
                'owner_id' => 2,
                'delegates_id' => 2,
                'create_permission' => 1,
                'update_permission' => 0,
                'delete_permission' => 1,
            ]
        ];

        Permission::insert($permissions);
    }
}
