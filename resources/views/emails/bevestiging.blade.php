<p>Beste <span style="text-transform: capitalize;">{{ $order->client->first_name }}</span>,</p>

<p>We hebben je bestelling goed ontvangen:</p>
@if ($order->option1 || $order->option2 || $order->option3)
<p>Boeket(ten):</p>
<ul>
    @if ($order->option1)
    <li style="list-style-type: '❀ '">Schattig boeket x {{ $order->option1 }}</li>
    @endif
    @if ($order->option2)
    <li style="list-style-type: '❀ '">Charmant boeket x {{ $order->option2 }}</li>
    @endif
    @if ($order->option3)
    <li style="list-style-type: '❀ '">Magnifiek boeket x {{ $order->option3 }}</li>
    @endif
</ul>
<p>We verwachten jou <b>{{$dag}} {{$datum}} van {{ $uren }}</b>.</p>
<br>
@endif
@if ($giftNewVoucher)
<p>▩ Cadeaubon</p>
<ul>
    <li>Code: <b>{{$giftNewVoucher->code}}</b></li>
    <li>Ter waarde van: <b>€ {{$giftNewVoucher->amount}}</b></li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($giftNewVoucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>
<br>
@endif
@foreach ($schattigNewVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option1}} / {{$voucher->option1_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>    
<br>
@endforeach
@foreach ($charmantNewVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option2}} / {{$voucher->option2_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>    
<br>
@endforeach
@foreach ($magnifiekNewVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option3}} / {{$voucher->option3_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>    
<br>
@endforeach
@if ($giftNewVoucher || $giftNewVouchers || $schattigNewVouchers || $charmantNewVouchers || $magnifiekNewVouchers)
<p>TIP: Om jouw code(s) zeker niet kwijt te geraken</p>
<p>1. Sla deze mail op</p>
<p>2. Schrijf de codes ergens op</p>
<br>
@endif

@if ($giftOldVouchers || $schattigOldVouchers || $charmantOldVouchers || $magnifiekOldVouchers)
<p>Je hebt de volgende 5-beurtenkaart(en) en/of cadeaubon(nen) gebruikt:</p>
@foreach ($giftOldVouchers as $voucher)
<p>▩ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Ter waarde van: <s>€ {{$voucher->original_amount}}</s> <b>€ {{$voucher->amount}}</b> overblijvend</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>    
<br>
@endforeach
@foreach ($schattigOldVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option1}} / {{$voucher->option1_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>  
<br>
@endforeach
@foreach ($charmantOldVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option2}} / {{$voucher->option2_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>  
<br>
@endforeach
@foreach ($smagnifiekOldVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option3}} / {{$voucher->option3_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>  
<br>
@endforeach

@endif


<p>Fleurige groeten, <br>
Anne-Sophie & Petra</p>


<h3>Nieuw aangekochte bonnen en kaarten</h3>

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