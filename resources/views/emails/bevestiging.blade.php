<p>Beste <span style="text-transform: capitalize;">{{ $order->client->first_name }}</span>,</p>

<p>We hebben je bestelling goed ontvangen:</p>
<ul>
    <li>Schattig boeket x {{ $order->option1 }}</li>
    <li>Charmant boeket x {{ $order->option2 }}</li>
    <li>Magnifiek boeket x {{ $order->option3 }}</li>
</ul>
<p>We verwachten jou <b>{{$weekday}} {{$formattedDate}}
    @if ($weekday === 'vrijdag')
    (tussen 15u en 19u)
    @else
    (tussen 11u en 13u)
    @endif
    </b>
</p>

<p>Fleurige groeten, <br>
Anne-Sophie & Petra</p>