@extends('_layout')

@section('title', 'bestellen')

@section('links')
<script src="{{asset('/js/winkelbanner.js')}}" defer></script>
<script src="{{asset('/js/winkelen.js')}}" defer></script>
<script src="{{asset('/js/afhaalmoment.js')}}" defer></script>
<link rel="stylesheet" href="{{ asset('css/winkel.css') }}">
<link rel="preload" as="image" href="/media/winkel/fiche_schattig1.png">
<link rel="preload" as="image" href="/media/winkel/fiche_charmant1.png">
<link rel="preload" as="image" href="/media/winkel/fiche_magnifiek1.png">
<link rel="preload" as="image" href="/media/winkel/fiche_schattig3.png">
<link rel="preload" as="image" href="/media/winkel/fiche_charmant3.png">
<link rel="preload" as="image" href="/media/winkel/fiche_magnifiek3.png">
<link rel="preload" as="image" href="/media/winkel/kaart_schattig1.png">
<link rel="preload" as="image" href="/media/winkel/kaart_charmant1.png">
<link rel="preload" as="image" href="/media/winkel/kaart_magnifiek1.png">
<link rel="preload" as="image" href="/media/winkel/kaart_schattig2.png">
<link rel="preload" as="image" href="/media/winkel/kaart_charmant2.png">
<link rel="preload" as="image" href="/media/winkel/kaart_magnifiek2.png">
<link rel="preload" as="image" href="/media/winkel/cadeaubon1.png">
<link rel="preload" as="image" href="/media/winkel/cadeaubon2.png">
@endsection


@section('main')
    <main>
         <h2 style="text-align: center">Boeketten</h2>
         <p style="text-align: center">We werken alleen op bestelling om overschotten en afval zoveel mogelijk te beperken.</p>
        <section class="fichkes boeketten">
            <div>
                <a>
                <img src="{{asset('/media/winkel/fiche_schattig1.png')}}" alt="" srcset="" data-aanbod="boeket_A">
                </a>
                <a>
                    <img src="{{asset('/media/winkel/fiche_charmant1.png')}}" alt="" srcset="" data-aanbod="boeket_B">
                </a>
                <a>
                    <img src="{{asset('/media/winkel/fiche_magnifiek1.png')}}" alt="" srcset="" data-aanbod="boeket_C">
                </a>
            </div>
            <div>
                <p>
                    Ons lief boeketje, <br>
                    voor een kleine gelegenheid,<br>
                    een tussendoortje voor jezelf<br>
                    of wie weet een eerste date.<br>
                    <br>
                    <button class="add-to-basket" data-aanbod="boeket_A">+ <img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""> <span></span></button>
                </p>
                <p>
                    Ons boeket gevuld <br>
                    met speelse elegantie<br>
                    een fleurige verwennerij.<br>
                    <br>
                    <button class="add-to-basket" data-aanbod="boeket_B">+ <img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""> <span></span></button>
                </p>
                <p>
                    Ons florissant boeket <br>
                    om mee uit te pakken, <br>
                    waarvan harten sneller slaan.<br>
                    <br>
                    <button class="add-to-basket" data-aanbod="boeket_C">+ <img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""> <span></span></button>
                </p>
            </div>
        </section>
        <section class="fichkes bonnen">
            <br>
            <h2 style="text-align: center">5-beurtenkaarten en bonnen</h2>
            
            <div>
                <a data-aanbod="kaart_A">
                    <img src="{{asset('/media/winkel/kaart_schattig1.png')}}" alt="" srcset="">
                </a>
                <p>
                    Wauw, <br>
                    een 5-beurten kaart<br>
                    voor schattige boeketten<br>
                    met een gratis vaas cadeau.<br>
                    <br>
                    <button class="add-to-basket" data-aanbod="kaart_A">+ <img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""> <span></span></button>
                </p>
            </div>
            <div>
                <a data-aanbod="kaart_B">
                    <img src="{{asset('/media/winkel/kaart_charmant1.png')}}" alt="" srcset="">
                </a>
                <p>
                    Kijk eens aan, <br>
                    een 5-beurten kaart<br>
                    voor charmante boeketten<br>
                    met een gratis vaas cadeau.<br>
                    <br>
                    <button class="add-to-basket" data-aanbod="kaart_B">+ <img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""> <span></span></button>
                </p>
            </div>
            <div>
                <a data-aanbod="kaart_C">
                    <img src="{{asset('/media/winkel/kaart_magnifiek1.png')}}" alt="" srcset="">
                </a>
                <p>
                    Wonderbaarlijk, <br>
                    een 5-beurten kaart<br>
                    voor magnifieke boeketten<br>
                    met een gratis vaas cadeau.<br>
                    <br>
                    <button class="add-to-basket" data-aanbod="kaart_C">+ <img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""> <span></span></button>
                </p>
            </div>
            <br>
            <div>
                <a data-aanbod="cadeau">
                    <img src="{{asset('/media/winkel/cadeaubon1.png')}}" alt="" srcset="">
                </a>
                <p>
                    Wie oh wie<br>
                    kan ik plezieren<br>
                    met een cadeaubon.<br>
                    <br>
                    <button class="add-to-basket" data-aanbod="cadeau">+ <img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""> <span></span></button>
                </p>
            </div>
        </section>
        <section class="dagen">
            <h2 style="text-align: center">Afhaalmomenten</h2>
            
            <div>
                <div>
                    <h3 style="text-align: center">Over het algemeen</h3>
                    <p style="font-style: italic; font-size: 0.9rem;">Te bestellen vòòr woensdag 18u</p>
                    <p>Vrijdag tussen 15u en 19u<br>
                        Zaterdag tussen 10u en 13u</p>
                        <br>
                </div>
                <div>
                    <h3 style="text-align: center">Uitzonderlijke momenten</h3>
                    <p>Het weekend van 12 en 13 december<br>werken we ten voordele van<br>de Warmste Week</p>
                    <div class="data">
                        <div class="group">
                            <div data-datum="2025-12-12"><span>🔥 <span>vr 12 december</span></span><span>15u tot 19u</span></div>
                            <div data-datum="2025-12-13"><span>🔥 <span>za 13 december</span></span><span>10u tot 13u</span></div>                   
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
                </div>
            </div>
            
        </section>
@endsection
