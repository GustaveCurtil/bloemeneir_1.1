<p>Beste <span style="text-transform: capitalize;">{{ $order->client->first_name }}</span>,</p>
<p>We hebben je bestelling goed ontvangen:</p>
@if ($order->option1 || $order->option2 || $order->option3)
<p>Boeket(ten): op te halen <b>{{$dag}} {{$datum}} van {{ $uren }}</b>.</p>
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
@endif
@if ($giftNewVoucher)
<p>▩ Cadeaubon</p>
<ul>
    <li>Code: <b>{{$giftNewVoucher->code}}</b></li>
    <li>Ter waarde van: <b>€ {{$giftNewVoucher->amount}}</b></li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($giftNewVoucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>
@endif
@foreach ($schattigNewVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option1}} / {{$voucher->option1_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>
@endforeach
@foreach ($charmantNewVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option2}} / {{$voucher->option2_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>    
@endforeach
@foreach ($magnifiekNewVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option3}} / {{$voucher->option3_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>    
@endforeach
@if (collect([$giftNewVouchers, $schattigNewVouchers, $charmantNewVouchers, $magnifiekNewVouchers])->flatten()->count())
<p>TIP: Om jouw code(s) zeker niet kwijt te geraken
<br>1. Sla deze mail op
<br>2. Schrijf de codes ergens op</p>
@endif

@if (collect([$giftOldVouchers, $schattigOldVouchers, $charmantOldVouchers, $magnifiekOldVouchers])->flatten()->count())
<p>Je hebt de volgende 5-beurtenkaart(en) en/of cadeaubon(nen) gebruikt:</p>
@foreach ($giftOldVouchers as $voucher)
<p>▩ Cadeaubon</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Ter waarde van: <s>€ {{$voucher->original_amount}}</s> <b>€ {{$voucher->amount}}</b> overblijvend</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>    
@endforeach
@foreach ($schattigOldVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option1}} / {{$voucher->option1_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>  
@endforeach
@foreach ($charmantOldVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option2}} / {{$voucher->option2_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>  
@endforeach
@foreach ($magnifiekOldVouchers as $voucher)
<p>▰ {{$voucher->name}}e 5 beurtenkaart</p>
<ul>
    <li>Code: <b>{{$voucher->code}}</b></li>
    <li>Aantal beurten: {{$voucher->option3}} / {{$voucher->option3_original}}</li>
    <li>Geldig tot: <b>{{ \Carbon\Carbon::parse($voucher->valid_date)->format('d/m/Y') }}</b></li>
</ul>  
@endforeach
@endif


<p>Fleurige groeten, <br>
Anne-Sophie & Petra</p>

<p>Bloemenier VOF<br>
<p>BE 1028 201 978<br>
<p>Adres: <a href="https://maps.app.goo.gl/qAkeHriBos8S4XMcA">Koning Albertlaan 77</a>, Kessel-Lo<br>
<p>website: <a href="https://bloemenier.be/">https://bloemenier.be/</a></p>