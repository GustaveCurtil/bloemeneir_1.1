@extends('_layout')

@section('links')
<script src="{{asset('/js/winkelbanner.js')}}" defer></script>
{{-- <script src="{{asset('/js/resetLocalStorage.js')}}" defer></script> --}}
@endsection

@section('title', 'Betaling')

@section('main')
<main>
    <section>
        <h2>Betaling goed doorgekomen!</h2>
        <p>Je krijgt zodadelijk een e-mail op het volgende e-mailadres: <b>{{$client->email}}</b></p>
        <p>Het kan zijn dat de e-mail in jouw spam-box beland. Zeker eens te bekijken!</p>
        <br>
        <p>Je mag jouw boeket(ten) komen halen op <b>{{$dag}} {{$datum}} van {{ $dag === 'vrijdag' ? '15u tot 19u' : '10u tot 13u' }}</b>.</p>
        <br>
        <p>Tot binnenkort, <span style="text-transform: capitalize;">{{$client->first_name}}</span>!</p>
    </section>
    <section>
        <h2>TEST-gegevens</h2>
        <h3>Boeketten</h3>
        <p>{{$order}}</p>
        <br>
        <h3>Nieuw aangekochte bonnen en kaarten</h3>
        <p>{{$order->giftVoucher}}</p>
        <p>{{$order->schattigeVouchers}}</p>
        <p>{{$order->charmanteVouchers}}</p>
        <p>{{$order->magnigiekeVouchers}}</p>
        <br>
        <h3>Bestaande ingevoerde bonnen en kaarten</h3>
        <p>{{$order->giftVoucher}}</p>
        <p>{{$order->schattigeVouchers}}</p>
        <p>{{$order->charmanteVouchers}}</p>
        <p>{{$order->magnigiekeVouchers}}</p>
        
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        resetLocalStorage()
    })
</script>
@endsection