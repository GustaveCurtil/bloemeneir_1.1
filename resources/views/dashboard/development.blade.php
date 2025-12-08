@extends('dashboard._layout')

@section('title', 'development')

@section('main')
<main>
@auth
    <p>In constructie</p>
@else
    @include('dashboard._login')
@endauth
</main>
@endsection