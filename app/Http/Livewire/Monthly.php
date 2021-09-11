<?php
/*
 * Monthly.php
 *
 * Copyright (c) 2021 tora-japan (s.noda)
 *
 * Released under the MIT license.
 * see https://opensource.org/licenses/MIT
 *
 * git-hub
 * https://github.com/tora-japan
 */

namespace App\Http\Livewire;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;    // ユーザー認証
use App\Models\User;                    // ユーザー
use Carbon\Carbon;                      // 日付
use App\Models\Weight;                  // 体重テーブル

class Monthly extends Component
{
    //
    // javascriptから呼びだされる関数名を登録する
    //
    protected $listeners = ['weightUpdate', 'next', 'back'];

    public $currentDate;                // カレントの日付
    public $next;                       // 翌月表示用
    public $back;                       // 先月表示用
    public $calenderArray;              // カレンダー配列
    public $ajaxJson;                   // ajax用のJson(グラフ情報)

    public function render()
    {
        return view('livewire.monthly');
    }

    // サイトにアクセスした時
    public function mount()
    {
        // カレントを作成する       
        $this->currentDate = $this->createTheMonth();
        $this->createData();
    }
    // 次(翌月)
    public function next()
    {
        // 来月にならないようにする
        if($this->currentDate->lt($this->createTheMonth()))
        {
          // カレントの月を加算
          $this->currentDate->addMonth();
        }
        // データを作成する
        $this->createData();
    }
    // 前(先月)
    public function back()
    {
        // カレントの月を減算
        $this->currentDate->subMonth();
        // データを作成する
        $this->createData();
    }

    protected  function createTheMonth()
    {
        $date = Carbon::now();
        return new Carbon(sprintf('%04d-%02d-01', $date->year, $date->month));
    }

    protected  function createDate($year, $month)
    {
        return new Carbon(sprintf('%04d-%02d-01', $year, $month));
    }
    // 時間を00:00:00にして作成する
    protected function createDateTimeZero(Carbon $date)
    {
        return new Carbon($date->format('Y-m-d'));
    }

    // データを作成する
    // $this->next         翌月ボタンのテキスト
    // $this->back         先月ボタンのテキスト
    // $this->calenderArray[データの有無, 日付, 体重] , ...
    // $this->ajaxJson     [週の位置 ,　ラベル , 体重配列(週毎) , BMI(週毎) ]
    protected  function createData()
    {
        // authから読み出す
        $userID = Auth::id();
        $user = User::find($userID);
        $height = $user->height / 100;
        if ($height <= 0) $height = 1;

        //  $userID = 6;
        //  $height = 1.5;

        // ボタン用：翌月、先月の文字列を作成する
        $this->createBackNext();

        // ループ用
        $date = $this->currentDate->copy();

        // 次の日        
        $today = $this->createDateTimeZero(Carbon::now()->addDay(1));     

        // 月の始め
        $monthStart = $date->copy();
        // 月の終端
        $monthEnd   = $date->copy()->addMonth(1)->subDay(1);
        // 月の日数
        $DaysInMonth = $monthEnd->day;
        // カレンダーの先頭の日付：左上を日曜日にする
        $calendarStart = $monthStart->copy()->subDay($monthStart->dayOfWeek);
        // カレンダーの終端の日付：右下を土曜日にする
        $calendarEnd   = $monthEnd->copy()->addDay(6 - $monthEnd->dayOfWeek);
        // カレンダーの先頭から終端までの日数
        $calendarDays = $calendarEnd->copy()->diffInDays($calendarStart);

        // カレンダー構成用の配列
        $calendar = [];

        // 日付の範囲を読み出す
        $query = Weight::getWeightQuery($userID, $calendarStart->format('Y-m-d'), $calendarEnd->format('Y-m-d'));

        // for($i = 0,$iMax = count($table);$i<$iMax;$i++) echo $table[$i]->weight .'<br>'.PHP_EOL;
        // 体重の配列 対象の月であれば全部入れる(記録抜けの情報を補完するコード付き)
        $weightArray = [];
        $uid = 'null';
        $weight = 0;
        $tMax = count($query);
        $isEdit = 1;
        $date = $calendarStart->copy();
        $isShow = 0;

        // 今からnカ月前?
        $backMonth = Carbon::now()->copy()->subMonth(6);

        for ($i = 0, $t = 0; $i <= $calendarDays; $i++, $date->addDay()) {
            $isEdit = 1;
            if (($tMax != $t) && ($query[$t]->date == $date->format('Y-m-d'))) {
                $weight = $query[$t]->weight;
                $t++;
                $isShow=1;
            } else {
                // SQLにデータが無い場合で、0 にしたい場合は、下記のコメントを外す
                // $weight=0;
                $isShow=0;
            }
            // 過去何カ月前であれば編集不可
            if ($date->lt($backMonth)) $isEdit = 0;

            // 今日の日付を超えている場合は編集不可,weightも表記しない
            if ($date->gte($today))
            {
                $isEdit = 0;
                $weight = 0;
            }
            $calendar[] = [$isShow, $date->copy(), $weight, $isEdit];
            // 同じ月のみ配列に追加する
            if ($date->month == $this->currentDate->month) $weightArray[] = $weight;
        }
        $this->calenderArray = $calendar;

        //
        // chart.js用の文字列を作成
        //
        // 範囲テーブルを作成する
        $labelArrayString = '[';
        $weightArrayString = '[';
        $bmiArrayString = '[';

        // 月間用の配列を作成する
        foreach ($calendar as $index => $p) {
            $labelArrayString .= $p[1]->format('"m/d"');
            $weightArrayString .= $p[2];
            $bmiArrayString .= $p[2] / $height / $height;

            if ($index < $calendarDays) {
                $labelArrayString .= ',';
                $weightArrayString .= ',';
                $bmiArrayString .= ',';
            }
        }
        $labelArrayString .= ']';
        $weightArrayString .= ']';
        $bmiArrayString .= ']';

        $n = 0;
        if ($this->back !== "") $n  = 1;
        if ($this->next !== "") $n += 2;

        $this->ajaxJson = '[0,' . $labelArrayString . ',' . $weightArrayString . ',' . $bmiArrayString . ',' . $n . ']';
    }

    // カレンダーの「前の月」と「次の月」の文字列を作成
    protected function createBackNext()
    {
        // 今月を作成
        $thisMonth = $this->createTheMonth();
        // カレントの次の月
        $next = ($this->currentDate->copy())->addMonth();
        // カレントの前の月
        $back = ($this->currentDate->copy())->subMonth();
        // nextボタンの表示判定
        if ($thisMonth->gte($next)) {
            if ($next->month < 10) {
                $this->next = ' ' . $next->month . '月';
            } else {
                $this->next = $next->month . '月';
            }
        } else {
            $this->next = "";
        }
        if ($thisMonth->subMonth(5)->lt($this->currentDate)) {
            if ($back->month < 10) {
                $this->back = ' ' . $back->month . '月';
            } else {
                $this->back = $back->month . '月';
            }
        } else {
            $this->back = "";
        }
    }

    //
    // 呼び出される関数名
    //
    public function weightUpdate($date,$weight)
    {
        Weight::setWeight(Auth::id(), $date, $weight);
        // データを作成する
        $this->createData();
    }
}
