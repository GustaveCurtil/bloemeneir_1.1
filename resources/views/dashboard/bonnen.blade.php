@extends('dashboard._layout')

@section('title', 'bonnen')

@section('main')
<main>
@auth
    <p>In constructie</p>
@else
    @include('dashboard._login')
@endauth
</main>
@endsection