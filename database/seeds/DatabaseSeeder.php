<?php

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
        $this->call(RolesSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(AccessControlSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CaesarChiperSeeder::class);
    }
}
