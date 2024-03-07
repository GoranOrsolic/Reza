<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
<body class="bg-gray-100">

<nav class="">
    <div class="bg-blue-600 p-3 text-center text-white text-5xl">Reza</div>
    <div class="justify-between bg-blue-700">
        @livewire('sports-list')
    </div>
</nav>

@yield('content')
@livewireScripts
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>{{--


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<h1 class="text-3xl font-bold underline">
    Hello world!
</h1>
</body>
</html>
--}}
