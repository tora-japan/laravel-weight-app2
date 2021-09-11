<?php

/*
 * Weight.php
 *
 * Copyright (c) 2021 tora-japan (s.noda)
 *
 * Released under the MIT license.
 * see https://opensource.org/licenses/MIT
 *
 */


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;
    protected $table = 'weights';
    protected $keyType = 'string';
    public $incrementin = false;
    public $timestamps = false;
    protected $primaryKey = 'uid';

    /**
       * 複数代入可能な属性
       *
       * @var array
       */
    protected $fillable = ['uid','id','weight','date'];

    // $idと$dateの一致するレコードに体重の値を入れる
    static public function setWeight($id, $date, $weight)
    {
      // レコードを検索する
      $rec = Weight::where([['id', $id], ['date', $date]])->first();

      if ($rec === null) {
        // 新規で登録
        $rec = Weight::create(['uid' => uniqid(), 'id' => $id, 'date' => $date, 'weight' => $weight]);
      } else {
        // 体重のみ更新する
        $rec->weight = $weight;
        $rec->save();
      }
      return $rec;
    }

    static public function getWeight($id, $date)
    {
        return Weight::select('weight')->where('id', '=', $id)->where('date', '=', $date)->first();
    }



    // dateStart～dateEndのクエリー結果を得る
    static public function getWeightQuery($id,$dateStart,$dateEnd)
    {
    /*
      return Weight::select('uid', 'weight', 'date')
      ->where('id', '=', $id)
        ->whereDate('date', '>=', $dateStart)
        ->whereDate('date', '<=', $dateEnd)
        ->orderBy('date', 'asc')->get();      
        */
    return Weight::select('uid', 'weight', 'date')
    ->where('id', '=', $id)
      ->where('date', '>=', $dateStart)
      ->where('date', '<=', $dateEnd)
      ->orderBy('date', 'asc')->get();      

    }
}
