<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="{{ asset('media/logo_overzicht.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    @yield('links')

    <title>Overzicht ❀ @yield('title')</title>
</head>

<body>
  <div>
    <header>
        <div>
            <h1>Overzicht bestellingen</h1>
            <a href="{{route('landing')}}">Naar website</a>
        </div>
    </header>
    <div>
        @yield('main')
    </div>
    <div id="omhoog">
        <p>↑</p>
    </div>
  </div>
    
</body>
</html>