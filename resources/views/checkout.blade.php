@extends('_layout')

@section('title', 'Betaling')

@section('main')
<main>
    <section>
        <h2>Jouw gegevens</h2>
        <p>Naam: <b>{{$client->first_name}}</b></p>
        <p>Telefoonnummer: <b>{{$client->phone}}</b> <i class="small">(wordt enkel gebruikt indien noodzakelijk)</i></p>
        <p>E-mailadres: <b>{{$client->email}}</b></p>
        <p>Nieuwsbrief: 
            @if ($client->nieuwsbrief)
            <b>Ja</b> <i class="small">(ongeveer 4 keer per jaar)</i>
            @else
            <b>Nee bedankt</b>
            @endif
        </p>
    </section>
    <section>
        <h2>Jouw bestelling</h2>
        <ul>
            <li>Schattig boeket x {{ $order->option1 }} = €{{ number_format(30 * $order->option1, 2 , ',')}}</li>
            <li>Charmant boeket x {{ $order->option2 }} = €{{ number_format(50 * $order->option2, 2 , ',')}}</li>
            <li>Magnifiek boeket x {{ $order->option3 }} = €{{ number_format(60 * $order->option3, 2 , ',')}}</li>
        </ul>
        <p><strong>Totaal: €{{ number_format((30 * $order->option1) + (50 * $order->option2) + (60 * $order->option3), 2, ',') }}</strong></p>
        <br>
        <p>Je komt jouw boeket halen op <b>{{$dag}} {{$datum}}
            @if ($dag === 'vrijdag')
            (tussen 15u en 19u)
            @else
            (tussen 11u en 13u)
            @endif
            </b>
        </p>
    </section>
    <section>
        <a href="{{ route('checkout.backToForm', ['order' => $order, 'client' => $client]) }}">
            klik hier om nog even iets aanpassen
        </a>
    </section>
    <input type="submit" id="payButton" value="betaal met Bancontact">
</main>

@endsection