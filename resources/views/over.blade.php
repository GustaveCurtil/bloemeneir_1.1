@extends('_layout')

@section('title', '')

@section('links')
<script src="{{asset('/js/omhoog.js')}}" defer></script>
<script src="{{asset('/js/winkelbanner.js')}}" defer></script>
<script src="{{asset('/js/afhaalmoment.js')}}" defer></script>
<link rel="preload" as="image" href="{{ asset('media/bloemen/bloemen2.png') }}">
<link rel="preload" as="image" href="{{ asset('media/bloemen/bloemen1.png') }}">
<link rel="preload" as="image" href="{{ asset('media/bloemen/bloemen3.png') }}">
@endsection

@section('main')

    <main>
        <section class="slogan">
            <p>Doe jezelf of iemand anders<br>een groot plezier<br>en bestel een boeket<br>bij Bloemenier</p>
        </section>
        <section class="gallerij">
            <img src="{{asset('media/bloemen/bloemen2.png')}}" alt="" class="verticaal">
            <img src="{{asset('media/bloemen/bloemen1.png')}}" alt=""  class="horizontaal desktop">
            <img src="{{asset('media/bloemen/bloemen3.png')}}" alt=""  class="verticaal">
            <img src="{{asset('media/bloemen/bloemen1.png')}}" alt=""  class="horizontaal mobile">
        </section>
        <section class="dagen">
            <br>
            <h1 style="text-align: center">Afhaalmomenten</h1>
            <br>
            <h3 style="text-align: center">Over het algemeen</h3>
            <p style="font-style: italic; font-size: 0.9rem;">Te bestellen vòòr woensdag 18u</p>
            <p>Vrijdag tussen 15u en 19u<br>
                Zaterdag tussen 10u en 13u</p>
            <br>
            <h3 style="text-align: center">Agenda</h3>
            <p>Het weekend van 12 en 13 december<br>werken we ten voordele van<br>de Warmste Week</p>
            <div class="data">
                <div class="group">
                    <div data-datum="2025-12-12"><span>🔥 <span>di 12 december</span></span><span>15u tot 19u</span></div>
                    <div data-datum="2025-12-13"><span>🔥 <span>wo 13 december</span></span><span>10u tot 13u</span></div>                   
                </div>

            </div>
            <br>
            <p>Extra openingsdagen tijdens<br>❄ de kerstperiode ❄</p>
            <div class="data">
                <div class="group">
                    <div data-datum="2025-12-23"><span><span>di 23 december</span></span><span>15u tot 19u</span></div>
                    <div data-datum="2025-12-24"><span><span>wo 24 december</span></span><span>10u tot 13u</span></div>
                </div>
                <div class="group">
                    <div data-datum="2025-12-26"><span><span>vr 26 december</span></span><span>15u tot 19u</span></div>
                    <div data-datum="2025-12-27"><span><span>za 27 december</span></span><span>10u tot 13u</span></div> 
                </div>
                <div class="group">
                    <div data-datum="2025-12-30"><span><span>di 30 december</span></span><span>15u tot 19u</span></div>
                    <div data-datum="2025-12-31"><span><span>wo 31 december</span></span><span>10u tot 13u</span></div>
                </div>
            </div>
            <br>
            <p style="font-style: italic; font-size: 0.9rem;">gesloten van 1/1/26 tot en met 24/1/26</p>
        </section>
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
                        We werken enkel op <a href="{{ route('winkel') }}">bestelling</a><br>
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
