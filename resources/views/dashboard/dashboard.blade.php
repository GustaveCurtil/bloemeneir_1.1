@extends('dashboard._layout')

@section('title', 'Bloemenier')

@section('main')
<main>
@auth
<section class="text">
    <p>Hallo</p>
</section>

@else
    @include('dashboard._login')
@endauth
</main>
@endsection
