<?php
/*
 * UsersSeeder.php
 *
 * Copyright (c) 2021 tora-japan (s.noda)
 *
 * Released under the MIT license.
 * see https://opensource.org/licenses/MIT
 *
 */


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;    // DB::Tableを使う
use App\Models\User;                  // モデルを指定
use Illuminate\Support\Facades\Hash;  // ハッシュ

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();

        DB::statement('ALTER TABLE users AUTO_INCREMENT=1;');
        for($i=1;$i<=6;$i++)
        {
          User::create([
              'name' => 'tester'.$i.'号',
              'email' => $i.'@test.com',
              'password' => Hash::make('1'),
              'height' => (150+5*$i) ,
          ]);

        }
    }
}
