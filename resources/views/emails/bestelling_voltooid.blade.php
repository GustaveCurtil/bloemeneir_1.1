<p>Dag Petra & Anne-Sophie,</p>

<p>Deze bestelling is net doorgekomen:</p>
<ul>
    <li>Schattig boeket x {{ $order->option1 }}</li>
    <li>Charmant boeket x {{ $order->option2 }}</li>
    <li>Magnifiek boeket x {{ $order->option3 }}</li>
</ul>
<p>Voor <b>{{$weekday}} {{$formattedDate}}
    @if ($weekday === 'vrijdag')
    (tussen 15u en 19u)
    @else
    (tussen 10u en 13u)
    @endif
    </b>
</p>
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