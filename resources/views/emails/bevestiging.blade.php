<p>Beste <span style="text-transform: capitalize;">{{ $order->client->first_name }}</span>,</p>

<p>We hebben je bestelling goed ontvangen:</p>
<ul>
    <li>Schattig boeket x {{ $order->option1 }}</li>
    <li>Charmant boeket x {{ $order->option2 }}</li>
    <li>Magnifiek boeket x {{ $order->option3 }}</li>
</ul>
{{-- <p>We verwachten jou <b>{{$weekday}} {{$formattedDate}}
    @if ($weekday === 'vrijdag')
    (tussen 15u en 19u)
    @else
    (tussen 10u en 13u)
    @endif
    </b>
</p> --}}

<p>Fleurige groeten, <br>
Anne-Sophie & Petra</p>

<h2>TEST-gegevens</h2> 
<p>(die de klant in mail gaan krijgen -> werkt nog niet)</p>
<p>Dus voor de testing van de nieuwe 5 beurtenkaarten en bon -> code even noteren</p>
<br>
@if ($order->option1 || $order->option2 || $order->option3)
    <h3>Boeketten</h3>
    @if ($order->option1)
    <p>Schattig boeket x {{$order->option1}}</p>
    @endif
    @if ($order->option2)
    <p>Charmant boeket x {{$order->option2}}</p>
    @endif
    @if ($order->option3)
    <p>Magnifiek boeket x {{$order->option3}}</p>
    <br>
    @endif
@endif
<br>
<h3>Nieuw aangekochte bonnen en kaarten</h3>
@if ($giftNewVoucher)
    <p>Cadeaubon: €{{$giftNewVoucher->amount}}</p>
    <p>Code: {{$giftNewVoucher->code}}</p>
    <br>
@endif
@foreach ($schattigNewVouchers as $voucher)
    <p>{{$voucher->name}}e 5 beurtenkaart: {{$voucher->option1}} / {{$voucher->option1_original}}</p>
    <p>Code: {{$voucher->code}}</p>
    <br>
@endforeach
@foreach ($charmantNewVouchers as $voucher)
    <p>{{$voucher->name}}e 5 beurtenkaart: {{$voucher->option2}} / {{$voucher->option2_original}}</p>
    <p>Code: {{$voucher->code}}</p>
    <br>
@endforeach
@foreach ($magnifiekNewVouchers as $voucher)
    <p>{{$voucher->name}}e 5 beurtenkaart: {{$voucher->option3}} / {{$voucher->option3_original}}</p>
    <p>Code: {{$voucher->code}}</p>
    <br>
@endforeach
<br>
<h3>Ingevoerde bon- en kaartcodes</h3>
@foreach ($giftOldVouchers as $voucher)
    <p>Cadaubon: {{$voucher->amount}} / {{$voucher->original_amount}}</p>
    <p>Code: {{$voucher->code}}</p>
    <br>
@endforeach
@foreach ($schattigOldVouchers as $voucher)
    <p>{{$voucher->name}}e 5 beurtenkaart: {{$voucher->option1}} / {{$voucher->option1_original}}</p>
    <p>Code: {{$voucher->code}}</p>
    <br>
@endforeach
@foreach ($charmantOldVouchers as $voucher)
    <p>{{$voucher->name}}e 5 beurtenkaart: {{$voucher->option2}} / {{$voucher->option2_original}}</p>
    <p>Code: {{$voucher->code}}</p>
    <br>
@endforeach
@foreach ($magnifiekOldVouchers as $voucher)
    <p>{{$voucher->name}}e 5 beurtenkaart: {{$voucher->option3}} / {{$voucher->option3_original}}</p>
    <p>Code: {{$voucher->code}}</p>
    <br>
@endforeach