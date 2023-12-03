<?php

use App\CaesarChiper;
use Illuminate\Database\Seeder;

class CaesarChiperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listKey = [];
        for ($i = 33; $i < 127; $i++) {
            $listKey[] = chr($i);
        }

        $bookedChiper = [];
        $randomString = function() {
            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            return substr(str_shuffle(str_repeat($str, mt_rand(1,3))), 1, 3);
        };

        foreach ($listKey as $key) {
            $value = $randomString();

            if (in_array($value, $bookedChiper)) {
                for ($i = 0; $i <= 10; $i++) {
                    $value = $randomString();
                    if (!in_array($value, $bookedChiper)) {
                        break;
                    }
                }
            }

            CaesarChiper::insert([
                'key' => $key,
                'value' => $value
            ]);

            $bookedChiper[] = $value;
        }
    }
}
