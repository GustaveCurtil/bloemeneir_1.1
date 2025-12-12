@extends('_layout')

@section('links')
{{-- <script src="{{asset('/js/resetLocalStorage.js')}}" defer></script> --}}
@endsection

@section('title', 'Betaling')

@section('main')
<main>
    <section>
        <h2>Betaling goed doorgekomen!</h2>
        <p>Je krijgt zodadelijk een e-mail op het volgende e-mailadres: <b>{{$client->email}}</b></p>
        <p>Het kan zijn dat de e-mail in jouw spam-box belandt. Zeker eens te bekijken!</p>
        <br>
        <p>Je mag jouw boeket(ten) komen halen op <b>{{$dag}} {{$datum}} van {{ $uren }}</b>.</p>
        <br>
        <p>Tot binnenkort, <span style="text-transform: capitalize;">{{$client->first_name}}</span>!</p>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        resetLocalStorage()
    })

    document.addEventListener('DOMContentLoaded', () => {
        let bestelFlowLink = document.querySelector('a#bestel-flow');

        let bestelUrl = localStorage.getItem('huidigBestelPad');
        if (bestelUrl) {
            bestelFlowLink.href = bestelUrl;
        } else {
            bestelFlowLink.href = '/winkel'
        }
    })
</script>
@endsection