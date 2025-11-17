@extends('_layout')

@section('links')
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endsection

@section('title', '')

@section('main')

    <main id="landing">
        <div class="slogan">
            <p>Doe jezelf of iemand anders<br>een groot plezier<br>en bestel een boeket<br>bij Bloemenier</p>
        </div>
        <img src="{{asset('/media/mamas.png')}}" alt="" id="landing">
    </main>

@endsection
