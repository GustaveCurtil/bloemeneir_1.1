<p>Dag Petra & Anne-Sophie,</p>

<p>Er is net een nieuwe bestelling doorgekomen:</p>
<p>Voor <b>{{$dag}} {{$datum}} van {{ $uren }}</b></p>
<ul>
    <li>voornaam: <span style="text-transform: capitalize;">{{ $order->client->first_name }}</span></li>
    <li>achternaam: <span style="text-transform: capitalize;">{{ $order->client->last_name }}</span></li>
    <li>e-mailadres: {{ $order->client->email }}</li>
    <li>telefoonnummer: {{ $order->client->phone }}</li>
    <li>nieuwsbrief: 
        @if ($order->client->nieuwsbrief)
        Ja
        @else
        Nee
        @endif
    </li>
</ul>

<p>Bestelling succesvol betaald.</p>

<p>
Digitale groeten, <br>
Gust<br>
0477983300
</p>