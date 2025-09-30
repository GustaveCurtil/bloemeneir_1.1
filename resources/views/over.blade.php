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
                        Dit zijn wij, Bloemenier. <br>
                        Anne-Sophie en Petra.<br>
                        Welkom.
                    </p>
                    <br>
                    <p>
                        We werken enkel op bestelling<br>
                        zo beperken we overschot en afval.<br>
                        Geïnspireerd op het aanbod<br>
                        van het seizoen en steeds<br>
                        kakelverse bloemen<br>
                        want we bestellen ze <br>
                        speciaal voor jullie<br>
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
                    Kromme stengels, speelse kleuren<br>
                    horen erbij.
                </p>
                <br>
                <p>
                    Zot van bloemen, net als wij?<br>
                    Jij kiest ‘schattig’, ‘charmant’ of ‘magnifiek’.<br>
                    Wij zorgen voor iets artistiek.
                </p>
            </div> 
            <img src="{{asset('media/over/bloemenier-72.jpg')}}" alt="" class="horizontaal">  
        </section>
    </main>

@endsection
