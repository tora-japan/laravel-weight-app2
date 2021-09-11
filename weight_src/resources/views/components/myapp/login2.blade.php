<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src='{!!url('/')!!}/jquery/jquery.min.js'></script>
        <script src='{!!url('/')!!}/chartjs/chart.min.js'></script>
 
        {{ $head_option }}
    </head>
    <body class="select-none">
      <header>
        @auth
          <x-myapp.nav2 title='{{$title}}' skipName='{{$skipName}}' />
        @else
          <x-myapp.nav1 title='{{$title}}' skipName='{{$skipName}}' />
        @endif
      </header>
      {{ $slot }}
    </body>
</html>