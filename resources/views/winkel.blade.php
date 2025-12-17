@extends('_layout')

@section('title', 'winkel')

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
                    <span class="add-remove-basket" data-aanbod="boeket_A">
                         <button class="add-to-basket min" data-aanbod="boeket_A">-</button>
                        <span class="what-in-basket"><img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""><span>(0)</span></span>
                        <button class="add-to-basket plus" data-aanbod="boeket_A">+</button>
                    </span>
                </p>
                <p>
                    Ons boeket gevuld <br>
                    met speelse elegantie<br>
                    een fleurige verwennerij.<br>
                    <br>
                    <span class="add-remove-basket" data-aanbod="boeket_B">
                         <button class="add-to-basket min" data-aanbod="boeket_B">-</button>
                        <span class="what-in-basket"><img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""><span>(0)</span></span>
                        <button class="add-to-basket plus" data-aanbod="boeket_B">+</button>
                    </span>
                </p>
                <p>
                    Ons florissant boeket <br>
                    om mee uit te pakken, <br>
                    waarvan harten sneller slaan.<br>
                    <br>
                    <span class="add-remove-basket" data-aanbod="boeket_C">
                         <button class="add-to-basket min" data-aanbod="boeket_C">-</button>
                        <span class="what-in-basket"><img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""><span>(0)</span></span>
                        <button class="add-to-basket plus" data-aanbod="boeket_C">+</button>
                    </span>
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
                    <span class="add-remove-basket" data-aanbod="kaart_A">
                         <button class="add-to-basket min" data-aanbod="kaart_A">-</button>
                        <span class="what-in-basket"><img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""><span>(0)</span></span>
                        <button class="add-to-basket plus" data-aanbod="kaart_A">+</button>
                    </span>
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
                    <span class="add-remove-basket" data-aanbod="kaart_B">
                         <button class="add-to-basket min" data-aanbod="kaart_B">-</button>
                        <span class="what-in-basket"><img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""><span>(0)</span></span>
                        <button class="add-to-basket plus" data-aanbod="kaart_B">+</button>
                    </span>
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
                    <span class="add-remove-basket" data-aanbod="kaart_C">
                         <button class="add-to-basket min" data-aanbod="kaart_C">-</button>
                        <span class="what-in-basket"><img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""><span>(0)</span></span>
                        <button class="add-to-basket plus" data-aanbod="kaart_C">+</button>
                    </span>
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
                    <span class="add-remove-basket" data-aanbod="cadeau">
                         <button class="add-to-basket min" data-aanbod="cadeau">-</button>
                        <span class="what-in-basket"><img src="{{asset('/media/winkel/winkelmandje1.png')}}" alt=""><span>(0)</span></span>
                        <button class="add-to-basket plus" data-aanbod="cadeau">+</button>
                    </span>
                </p>
            </div>
        </section>
        <section class="dagen">
            <h2 style="text-align: center">Afhaalmomenten</h2>
            
            <div>
                <div>
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
    <script>
    localStorage.setItem('huidigBestelPad', window.location.href);
</script>
@endsection
