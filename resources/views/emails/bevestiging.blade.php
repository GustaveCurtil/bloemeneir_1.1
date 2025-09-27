<h1>Bedankt voor je bestelling!</h1>

<p>Beste <span style="text-transform: capitalize;">{{ $order->client->first_name }}</span>,</p>

<p>We hebben je bestelling goed ontvangen:</p>
<ul>
    <li>Schattig boeket x {{ $order->option1 }} = €{{ number_format(29 * $order->option1, 2 , ',')}}</li>
    <li>Charmant boeket x {{ $order->option2 }} = €{{ number_format(39 * $order->option2, 2 , ',')}}</li>
    <li>Magnifiek boeket x {{ $order->option3 }} = €{{ number_format(49 * $order->option3, 2 , ',')}}</li>
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