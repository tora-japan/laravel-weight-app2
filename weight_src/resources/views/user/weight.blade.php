<x-myapp.login2 title='毎日体重を記録しよう！' skipName='体重記録'>

<x-slot name="head_option"></x-slot>

<form method="POST" action="weight">@csrf

<div class="sm:min-h-screen  flex sm:justify-center items-center sm:pt-0 bg-green-600 ">
  
  <div class="w-full sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl bg-white overflow-hidden sm:rounded-lg">

    <div class="flex justify-center items-center">
          <img class="w-6/12" src="{!!url('/')!!}/img/kaden_taijukei.png">
    </div>

    <div class="mt-4 p-4 bg-green-500 rounded ">
      <div class="mt-4">
        <x-label for="weight" value="今日の体重を入力(kg)" />
        @if($weight=='')
        <x-input id="weight" class="block mt-1 w-full"
                        type="number"
                        step="0.1"
                        name="weight" required />
        <div class="flex items-center justify-center mt-4"> 
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white pl-4 pr-4 pt-2 pb-2 rounded shadow-md " >送　信</button>
        </div>
        @else
        <x-input id="weight" class="block mt-1 w-full"
                        type="number"
                        value="{{$weight}}"
                        step="0.1"
                        name="weight" required />
        <div class="flex items-center justify-center mt-4"> 
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white pl-4 pr-4 pt-2 pb-2 rounded shadow-md " >更　新</button>
        </div>
        
        @endif

        {!! $msg !!}<br>

<div style="background:#FFF;"><canvas id="myChart" height="150px"></canvas></div>

        
      </div>
    </div>

  </div>
</div>

</form>


<script>
var ctx = document.getElementById('myChart').getContext('2d');
data ={
    labels: [],
    datasets: [
      {
        label: '体重',
        data: [],
        borderColor: '#f00',
        yAxisID: 'y',
      },
      {
        label: 'BMI',
        data: [],
        borderColor: '#00f',
        yAxisID: 'y2',
      },
    ],
};
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
function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}

height = 1.64;
// てきとーにデータを作る
for(i=0;i<31;i++)
{
  data.labels[i]='xx月'+(i+1)+'日';
  weight = 60 + (getRandomInt(20)/10) +(30-i)/10 ;
  data.datasets[0].data[i]= weight;
  bmi = weight /height/height;
  data.datasets[1].data[i]=bmi;
}
weight_min=Math.round(data.datasets[0].data.reduce(min_number)) -1;
weight_max=Math.round(data.datasets[0].data.reduce(max_number)) +1;
var myChart = new Chart(ctx, {
  type: 'line',
  data: data,
  options: {
    scales: {
      y: {
        min: weight_min,
        max: weight_max,
        ticks: {
          color: '#f00',
          callback: function(value, index, values){
              return  value +  'kg';
          },
        },
      },
      y2: {
        min: 15,
        max: 40,
        position: 'right',
        ticks: {
          color: '#00f',
        },
      },
    },
  },
});
</script>


</x-myapp.login2>
