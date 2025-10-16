<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('media/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Overzicht</title>
</head>
<body>
    <div>
        <header>
            <div>
                <h1>Overzicht bestellingen</h1>
            </div>
        </header>
        <div>
            <main>
            @auth
                yo
            @else
                <section>
                    <form action="login" method="post">
                        @csrf
                        <fieldset>
                            <label for="naam">naam:</label>
                            <input type="text" name="naam" id="">
                            <label for="wachtwoord">wachtwoord:</label>
                            <input type="password" name="wachtwoord" id="">
                        </fieldset>
                        <input type="submit" value="inloggen">
                    </form>
                </section>
            @endauth
            </main>
        </div>
        <div id="omhoog">
            <p>↑</p>
        </div>
    </div>
</body>
</html>