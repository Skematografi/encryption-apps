<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'ppic']);
        Role::create(['name' => 'admin_qc']);
        Role::create(['name' => 'leader']);

        $ppic_user = User::create([
            'username' => 'ppic',
            'name' => 'DEWITA',
            'password' => bcrypt('Asdqwe123'),
            'email' => 'ppic@mayora.com'
        ]);
        $ppic_user->assignRole('ppic');

        $admin_qc_user = User::create([
            'username' => 'admin_qc',
            'name' => 'LAYLA',
            'password' => bcrypt('Asdqwe123'),
            'email' => 'admin_qc@mayora.com'
        ]);
        $admin_qc_user->assignRole('admin_qc');

        $leader_user = User::create([
            'username' => 'leader',
            'name' => 'JONI',
            'password' => bcrypt('Asdqwe123'),
            'email' => 'leader@mayora.com'
        ]);
        $leader_user->assignRole('leader');
    }
}
