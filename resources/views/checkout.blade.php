@extends('_layout')

@section('title', 'Betaling')

@section('main')
<main>
    <section>
        <h2>Jouw gegevens</h2>
        <p>Naam: {{$client->first_name}}</p>
        <p>Telefoonnummer: {{$client->phone}} (wordt enkel gebruikt indien noodzakelijk)</p>
        <p>E-mailadres: {{$client->email}}</p>
    </section>
    <section>
        <h2>Je bestelling</h2>
        <ul>
            <li>Schattig boeket x {{ $order->option1 }} = €{{ number_format(30 * $order->option1, 2 , ',')}} <button>6 schattige-boeketten-kaart kopen</button></li>
            <li>Prachtig boeket x {{ $order->option2 }} = €{{ number_format(30 * $order->option2, 2 , ',')}} <button>6 prachtige-boeketten-kaart kopen</button></li>
            <li>Magnifiek boeket x {{ $order->option3 }} = €{{ number_format(30 * $order->option3, 2 , ',')}} <button>6 magnifieke-boeketten-kaart kopen</button></li>
        </ul>
        <p><strong>Totaal: €{{ number_format((30 * $order->option1) + (50 * $order->option2) + (60 * $order->option3), 2, ',') }}</strong></p>
    </section>
    <section>
        <a  href="boeketten/bestellen">Nog even iets aanpassen</a>
    </section>
    <input type="submit" id="payButton" value="betaal met Bancontact">
</main>

@endsection