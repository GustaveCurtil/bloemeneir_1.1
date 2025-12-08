@extends('_layout')

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
</main>

<script>
    resetLocalStorage()
</script>
@endsection