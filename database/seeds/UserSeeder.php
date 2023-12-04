<?php

use Illuminate\Database\Seeder;
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
        User::create([
            'username' => 'admin',
            'name' => 'SUPERADMIN',
            'password' => bcrypt('123'),
            'phone' => '08123456789',
            'email' => 'admin@encrypt.com',
            'role_id' => 1,
        ]);
    }
}
