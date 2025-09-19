@extends('_layout')

@section('title', 'landing')

@section('main')

    <main>
        <section id="aanbod">
            @for ($i = 0; $i < 3; $i++)
                <a href="{{'/boeket/' . ($i + 1)}}">
                    <h3>Schattig boeket {{$i + 1}}</h3>
                    <p>Hier ewa tekst enzo om dit pakket wat in de verf te zetten</p>
                    <img src="{{asset('media/boeket.png')}}" alt="">
                    <p>{{ ($i + 1) * 20}} euro</p>
                </a>
            @endfor
        </section>
    </main>

@endsection
