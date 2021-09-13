<x-myapp.login title='ヘルプ' skipName='ヘルプ'>  

<div class="sm:min-h-screen  flex sm:justify-center items-center sm:pt-0 bg-green-600 ">
  <div class="w-full sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl bg-white overflow-hidden sm:rounded-lg">
    <div class="flex justify-center items-center">
        <img class="w-6/12" src="{!!url('/')!!}/img/hakase_book_dokusyo.png">
    </div>

    <div class="mt-4 p-4 bg-blue-200  rounded-lg ">
      <div class="mt-4">
        <b>BMIについて</b>
        <p>BMI（Body Mass Index）とは、成人向けのボディ・マス指数と言われるものです。</p>
        <p>[体重(kg)]÷[身長(m)の2乗]で算出される値で、肥満や低体重（やせ）の判定に用いる。</p>

        <table class="mt-4 w-full border-collapse border border-green-800">
          <thead>
            <tr class="bg-black text-white">
              <th>数値</th>
              <th>判定</th>
            </tr>
          </thead>
          <tbody>            
            <tr class="bg-white text-black"><td>18.5未満</td><td>低体重（やせ）</td></tr>
            <tr class="bg-green-100 text-black"><td>18.5以上25未満</td><td>普通体重</td></tr>
            <tr class="bg-red-400 text-black"><td>25.5以上</td><td>肥満</td></tr>
          </tbody>
        </table>

<p class="mt-4">詳しくは<a href="https://www.e-healthnet.mhlw.go.jp/information/dictionary/metabolic/ym-002.html" class="text-red-600 underline">こちら(厚生労働省)</a>を参照してください。</p>

<hr class="my-4 border-dashed border-2 border-gray-800">

<b>グラフについて</b><br>
<p>体重を毎日記録していくことで、体重のグラフとBMIのグラフを表示します。</p>
<p>記録の空白ができた場所は、前日などの過去の記録の値を参照してグラフが表示されます。</p>
<p>記録はその月の６カ月前まで記録されます。</p>
<p>それ以前は破棄されます。</p>
<hr class="my-4 border-dashed border-2 border-gray-800">
<p><b>週の記録について</b></p>
カレンダーの週をタップすると日曜日から土曜日までのグラフが表示されます
<hr class="my-4 border-dashed border-2 border-gray-800">
<p><b>月間の記録について</b></p>
<p>カレンダーの日付を２度タップするとダイアログが開き、日付に対する体重の値を修正できます。</p>
<img src="img/monthly1.png" class="mt-4">
<hr class="my-4 border-dashed border-2 border-gray-800">
<p><b>作者 tora</b></p>
<p>discord tora#3327</p>

<p><a class="text-red-600 underline" href="https://github.com/tora-japan" >git-hub id tora-japan</a></p>
<p><a class="text-red-600 underline" href="https://github.com/tora-japan/laravel-weight-app2" >ソースコード（git-hub）</a></p>

<hr class="my-4 border-dashed border-2 border-gray-800">

<p><b>イラスト素材</b></p>
<p><a class="text-red-600 underline" href="https://www.irasutoya.com/">イラスト屋</a></p>
<hr class="my-4 border-dashed border-2 border-gray-800">

<p><b>ライブラリー/フレームワーク/ライセンス</b></p>
<p><a class="text-red-600 underline" href="http://laravel.jp/">Laravel8</a></p>
<p><a class="text-red-600 underline" href="https://tailwindcss.com/">Tailwindcss</a></p>
<p><a class="text-red-600 underline" href="https://github.com/laravel/breeze">Laravel breeze</a></p>
<p><a class="text-red-600 underline" href="https://laravel-livewire.com/">Laravel livewire</a></p>
<p><a class="text-red-600 underline" href="https://github.com/spatie/laravel-honeypot">laravel-honeypot</a></p>
<p><a class="text-red-600 underline" href="https://carbon.nesbot.com/">Carbon</a></p>
<p><a class="text-red-600 underline" href="https://www.chartjs.org/">Chartjs</a></p>
<p><a class="text-red-600 underline" href="https://alpinejs.dev/">Alpine.js</a></p>
<p><a class="text-red-600 underline" href="https://github.com/js-cookie/js-cookie">js-cookie</a></p>
<p><a class="text-red-600 underline" href="https://jquery.com/">jquery</a></p>

<p><a class="text-red-600 underline" href="https://www.php.net/">PHP8</a></p>

<p><b>ソースコードのみ MIT</b></p>
<p>対象はweight_src内にあるプログラムのソースファイル</p>
<p>その他ライセンスは、リンク先の通りです。</p>
<p>※イラストは<a class="text-red-600 underline" href="https://www.irasutoya.com/p/terms.html">イラスト屋のライセンス</a>です</p>

      </div>
    </div>
  </div>
</div>


</x-myapp.login>

