@php
// カレンダーを更新したら、更新データ(json)を返すためのデスパッチイベント
$this->dispatchBrowserEvent('updated', ['ajaxJson' => $ajaxJson]);
@endphp

<div>

    {{-- ダイアログ --}}
    <div id='dlg_main' class="absolute">
        <div id="dlg1" class="hidden z-30 absolute w-96 h-56 rounded-lg bg-white">

            <div class="bg-blue-600 rounded-t-lg p-2 text-white text-2xl">体重を変更する</div>      
            <div class="m-4 text-black">
                <div id='dlg1_date' class="text-black text-2xl">xxxx年xx月xx日</div><br>
                <input type="number" class="w-full" name="weight" id="weight" step="0.1">
            </div>
            <div class="flex justify-end ">
                <button class="p-2 w-20 text-white bg-blue-500 hover:bg-blue-600 rounded-lg" onclick='dlg1_click()'>ok</button>
                <button class="p-2 w-20 text-white mx-4 bg-red-500 hover:bg-red-600 rounded-lg" onclick='dlgClose()'>cancel</button>
            </div>

        </div>
    </div>


    {{-- カレンダーのヘッダー部分 --}}
    <div class="flex justify-between">
      @if($back!=="")
        <button wire:click="back" class="bg-blue-600 hover:bg-blue-700 text-white pl-4 pr-4 pt-2 pb-2 w-24 rounded shadow-md text-center">◀ {!! $back !!}</button>
      @else
        <div class="pl-4 pr-4 pt-2 pb-2 w-24"></div>
      @endif
      <div class="pl-4 pr-4 pt-2 pb-2 text-center sm:text-2xl">{!! $currentDate->format('Y年m月') !!}</div>
      @if($next!=="")
        <button wire:click="next" class="bg-blue-600 hover:bg-blue-700 text-white pl-4 pr-4 pt-2 pb-2 w-24 rounded shadow-md text-center">{!! $next !!}▶</button>
      @else
        <div class="pl-4 pr-4 pt-2 pb-2 w-24"></div>
      @endif
    </div>

    <div class="mt-4"></div>
    {{-- カレンダーを構成する--}}
    <table class="table-auto w-full calendar text-sm">
        <thead>
            <tr>
                @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
                <th class="text-center border "><b>{!! $dayOfWeek !!}</b></th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($calenderArray as $index => $p)
              @if($p[1]->dayOfWeek == 0)
                <tr>
              @endif
                <td class="border text-center h-12 w-8
                @php
                    $bg = '';
                    if($p[1]->month != $currentDate->month) $bg ='bg-gray-500';
                    if($p[3]==0) $bg='bg-gray-300';
                    echo $bg;
                @endphp "
                @if($p[3])
                    id='ui{{ $index }}'
                    onclick="myClick('#ui{{$index}}')"
                @endif
                date='{{$p[1]->format('Y-m-d')}}' weight='{{$p[2]}}'>

                @if($p[1]->day < 10)
                    <div class="font-bold">&nbsp;{{$p[1]->day}}</div>
                @else
                    <div class="font-bold">{{$p[1]->day}}</div>
                @endif

                @if ($p[0])
                    <div> {{ $p[2] }} </div>
                @else
                    <div>　</div>
                @endif
                </td>
              @if($p[1]->dayOfWeek == 6) </tr> @endif
            @endforeach
        </tbody>
    </table>

    <div style="background:#FFF;"><canvas id="myChart" height="150px" class="swipe"></canvas></div>

    <script>
var ctx;
var weight_min,weight_max;      // bmi  最小値、最大値
var bmi_min,bmi_max;            // 体重 最小値、最大値
var date_position;              // 日付の位置
var date_positionThis=null;     // 日付の thisを保存
var data;                       // グラフ用のデータ

$(function() {
    data = {!!$ajaxJson!!};
    chartjsInit();
    // livewireの更新データを受け取る
    window.addEventListener('updated', event => {
//        console.log(    event.detail.ajaxJson );
        data = JSON.parse(event.detail.ajaxJson);
        // console.log('livewireの更新データを受け取る');
        // console.log(data);
        
        // チャートのデータを更新する
        chartjsUpdate();
        date_positionThis=null;
    });

    $(".swipe").on("touchstart", touchstart);
    $(".swipe").on("touchmove", touchmove);
    $(".swipe").on("touchend", touchend);
})

// chart.jsの初期化
function chartjsInit()
{
//    console.log('グラフの初期化');
//    console.log(data);
    ctx = document.getElementById('myChart').getContext('2d');    
    // 最大値、最小値を計算
    calc_maxmin();
    // 登録
    // chart.jsの定義 開始 ---------------------------------------------------
    myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data[1],
            datasets: [
            {
                label: '体重',
                data: data[2],
                borderColor: '#f00',
                yAxisID: 'y',
            },
            {
                label: 'BMI',
                data: data[3],
                borderColor: '#00f',
                yAxisID: 'y2',
            },],
        },
        options: {
            scales: {
                y: {
                    min: weight_min,
                    max: weight_max,
                    ticks: {
                        color: '#f00',
                        callback: function(value, index, values){
                            return value + 'kg';
                        },
                    },
                },
                y2: {
                    min: bmi_min,
                    max: bmi_max,
                    position: 'right',
                    ticks: {
                        color: '#00f',
                    },
                },
            },
        },
    });
    // chart.jsの定義 終了 ---------------------------------------------------
}


// chart.jsのデータを更新
function chartjsUpdate()
{
//    console.log('グラフの更新');
    // 最大値、最小値を計算
//    console.log(data);
    calc_maxmin();
    myChart.data.labels=data[1];
    myChart.data.datasets[0].data = data[2];
    myChart.data.datasets[1].data = data[3];
    myChart.options.scales.y.min=weight_min;
    myChart.options.scales.y.max=weight_max;
    myChart.options.scales.y2.min=bmi_min;
    myChart.options.scales.y2.max=bmi_max;    

    myChart.update();
}

// 最大最小の計算
function calc_maxmin()
{
    //console.log('最大最小の計算');
    // data[0] .. 未定義
    // data[1] .. ラベル名
    // data[2] .. 体重の配列
    // data[3] .. bmiの配列
    weight_min=Math.round(data[2].reduce(min_number)) -1;
    weight_max=Math.round(data[2].reduce(max_number)) +1;
    if(weight_max<=1) weight_max=0; 
    
    if(weight_min<0) {
      weight_min=0;
      if(1<=weight_max){
        weight_min=Math.round(data[2].reduce(min_number_nonzero)) -1;
        if(weight_min<0) weight_min=0;
      }
    }

    // bmi_min   =Math.round(data[3].reduce(min_number))-5;
    // bmi_max   =Math.round(data[3].reduce(max_number))+5;
    // if(bmi_max<=5) bmi_max=0; if(bmi_min<0) bmi_min=0;

    // bmiは固定に変更
    bmi_min   = 15; // 18未満痩せすぎ
    bmi_max   = 40; // 40以上は肥満
//    console.log('weight_min', weight_min, 'weight_max', weight_max, 'bmi_min', bmi_min, 'bmi_max', bmi_max);
}

// 最大値
function max_number(a,b)
{
    return a>b?a:b;
}
// 最小値
function min_number(a,b)
{
    return a<b?a:b;
}
// 0を抜いた最小値
function min_number_nonzero(a,b)
{
  if(a==0) return b;
  if(b==0) return a;
  return a<b?a:b;
}

// カレンダーをクリックしたときの動作
function myClick(myID)
{
    //console.log(myID);
    // 自身のセレクター
    myThis= $(myID);
    if(date_positionThis!==null){
        // 
        if(date_positionThis.attr("id") == myThis.attr("id"))
        {
            myThis.css({'background-color': '#F00','color': '#FFF'});

            // var date= new Date(myThis.attr("date"));
            // $('#dlg1_date').text(date.getFullYear() + '年' + date.getMonth() + '月' + date.getDay() + '日');          

            var date= new Date(myThis.attr("date"));
            $('#dlg1_date').text(date.getFullYear() + '年' + (date.getMonth()+1) + '月' + date.getDate() + '日');

//            $('#dlg1_date').text(myThis.attr("date"));
            $('#weight').val(myThis.attr("weight"));
            dlgOpen(1,300,230);
            return;
        }
        // 以前の選択色を戻す
//        console.log( tmpBgColor,tmpColor );

        // 編集不可の場合の色は元に戻す

        $(date_positionThis).css({'background-color': tmpBgColor,'color': tmpColor});

//        $(date_positionThis).css({'background-color': '#FFF','color': '#000'});
    }
    // クリックした週の色を選択色にする
    tmpBgColor = myThis.css('background-color');
    tmpColor = myThis.css('color');

    myThis.css({'background-color': '#000','color': '#FFF'});    
    // 保存する
    date_positionThis=myThis;
}
function dlg1_click()
{
    // let date= $('#dlg1_date').text();
    let date = myThis.attr("date");
    let weight = $('#weight').val();

    dlgClose();
    Livewire.emit('weightUpdate',date,weight);
}

posX=0;
moveX=0;
function touchstart(event)
{
    posX = event.originalEvent.touches[0].pageX;
}

function touchmove(event)
{
    moveX = event.originalEvent.touches[0].pageX;
}

function touchend(event)
{
  if (posX - moveX > 180)
  {
      if( (data[4] & 2) == 2) Livewire.emit('next');
      return;
  }
  if (posX - moveX < -180){
      if( (data[4] & 1) == 1) Livewire.emit('back');
      return;
  }
}

    </script>

</div>