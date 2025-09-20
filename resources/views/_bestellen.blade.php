<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta property="og:locale" content="nl_BE" />
    <meta property="og:title" content="Bloemenier ❀">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ url('media/logo.png') }}" />
    <meta property="og:description" content="Prikkelarm platform voor evenementen te ontdekken en te organiseren." />
    <meta name="keywords" content="bloemen , boeketten , bloem , boeket , cadeau , Holsbeek , Leuven , bestellen , online">

    <link rel="shortcut icon" href="{{ asset('media/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('links')

    <title>Bloemenier ❀ @yield('title')</title>
</head>

<body>
    <header style="height: 3rem">
        <a href="{{ route('over') }}" class="{{ request()->routeIs('over') ? 'actief' : '' }}">terug</a>
    </header>
    <div>
        @yield('main')

        <footer>
            <p>🏵 <a href="">afspraken</a> 🏵</p>
            <p>website gemaakt met ♥ door <a href="https://kurtgustil.be/">kurtgustil</a></p>
        </footer>
    </div>
</body>
</html>