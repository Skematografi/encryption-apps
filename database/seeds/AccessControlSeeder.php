<?php

use App\AccessControl;
use App\Permission;
use Illuminate\Database\Seeder;

class AccessControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::get();
        foreach ($permission as $row) {
            AccessControl::create([
                'role_id' => 1,
                'permission_id' => $row->id,
                'is_view' => true,
                'is_insert' => true,
                'is_edit' => true,
                'is_delete' => true
            ]);
        }
    }
}
