<?php

/*
 * WeightSeeder.php
 *
 * Copyright (c) 2021 tora-japan (s.noda)
 *
 * Released under the MIT license.
 * see https://opensource.org/licenses/MIT
 *
 */



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('weights')->delete();
      // id ..1  2020-12-15 から 210日分のデータを作成 穴あり 
      // id ..2  2020-12-15 から 300日分のデータを作成 穴なし 
      $this->insertDummyPattern1(1,'2020-12-15',30* 7,60);
      $this->insertDummyPattern2(2,'2020-12-15',30*10,60);
      // id ..3  2020-12-15 から 90日分のデータを作成  穴あり 年越しチェック用
      // id ..4  2020-12-15 から 90日分のデータを作成  穴なし 年越しチェック用
      $this->insertDummyPattern1(3,'2020-12-15',90,40);
      $this->insertDummyPattern2(4,'2020-12-15',90,40);
    }

    // ダミーデータを挿入する(穴なし)
    public function insertDummyPattern1($userID,$dateString,$addDay,$weightDef)
    {
      // ダミーデータ作る
      $day = strtotime($dateString);
      for($i=0;$i<$addDay;$i++)
      {
        // 体重に乱数を加える 規定値+1.5k
        $weight = ($weightDef * 10 + rand(0,15))/10;
        // 日付をセット
        $date = date("Y-m-d",$day);
        // テーブルに挿入
        DB::table('weights')->insert([
          'uid'  =>uniqid(),
          'id'   =>$userID,
          'date' =>$date,
          'weight'=>$weight
        ]);
        $day = strtotime($date.'+1day');
      }
    }
    // ダミーデータを挿入する(穴あり)
    public function insertDummyPattern2($userID,$dateString,$addDay,$weightDef)
    {
      // ダミーデータ作る
      $day = strtotime($dateString);
      for($i=0;$i<$addDay;$i++)
      {
        // 体重に乱数を加える 規定値+1.5k
        $weight = ($weightDef * 10 + rand(0,15))/10;
        // 日付をセット
        $date = date("Y-m-d",$day);

        if( ($i % 3) == 0 ){
          // テーブルに挿入
          DB::table('weights')->insert([
            'uid'  =>uniqid(),
            'id'   =>$userID,
            'date' =>$date,
            'weight'=>$weight
          ]);
        }
        $day = strtotime($date.'+1day');
      }
    }
}
