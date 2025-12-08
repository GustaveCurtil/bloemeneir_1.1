@extends('dashboard._layout')

@section('title', 'Bloemenier')

@section('main')
<main>
@auth
    <section>
        <h2>Komende bestellingen</h2>
            <table>
                <thead>
                    <th>naam</th>
                    <th>mail</th>
                    <th>❀ sch.</th>
                    <th>❀ cha.</th>
                    <th>❀ mag.</th>
                    <th>▰ sch.</th>
                    <th>▰ cha.</th>
                    <th>▰ mag.</th>
                    <th>▩ bon</th>
                    <th>codes</th>
                    <th>dag</th>
                    <th>betaald</th>
                </thead>
                <tbody>
                    @foreach ($bestellingen as $bestelling)
                    <tr>
                        <td>{{$bestelling->client->first_name}}</td>
                        <td>{{$bestelling->client->email}}</td>
                        <td>{{$bestelling->option1}}</td>
                        <td>{{$bestelling->option2}}</td>
                        <td>{{$bestelling->option3}}</td>
                        <td>{{$bestelling->schattigeVouchers->count()}}</td>
                        <td>{{$bestelling->charmanteVouchers->count()}}</td>
                        <td>{{$bestelling->magnifiekeVouchers->count()}}</td>
                        <td>{{$bestelling->giftVoucher?->amount ?? "" }}</td>
                        <td>3</td>
                        <td>{{$bestelling->day}}</td>
                        <td>
                            @if ($bestelling->payed)
                            ja
                            @else 
                            nee
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </section>
    <section>
        <h2>Alle klanten</h2>
        <table>
            <thead>
                <th>naam</th>
                <th>nr</th>
                <th>mail</th>
                <th>nieuwsbrief</th>
            </thead>
            <tbody>
                @foreach ($klanten as $klant)
                <tr>
                    <td>{{$klant->first_name}}</td>
                    <td>{{$klant->phone}}</td>
                    <td>{{$klant->email}}</td>
                    <td>
                        @if ($klant->nieuwsbrief)
                        ja
                        @else 
                        nee
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@else
    <section class="inloggen">
        <form action="login" method="post">
            @csrf
            <h3>aanmelden</h3>
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
@endsection
