<x-myapp.guest title='毎日体重を記録しよう！' skipName='トップページ'>

<div class="sm:min-h-screen  flex sm:justify-center items-center sm:pt-0 bg-green-600 ">
  
  <div class="w-full sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl bg-white overflow-hidden sm:rounded-lg">

    <a href="{!!url('/')!!}">
      <div class="flex justify-center items-center">
          <img class="w-6/12" src="{!!url('/')!!}/img/kaden_taijukei.png">
      </div>
    </a>

    <div class="mt-4 p-4 bg-green-500  text-white">
        <p>１日１回、体重を計った時に記録を入力するwebアプリです。</p>
        <p>毎日記録していけば、体重をグラフ化して見ることができます。</p>
        <div class ="bg-white">
          <canvas id="myChart"  height="150px"></canvas>
        </div>
    </div>
    
  </div>
</div>


<script src='{!!url('/')!!}/chartjs/chart.min.js'></script>
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


</x-myapp.guest>
