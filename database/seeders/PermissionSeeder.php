<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['role-list', 2],
            ['role-create', 1],
            ['role-edit', 1],
            ['role-delete', 1],
            ['type_element-list', 4],
            ['type_element-create', 3],
            ['type_element-edit', 3],
            ['type_element-delete', 3],
            ['attribut-list', 4],
            ['attribut-create', 3],
            ['attribut-edit', 3],
            ['attribut-delete', 3]
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission[0], 'level' => $permission[1]]);
        }
    }
}
