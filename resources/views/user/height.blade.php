<x-myapp.login title='身長の変更' skipName='身長変更'>

<form method="POST" action="height">
@csrf

<div class="sm:min-h-screen  flex sm:justify-center items-center sm:pt-0 bg-green-600 ">

  <div class="w-full sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl bg-white overflow-hidden sm:rounded-lg">

    <div class="flex justify-center items-center">
        <img class="w-6/12" src="{!!url('/')!!}/img/kenkoushindan01_shinchou_girl_kakato.png">
    </div>

    <div class="mt-4 p-4 bg-green-400  rounded-lg ">
      <div class="mt-4">

            <div class="text-center">身長を入力してください</div>

            <div class="mt-4">
                <x-label for="height" value="身長(cm) bmiの計算で使います" />
                <x-input id="height" class="block mt-1 w-full"
                                type="number"
                                value="150"
                                name="height" required />
            </div>

            <div class="flex items-center justify-center mt-4"> 
              <button type="submit" class="bg-red-600 hover:bg-red-700 text-white pl-4 pr-4 pt-2 pb-2 rounded shadow-md " >更　新</button>
            </div>

            <div class="text-center mt-4">
              <p>{!! $msg !!}</p>
            </div>

      </div>
    </div>
  </div>
</div>
</form>
</x-myapp.login>
