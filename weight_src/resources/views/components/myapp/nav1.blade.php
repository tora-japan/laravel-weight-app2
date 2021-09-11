<?php
//
// ナビゲーションバー1　： ログイン前
//
// 引数 $title $skipName
//
$links=[
    ['title' => 'トップページ','link' => '/'],
    ['title' => 'ログイン','link' => '/login'],
    ['title' => '登録','link' => '/register'],
    ['title' => 'ヘルプ','link' => '/guesthelp']
];
?>

<style>
    [x-cloak] {
        display: none;
    }
</style>
<div class='bg-gray-800 p-2 mx-auto items-center justify-center text-white'>
    {{-- PC/タブレット向けのメニュー --}}
    <div class="hidden sm:block">
        <div class="text-center text-2xl">{{$title}}</div>
        <div class="flex justify-end">
            @foreach ($links as $link)
            @if($link['title']!== $skipName)
            <a class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md" href="{{ $link['link'] }}">
                {{ $link['title'] }} </a>
            @endif
            @endforeach
        </div>
    </div>
    {{-- スマートフォン向けのメニュー --}}
    <div class="sm:hidden">
        <div x-data="{ opened: false }">
            <div class="m-2 inline-flex items-center justify-start">
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
                x-transition:leave-end="opacity-0"
                x-cloak
                >
                <div class="m-2 leading-10">
                    @foreach ($links as $link)
                    @if($link['title']!== $skipName)
                    <a class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md"
                        href="{{ $link['link'] }}">
                        {{ $link['title'] }} </a><br>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>    
