<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="{{ asset('media/logo_overzicht.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    @yield('links')

    <title>Overzicht Bloemenier ❀</title>
</head>

<body>
    <header>
        <div>
            <h1>Overzicht Bloemenier ❀</h1>
            @auth
            <a href="">Bla</a> ✿
            <a>blabla</a> ✿
            <a href="">blablabla</a> ✿
            @endauth
        </div>
        
        <a href="{{route('over')}}">Naar website</a>
    </header>
    @yield('main')
</body>
</html>