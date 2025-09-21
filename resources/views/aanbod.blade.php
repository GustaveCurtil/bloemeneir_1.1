@extends('_layout')

@section('title', 'bestellen')

@section('main')

    <main>
        {{-- <section>
            <p>Elke week een vernieuwend boeket!</p>
        </section> --}}
        <section id="aanbod">
                <a href="boeketten/bestellen">
                    <h3>Schattig<br>boeket</h3>
                    <p>Hier ewa tekst enzo om dit pakket wat in de verf te zetten</p>
                    <img src="{{asset('media/boeket.png')}}" alt="">
                    <p>30 euro</p>
                </a>
                <a href="boeketten/bestellen">
                    <h3>Charmant<br>boeket</h3>
                    <p>Hier ewa tekst enzo om dit pakket wat in de verf te zetten</p>
                    <img src="{{asset('media/boeket.png')}}" alt="">
                    <p>50 euro</p>
                </a>
                <a href="boeketten/bestellen">
                    <h3>Magnifiek<br>boeket</h3>
                    <p>Hier ewa tekst enzo om dit pakket wat in de verf te zetten</p>
                    <img src="{{asset('media/boeket.png')}}" alt="">
                    <p>60 euro</p>
                </a>
        </section>
    </main>

@endsection
