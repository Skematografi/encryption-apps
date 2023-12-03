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
        Role::create(['name' => 'superadmin']);

        $ppic_user = User::create([
            'username' => 'admin',
            'name' => 'SUPERADMIN',
            'password' => bcrypt('Asdqwe123'),
            'phone' => '08123456789',
            'email' => 'admin@encrypt.com'
        ]);
        $ppic_user->assignRole('superadmin');
    }
}
