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
        {{-- <section id="aanbod">
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
        </section> --}}
        <section id="fichkes">
            <a href="boeketten/bestellen" data-boeket="boeket1">
                <img src="{{asset('/media/aanbod/fiche_schattig1.png')}}" alt="" srcset="">
            </a>
            <a href="boeketten/bestellen" data-boeket="boeket2">
                <img src="{{asset('/media/aanbod/fiche_charmant1.png')}}" alt="" srcset="">
            </a>
            <a href="boeketten/bestellen" data-boeket="boeket3">
                <img src="{{asset('/media/aanbod/fiche_magnifiek1.png')}}" alt="" srcset="">
            </a>
        </section>
    </main>

    {{-- <script>
        const img = document.querySelector("section#fichkes > a > img");

img.addEventListener("mouseenter", () => {
    img.src = "media/aanbod/schattig2.png";
});

img.addEventListener("mouseleave", () => {
    img.src = "media/aanbod/schattig1.png"; // originele afbeelding
});
    </script> --}}

@endsection
