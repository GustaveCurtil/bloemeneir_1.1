@extends('_layout')

@section('title', 'landing')

@section('main')

    <main>
        <section id="contact">
            <p>Adres: <a href="https://maps.app.goo.gl/Hf76uVXTM3qEuUUi9" target="_blank">Stijn steruvelslaan 24</a></p>
            <p>Nummer</p>
        </section>
        <section id="kaart">
            <img src="{{asset('/media/kaart.png')}}" alt="">
        </section>
    </main>

@endsection
