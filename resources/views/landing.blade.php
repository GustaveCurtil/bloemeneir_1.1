@extends('_layout')

@section('links')
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endsection

@section('title', '')

@section('main')

    <main id="landing">
        <div class="slogan">
            <p>De volledige opbrengst<br>van de verkoop op 12 en 13 december schenken we aan<br>🔥 de Warmste Week 🔥</p>
            <br>
            <span class="desktop">
                <p>Doe jezelf of iemand anders<br>een groot plezier<br>en bestel een boeket<br>bij Bloemenier</p>
                <br>
            </span>
            <p>Extra openingsdagen tijdens<br>❄ de kerstperiode ❄</p>
        </div>
        <img src="{{asset('/media/mamas.png')}}" alt="" id="landing">
    </main>

@endsection
