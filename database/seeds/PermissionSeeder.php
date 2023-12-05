<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = ['Storages', 'User', 'Roles'];
        foreach ($modules as $module) {
            Permission::create([
                'model' => $module
            ]);
        }
    }
}
