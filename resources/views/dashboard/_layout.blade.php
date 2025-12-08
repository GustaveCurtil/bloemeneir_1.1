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

    <title>Overzicht ❀ @yield('title')</title>
</head>

<body>
    <header>
        <div>
            <h1>Overzicht Bloemenier ❀</h1>
            @auth
            <a href="{{ route('overzicht') }}" class="{{ request()->routeIs('overzicht') ? 'actief' : '' }}">overzicht</a> ✿
            <a href="{{ route('bestellingen') }}" class="{{ request()->routeIs('bestellingen') ? 'actief' : '' }}">bestellingen</a> ✿
            <a href="{{ route('bonnen') }}" class="{{ request()->routeIs('bonnen') ? 'actief' : '' }}">bonnen</a> ✿
            <a href="{{ route('kaarten') }}" class="{{ request()->routeIs('kaarten') ? 'actief' : '' }}">kaarten</a> ✿
            <a href="{{ route('klanten') }}" class="{{ request()->routeIs('klanten') ? 'actief' : '' }}">klanten</a> ✿
            <a href="{{ route('afhaalmomenten') }}" class="{{ request()->routeIs('afhaalmomenten') ? 'actief' : '' }}">afhaalmomenten</a> ✿
            <a href="{{ route('development') }}" class="{{ request()->routeIs('development') ? 'actief' : '' }}">development</a> ✿
            @endauth
        </div>
        
        <a href="{{route('over')}}">Naar website</a>
    </header>
    @yield('main')
</body>
</html>