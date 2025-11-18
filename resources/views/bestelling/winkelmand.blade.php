@extends('_layout')

@section('title', 'bestellen')

@section('links')
<script src="{{asset('/js/winkelmandje.js')}}" defer></script>
<script src="{{asset('/js/kassa.js')}}" defer></script>
@endsection

@section('main')

    <main>
        <div class="left-right">
            <h2>Winkelmandje</h2>
            <a href="/aanbod">terug</a>
        </div>
            <p>Boeket voor deze week graag vòòr woensdag 18u bestellen.</p>
            <br>
            <p>De volledige opbrengst van de verkoop op <b>12 en 13 december</b> schenken we aan de ☀ <b>Warmste Week</b> ☀</p>
            <br>
            
            <form onsubmit="return gaNaarBetaling()">
                @error('options')
                    <br>
                    <p class="error">⚠️ <b>{{ $message }}</b></p>
                    <br>
                @enderror
                <fieldset class="aantal" id="boeketten">
                    <div>
                        <img src="{{asset('/media/aanbod/boeket_schattig.png')}}">
                        <label for="boeket_A">
                            <p>Schattig boeket</p>
                            <p>29 euro</p>
                        </label>
                        <div class="plusmin">
                            <input type="number" name="option1" id="boeket_A" data-aanbod="boeket_A" placeholder="0" min="0" value="{{ old('option1', $order->option1 ?? '') }}">
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                        </div>
                    </div>
                    <div>
                        <img src="{{asset('/media/aanbod/boeket_charmant.png')}}">
                        <label for="boeket_B">
                            <p>Charmant boeket</p>
                            <p>39 euro</p>
                        </label>
                        <div class="plusmin">
                            <input type="number" name="option2" id="boeket_B" data-aanbod="boeket_B" placeholder="0" min="0" value="{{ old('option2', $order->option2 ?? '') }}">
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                        </div>                      
                    </div>
                    <div>
                        <img src="{{asset('/media/aanbod/boeket_magnifiek.png')}}">
                        <label for="boeket_C">
                            <p>Magnifiek boeket</p>
                            <p>49 euro</p>
                        </label>
                        <div class="plusmin">
                            <input type="number" name="option3" id="boeket_C" data-aanbod="boeket_C" placeholder="0" min="0" value="{{ old('option3', $order->option3 ?? '') }}">
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                        </div>                        
                    </div>
                </fieldset>
                <br>
                <fieldset class="aantal" id="kaarten">
                    <div>
                        <img src="{{asset('/media/aanbod/boeket_schattig.png')}}">
                        <label for="kaart_A">
                            <p>Schattige 5 beurtenkaart</p>
                            <p>120 euro (gratis vaas)</p>
                        </label>
                        <div class="plusmin">
                            <input type="number" name="option1" id="kaart_A" data-aanbod="kaart_A" placeholder="0" min="0" value="{{ old('option1', $order->option1 ?? '') }}">
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                        </div>
                    </div>
                    <label for="inzetten_A" class="inzetten">
                        <input type="checkbox" name="inzetten_A" id="inzetten_A">Meteen gebruiken<span>&nbsp;(5 over)</span>
                    </label>
                    <div>
                        <img src="{{asset('/media/aanbod/boeket_charmant.png')}}">
                        <label for="kaart_B">
                            <p>Charmante 5 beurtenkaart</p>
                            <p>160 euro (gratis vaas)</p>
                        </label>
                        <div class="plusmin">
                            <input type="number" name="option2" id="kaart_B" data-aanbod="kaart_B" placeholder="0" min="0" value="{{ old('option2', $order->option2 ?? '') }}">
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                        </div>                      
                    </div>
                    <label for="inzetten_B" class="inzetten">
                        <input type="checkbox" name="inzetten_B" id="inzetten_B">Meteen gebruiken<span>&nbsp;(5 over)</span>
                    </label>
                    <div>
                        <img src="{{asset('/media/aanbod/boeket_magnifiek.png')}}">
                        <label for="kaart_C">
                            <p>Magnifieke 5 beurtenkaart</p>
                            <p>200 euro (gratis vaas)</p>
                        </label>
                        <div class="plusmin">
                            <input type="number" name="option3" id="kaart_C" data-aanbod="kaart_C" placeholder="0" min="0" value="{{ old('option3', $order->option3 ?? '') }}">
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                            <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                        </div>                        
                    </div>
                    <label for="inzetten_C" class="inzetten">
                        <input type="checkbox" name="" id="inzetten_C">Meteen gebruiken<span>&nbsp;(5 over)</span>
                    </label>
                </fieldset>
                <br>
                <fieldset class="aantal">
                    <div>
                        <img src="{{asset('/media/aanbod/boeket_magnifiek.png')}}">
                        <label for="cadeau">
                            <p>Cadeaubon</p>
                            <p>Bedrag naar keuze</p>
                        </label>
                        <div id="cadeau-prijs">
                            € <input type="number" name="option3" id="cadeau" data-aanbod="cadeau" placeholder="00" min="0">
                        </div>                        
                    </div>
                </fieldset>
                <fieldset class="vraag">
                    <p>Ik kom mijn bestelling ophalen op:</p>
                    @error('day')
                        <p class="error">⚠️ <b>{{ $message }}</b></p>
                    @enderror
                    <select name="day" id="afhaalmoment" required @error('day') class="error" @enderror>
                            <option value="" disabled selected hidden>kies een moment*</option>
                            @foreach ($data as $datum)
                            <option value="{{$datum['date']}}" {{ old('day', $order->day ?? '') == $datum['date'] ? 'selected' : '' }}>
                                {{$datum['day']}} {{$datum['formatted']}}
                                @if ($datum['day'] === 'vrijdag')
                                (15u - 19u)
                                @else
                                (10u - 13u)
                                @endif
                            </option>
                            @endforeach                      
                    </select>
                    <p><i class="small">Adres: <a href="https://maps.app.goo.gl/qAkeHriBos8S4XMcA" target="_blank">Koning Albertlaan 77</a> in Kessel-Lo</i></p>
                    <p><i class="small">Je ontvangt nog een mail met alle informatie.</i></p>
                </fieldset>
                <p class="error lege-bestelling">⚠️ <b>Je hebt nog geen bestelling gemaakt.</b><br><br></p>
                <input type="submit" value="bestelling voltooien">
            </form>
    </main>


@endsection
