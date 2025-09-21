@extends('_layout')

@section('title', 'bestellen')

@section('links')
<script src="{{asset('/js/onthou-boeket.js')}}" defer></script>
@endsection

@section('main')

    <main>
        {{-- <section>
            <p>Elke week een vernieuwend boeket!</p>
        </section> --}}
        <section id="aanbod">
                <a href="boeketten/bestellen" data-boeket="boeket1">
                    <h3>Schattig<br>boeket</h3>
                    <p>Hier ewa tekst enzo om dit pakket wat in de verf te zetten</p>
                    <img src="{{asset('media/boeket.png')}}" alt="">
                    <p>30 euro</p>
                </a>
                <a href="boeketten/bestellen" data-boeket="boeket2">
                    <h3>Charmant<br>boeket</h3>
                    <p>Hier ewa tekst enzo om dit pakket wat in de verf te zetten</p>
                    <img src="{{asset('media/boeket.png')}}" alt="">
                    <p>50 euro</p>
                </a>
                <a href="boeketten/bestellen" data-boeket="boeket3">
                    <h3>Magnifiek<br>boeket</h3>
                    <p>Hier ewa tekst enzo om dit pakket wat in de verf te zetten</p>
                    <img src="{{asset('media/boeket.png')}}" alt="">
                    <p>60 euro</p>
                </a>
        </section>
    </main>

@endsection
