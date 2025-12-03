@extends('_layout')

@section('title', 'bestellen')

@section('links')
<script src="{{asset('/js/winkelbanner.js')}}" defer></script>
<script src="{{asset('/js/winkelen.js')}}" defer></script>
<link rel="stylesheet" href="{{ asset('css/winkel.css') }}">
<link rel="preload" as="image" href="/media/winkel/fiche_schattig2.png">
<link rel="preload" as="image" href="/media/winkel/fiche_charmant2.png">
<link rel="preload" as="image" href="/media/winkel/fiche_magnifiek2.png">
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
        <section id="intro">
            <p>We werken alleen op bestelling om overschotten en afval zoveel mogelijk te beperken.</p>
            {{-- <br>
            <p>Bestel je boeket voor woensdag 18u en kies zelf of je het vrijdagnamiddag (15-19u) of zaterdagvoormiddag (10-13u) komt afhalen bij ons.</p>
            <br>
            <p>❄ Extra openingsdagen tijdens de kerstperiode ❄</p> --}}
        </section>
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
@endsection
