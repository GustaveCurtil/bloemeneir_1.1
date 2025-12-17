@extends('dashboard._layout')

@section('title', 'bonnen')

@section('main')
<main>
@auth
<section class="inloggen">
    <img src="{{asset('media/underconstruction.gif')}}" alt="" class="construction">
</section>
@else
    @include('dashboard._login')
@endauth
</main>
@endsection