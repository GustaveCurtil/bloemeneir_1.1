@extends('_layout')

@section('title', 'winkelmandje')

@section('links')
<script src="{{asset('/js/winkelbanner.js')}}" defer></script>
<script src="{{asset('/js/winkelmandje.js')}}" defer></script>
@endsection

@section('main')

    <main>
        <div class="left-right">
            <h2>Winkelmandje</h2>
            <a href="/winkel">terug</a>
        </div>
        <h3>Bestellingen op afhalen</h3>
        <p>Boeket voor deze week graag vòòr woensdag 18u bestellen.</p>
        <br>
        <p>De volledige opbrengst van de verkoop op <b>12 en 13 december</b> schenken we aan de ☀ <b>Warmste Week</b> ☀</p>
        <br>
        
        <form>
            <fieldset class="aantal" id="boeketten">
                <div>
                    <img src="{{asset('/media/winkel/boeket_schattig.png')}}">
                    <label for="boeket_A">
                        <p>Schattig boeket</p>
                        <p>29 euro</p>
                    </label>
                    <div class="plusmin">
                        <input type="number" id="boeket_A" data-aanbod="boeket_A" placeholder="0" min="0">
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                    </div>
                </div>
                <div>
                    <img src="{{asset('/media/winkel/boeket_charmant.png')}}">
                    <label for="boeket_B">
                        <p>Charmant boeket</p>
                        <p>39 euro</p>
                    </label>
                    <div class="plusmin">
                        <input type="number" id="boeket_B" data-aanbod="boeket_B" placeholder="0" min="0">
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                    </div>                      
                </div>
                <div>
                    <img src="{{asset('/media/winkel/boeket_magnifiek.png')}}">
                    <label for="boeket_C">
                        <p>Magnifiek boeket</p>
                        <p>49 euro</p>
                    </label>
                    <div class="plusmin">
                        <input type="number" id="boeket_C" data-aanbod="boeket_C" placeholder="0" min="0">
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                    </div>                        
                </div>
            </fieldset>
            <fieldset class="aantal" id="kaarten">
                <div>
                    <img src="{{asset('/media/winkel/boeket_schattig.png')}}">
                    <label for="kaart_A">
                        <p>Schattige 5 beurtenkaart</p>
                        <p>145 euro (gratis vaas)</p>
                    </label>
                    <div class="plusmin">
                        <input type="number" id="kaart_A" data-aanbod="kaart_A" placeholder="0" min="0">
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                    </div>
                </div>
                <label for="inzetten_A" class="inzetten">
                    <input type="checkbox" name="inzetten_A" id="inzetten_A">Meteen gebruiken
                </label>
                <div>
                    <img src="{{asset('/media/winkel/boeket_charmant.png')}}">
                    <label for="kaart_B">
                        <p>Charmante 5 beurtenkaart</p>
                        <p>190 euro (gratis vaas)</p>
                    </label>
                    <div class="plusmin">
                        <input type="number" id="kaart_B" data-aanbod="kaart_B" placeholder="0" min="0">
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                    </div>                      
                </div>
                <label for="inzetten_B" class="inzetten">
                    <input type="checkbox" name="inzetten_B" id="inzetten_B">Meteen gebruiken
                </label>
                <div>
                    <img src="{{asset('/media/winkel/boeket_magnifiek.png')}}">
                    <label for="kaart_C">
                        <p>Magnifieke 5 beurtenkaart</p>
                        <p>239 euro (gratis vaas)</p>
                    </label>
                    <div class="plusmin">
                        <input type="number" id="kaart_C" data-aanbod="kaart_C" placeholder="0" min="0">
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepUp();  el.dispatchEvent(new Event('input'));">+</div>
                        <div onclick="const el = this.parentNode.querySelector('input[type=number]');  el.stepDown();  el.dispatchEvent(new Event('input'));">-</div>
                    </div>                        
                </div>
                <label for="inzetten_C" class="inzetten">
                    <input type="checkbox" name="" id="inzetten_C">Meteen gebruiken
                </label>
            </fieldset>
            <fieldset class="aantal">
                <div>
                    <img src="{{asset('/media/winkel/boeket_magnifiek.png')}}">
                    <label for="cadeau">
                        <p>Cadeaubon</p>
                        <p>Bedrag naar keuze</p>
                    </label>
                    <div id="cadeau-prijs">
                        € <input type="number" id="cadeau" data-aanbod="cadeau" placeholder="00" min="0">
                    </div>                        
                </div>
                <label for="cadeaubon" class="mailing">
                    <input type="checkbox" name="" id="cadeaubon">Stuur code door via mail <br class="mobile">(i.p.v. bon te komen halen)
                </label>
            </fieldset>
            <fieldset class="vraag">
                <p>Ik kom mijn bestelling ophalen op:</p>
                @error('day')
                    <p class="error">⚠️ <b>{{ $message }}</b></p>
                @enderror
                <select name="day" id="afhaalmoment" required @error('day') class="error" @enderror>
                        <option value="" disabled selected hidden>kies een moment*</option>
                        @foreach ($data as $datum)
                        <option value="{{$datum['takeaway_date']}}">
                            @if ($datum->emoji)
                            {{$datum->emoji}}
                            @endif
                            {{$datum->formatted}}
                        </option>
                        @endforeach                      
                </select>
                <p><i class="small">Adres: <a href="https://maps.app.goo.gl/qAkeHriBos8S4XMcA" target="_blank">Koning Albertlaan 77</a> in Kessel-Lo</i></p>
                <p><i class="small">Je ontvangt nog een mail met alle informatie.</i></p>
            </fieldset>
            <p class="error lege-bestelling">⚠️ <b>Je hebt nog geen bestelling gemaakt.</b></p>
            <p class="error geen-moment">⚠️ <b>Je hebt nog afhaalmoment opgegeven.</b></p>
            <input type="button" value="afrekenen" onclick="gaNaarBetaling()">
        </form>
</main>


@endsection
