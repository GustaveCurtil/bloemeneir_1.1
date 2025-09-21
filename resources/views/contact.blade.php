@extends('_layout')

@section('title', 'informatie')

@section('links')
<script src="{{asset('/js/zoom-kaart.js')}}" defer></script>
@endsection

@section('main')

    <main>
        <section id="contact">
            <p><a href="tel:+32477983300">0477983300</a></p>
            <p><a href="mailto:bloemenier@gmail.com">bloemenier@gmail.com</a></p>
            <br>
            <p><a href="">instagram pagina</a></p>
            <p><a href="">facebook pagina</a></p>
            <br>
            <p><a href="https://maps.app.goo.gl/iUWhrSP8kW5jb1JJ6" target="_blank">Koning Albertlaan 77</a><br>3010 Kessel-Lo</p>
        </section>
        <section id="kaart">
            {{-- <a href="https://maps.app.goo.gl/iUWhrSP8kW5jb1JJ6" target="_blank"> --}}
            <img src="{{asset('/media/kaart.png')}}" alt="">
            {{-- </a> --}}
        </section>
    </main>

@endsection
