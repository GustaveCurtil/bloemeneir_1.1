@extends('_layout')

@section('title', 'bestellen')

@section('links')
<script src="{{asset('/js/autofill.js')}}" defer></script>
@endsection

@section('main')

    <main>
        <h2>boeketten bestellen</h2>
        <section>
            <p>De boeketten kunnen vrijdag 26 september bij ons worden afgehaald in de <a href="https://maps.app.goo.gl/iUWhrSP8kW5jb1JJ6" target="_blank">Koning Albertlaan 77</a> in Kessel-Lo</p>
        </section>
        
            <form action="{{ route('order') }}" method="POST" >
                @csrf
                <fieldset id="aantal">
                    <div>
                        <div></div>
                        <label for="boeket1">
                            <p>Aantal schattige boeketten</p>
                            <p>30 euro</p>
                        </label>
                        <input type="number" name="option1" id="boeket1" placeholder="0" min="0" value="{{ old('option1') }}">
                    </div>
                    <div>
                        <div></div>
                        <label for="boeket2">
                            <p>Aantal charmante boeketten</p>
                            <p>50 euro</p>
                        </label>
                        <input type="number" name="option2" id="boeket2" placeholder="0" min="0" value="{{ old('option2') }}">                      
                    </div>
                    <div>
                        <div></div>
                        <label for="boeket3">
                            <p>Aantal magnifieke boeketten</p>
                            <p>60 euro</p>
                        </label>
                        <input type="number" name="option3" id="boeket3" placeholder="0"  min="0" value="{{ old('option3') }}">                        
                    </div>
                </fieldset>
                <fieldset class="vraag">
                    <p>Ik kom mijn bestelling ophalen:</p>
                    <label class="rij">
                        <input type="radio" name="day" value="friday" required>
                        vrijdag 26 september (tussen 16u en 19u)
                    </label>
                    <label class="rij">
                        <input type="radio" name="day" value="saturday" required>
                        zaterdag 27 september (tussen 9u en 11u)
                    </label>
                </fieldset>
                <fieldset>
                    <label for="naam">naam*</label>
                    <input type="text" name="first_name" id="naam" value="{{ old('first_name') }}">
                    <label for="nummer">telefoonnummer (optioneel)</label>
                    <input type="tel" name="phone" id="nummer" value="{{ old('phone') }}" placeholder="voor eventuele last minute aanpassingen">
                    <label for="email">email*</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}">
                </fieldset>
                {{-- <fieldset>
                    <label for="akkoord" class="rij">
                    <input type="checkbox" name="akkoord" id="akkoord"> Ik kom mijn bestelling vrijdag 26 september halen.
                    </label>
                </fieldset> --}}
                <input type="submit" value="bestellen">
            </form>
    </main>


@endsection
