<?php
//
// ナビゲーションバー2　： ログイン後
//
// 引数 $title $skipName
//
$links=[
['title' => '体重記録','link' => '/weight'],
['title' => '月間','link' => '/monthly'],
['title' => '週間','link' => '/weekly'],
['title' => '身長変更','link' => '/height'],
['title' => 'ヘルプ','link' => '/help'],
];
?>

<form name="logout" method="POST" action="{{ route('user.logout') }}">@csrf </form>


<style>[x-cloak] { display: none; }</style>
<div class='bg-gray-800 p-2 mx-auto items-center justify-center text-white'>
    {{-- PC/タブレット向けのメニュー --}}
    <div class="hidden sm:block">
        <div class="text-center  text-2xl">{{$title}}</div>
        <div class="flex justify-center">
            @foreach ($links as $link)
            @if($link['title']!== $skipName)
            <a class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md" href="{{ $link['link'] }}">
                {{ $link['title'] }} </a>
            @endif
            @endforeach
            {{-- ログアウト処理 --}}
            <a class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md" 
                href="{{ route('user.logout') }}"
                onclick="event.preventDefault();document.logout.submit();">ログアウト</a>

        </div>
    </div>
    {{-- スマートフォン向けのメニュー --}}
    <div class="sm:hidden">
        <div x-data="{ opened: false }" x-cloak>
            <div class="m-2 inline-flex items-center justify-center">
                <button @click="opened = ! opened"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none ">
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="mx-2">{{$title}}</div>
            </div>

            <div x-show="opened" @click.away="opened = false" x-transition:enter="transition duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="m-2 leading-10">
                    @foreach ($links as $link)
                    @if($link['title']!== $skipName)
                    <a class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md"
                        href="{{ $link['link'] }}">
                        {{ $link['title'] }} </a><br>
                    @endif
                    @endforeach

                    {{-- ログアウト処理 --}}
                    <a class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md"
                        href="{{ route('user.logout') }}"
                        onclick="event.preventDefault();document.logout.submit();">ログアウト</a>                    

                </div>
            </div>
        </div>
    </div>
</div>    
