<x-myapp.login2 title='週間の記録を見る' skipName='週間'>

<x-slot name="head_option">
  <link rel='stylesheet' type='text/css' href='{!!url('/')!!}/css/my_dlg.css'>
  <script src='{!!url('/')!!}/js/my_dlg.js'> </script>
  <style>
  .calendar{}
  .swipe{}
  </style>
  @livewireStyles
</x-slot>

<div class="sm:min-h-screen  flex sm:justify-center items-center sm:pt-0 bg-green-600 ">
  <div class="w-full sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl bg-white overflow-hidden sm:rounded-lg">
    @livewire('weekly')
  </div>
</div>
@livewireScripts
</x-myapp.login2>
