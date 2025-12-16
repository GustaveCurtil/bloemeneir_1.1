@extends('dashboard._layout')

@section('title', 'Bloemenier')

@section('main')
<main>
@auth

@else
    @include('dashboard._login')
@endauth
</main>
@endsection
