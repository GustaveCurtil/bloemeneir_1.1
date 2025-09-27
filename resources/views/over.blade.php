@extends('_layout')

@section('title', 'landing')

@section('links')
<script src="{{asset('/js/omhoog.js')}}" defer></script>
@endsection

@section('main')

    <main>
        <section class="fototekst">
                <img src="{{asset('media/over/bloemenier-51.jpg')}}" alt="">  
                <div>
                    <p>
                        Dat zijn wij, Bloemenier. <br>
                        Petra en Anne-Sophie.<br>
                        Welkom.
                    </p>
                    <br>
                    <p>
                        We werken op bestelling<br>
                        beperkt overschot en afval.<br>
                        Geïnspireerd op het aanbod<br>
                        van het seizoen en<br>
                        steeds kakelverse bloemen<br>
                        want we bestellen ze
                    </p>
                    <br>
                    <p>
                        enkel voor jullie<br>
                        Ecologisch doordacht.<br>
                        Prijs in evenwicht.
                    </p>
                </div> 
        </section>
        <section class="gallerij">
            <img src="{{asset('media/over/bloemenier-68.jpg')}}" alt="" class="verticaal">
            <img src="{{asset('media/over/bloemenier-71.jpg')}}" alt=""  class="verticaal">
            <img src="{{asset('media/over/bloemenier-120.jpg')}}" alt=""  class="horizontaal">
        </section>
        <section class="fototekst">
            <div>
                <p>
                    Het seizoen bepaalt de bloemen,<br>
                    fris en vers bepalen wij. <br>
                    Kromme stengels, speelse kleuren<br>
                    grijpen hun kans, horen erbij.
                </p>
                <br>
                <p>
                    Zot van bloemen, net als wij?<br>
                    Goesting gekregen, kriebelt iets blij?<br>
                    Jij kiest ‘schattig’, ‘charmant’ of ‘magnifiek’.<br>
                    Wij zorgen voor iets magique.
                </p>
            </div> 
            <img src="{{asset('media/over/bloemenier-72.jpg')}}" alt="" class="horizontaal">  
        </section>
    </main>

@endsection
