<?php

namespace Database\Seeders;

use App\Models\Element;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TypeDepartementSeeder::class);
        $this->call(ProductSeeder::class);

        $this->call(TypeElementSeeder::class);
        $this->call(AttributValueTypeSeeder::class);
        $this->call(AttributSeeder::class);
        $this->call(ElementSeeder::class);
    }
}
