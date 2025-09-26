@extends('_layout')

@section('title', 'bestellen')
{{-- 
@section('links')
<script src="{{asset('/js/autofill.js')}}" defer></script>
@endsection --}}

@section('main')

    <main>
        <h2>boeketten bestellen</h2>
            <form action="{{ route('order') }}" method="POST" >
                @csrf
                @error('options')
                    <br>
                    <p class="error">⚠️ <b>{{ $message }}</b></p>
                    <br>
                @enderror
                <fieldset id="aantal">
                    <div>
                        <div class="afbeelding"></div>
                        <label for="boeket1">
                            <p>Schattige boeketten</p>
                            <p>30 euro</p>
                        </label>
                        <div class="plusmin">
                            <input type="number" name="option1" id="boeket1" placeholder="0" min="0" value="{{ old('option1', $order->option1 ?? '') }}">
                            <div onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</div>
                            <div onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</div>
                        </div>
                    </div>
                    <div>
                        <div class="afbeelding"></div>
                        <label for="boeket2">
                            <p>Charmante boeketten</p>
                            <p>50 euro</p>
                        </label>
                        <div class="plusmin">
                            <input type="number" name="option2" id="boeket2" placeholder="0" min="0" value="{{ old('option2', $order->option2 ?? '') }}">
                            <div onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</div>
                            <div onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</div>
                        </div>                      
                    </div>
                    <div>
                        <div class="afbeelding"></div>
                        <label for="boeket3">
                            <p>Magnifieke boeketten</p>
                            <p>60 euro</p>
                        </label>
                        <div class="plusmin">
                            <input type="number" name="option3" id="boeket3" placeholder="0" min="0" value="{{ old('option3', $order->option3 ?? '') }}">
                            <div onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</div>
                            <div onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</div>
                        </div>                        
                    </div>
                </fieldset>
                <fieldset class="vraag">
                    <p>Ik kom mijn bestelling ophalen op:</p>
                    @error('day')
                        <p class="error">⚠️ <b>{{ $message }}</b></p>
                    @enderror
                    <select name="day" id="" required @error('day') class="error" @enderror>
                            <option>kies een moment*</option>
                            @foreach ($data as $datum)
                            <option value="{{$datum['date']}}" {{ old('day', $order->day ?? '') == $datum['date'] ? 'selected' : '' }}>
                                {{$datum['day']}} {{$datum['formatted']}}
                                @if ($datum['day'] === 'vrijdag')
                                (16u - 19u)
                                @else
                                (10u - 13u)
                                @endif
                            </option>
                            @endforeach                      
                    </select>
                    <p><i class="small">Adres: <a href="https://maps.app.goo.gl/qAkeHriBos8S4XMcA" target="_blank">Koning Albertlaan 77</a> in Kessel-Lo</i></p>
                    <p><i class="small">Je ontvangt nog een mail met alle informatie.</i></p>
                </fieldset>
                <fieldset>
                    <label for="naam">jouw naam*:</label>
                    <input type="text" name="first_name" id="naam" value="{{ old('first_name', $client->first_name ?? '') }}" placeholder="vul hier in" required>
                    <label for="email">email*:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $client->email ?? '') }}" placeholder="vul hier in" required>
                    <label for="nummer">telefoonnummer <i class="small">(in case of)</i>:</label>
                    <input type="tel" name="phone" id="nummer" value="{{ old('phone', $client->phone ?? '') }}" placeholder="vul hier in">
                    <label class="rij">
                        <input type="checkbox" name="nieuwsbrief" value="1"
                            {{ old('nieuwsbrief', $client->nieuwsbrief ?? 0) == 1 ? 'checked' : '' }}>
                        nieuwsbrief&nbsp;<i class="small">(max 4x per jaar)</i>
                    </label>
                </fieldset>
                <input type="submit" value="bestellen">
            </form>
    </main>


@endsection
