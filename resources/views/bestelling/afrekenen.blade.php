@extends('_layout')

@section('links')
<script src="{{asset('/js/afrekenen2.js')}}" defer></script>
@endsection

@section('title', 'afrekenen')

@section('main')
<main>
    <div class="left-right">
        <h2>Afrekenen</h2>
        <a href="/winkel/winkelmandje">bestelling aanpassen</a>
    </div>
    <section>
        <h3>Overzicht bestelling</h3>
        <ul>
        </ul>
        <div class="totaal">
            <p>TOTAAL:</p>
            <p class="prijs"></p></b>
        </div>
        <div>
            @foreach ($turnCards as $card)
            <div data-name="{{$card->name}}">
                <p>▰ 5-beurtenkaart <span style="font-size: 0.7rem">(code: '{{$card->code}}')</span></p>
                <p>&nbsp;⤷  geldig tot {{$card->valid_date}}</p>
                <p>&nbsp;⤷  <span>{{ $card->option1 ?? $card->option2 ?? $card->option3 ?? 0 }}</span> resterende {{$card->name}}e boeketten</p>
            </div>
            @endforeach
            @foreach ($giftCards as $card)
            <div data-name="cadeau">
                <p>▩ cadeau van €{{$card->original_amount}},00 <span style="font-size: 0.7rem">(code: '{{$card->code}}')</span></p>
                <p>&nbsp;⤷  geldig tot {{$card->valid_date}}</p>
                <p>&nbsp;⤷  <span>€<span>{{$card->amount}}</span>,00</span> over</p>
            </div>
            @endforeach
        </div> 
        <form action="{{ route('check-code') }}" method="POST" class="code">
                @csrf
                <input type="text" name="code" placeholder="code beurtenkaart of bon" required value="">
                <button type="submit">+</button>
        </form>  
        @error('code')
        <p class="error active" style="font-size: 0.9rem; margin-top: var(--gap-mini)">{{ $message }}</p>
        @enderror
        <br>
    </section>

    <form action="{{ route('checkout.pay') }}" method="POST">
        @csrf
        <h3>Jouw gegevens</h3>
        <fieldset>
                    <label for="naam">jouw voornaam*</label>
                    <input type="text" name="first_name" id="naam" value="{{ old('first_name', $client->first_name ?? 'gust') }}" placeholder="vul hier in" required>
                    <label for="achternaam">jouw achternaam <i class="small">(optioneel)</i></label>
                    <input type="text" name="last_name" id="achternaam" value="{{ old('last_name', $client->last_name ?? '') }}" placeholder="vul hier in">
                    <label for="nummer">telefoonnummer <i class="small">(optioneel)</i></label>
                    <input type="tel" name="phone" id="nummer" value="{{ old('phone', $client->phone ?? '') }}" placeholder="vul hier in">
                    <label for="email">e-mailadres*</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $client->email ?? 'gust@cool.be') }}" placeholder="vul hier in" required >
                    <input type="email" name="email" id="email" value="{{ old('email', $client->email ?? 'gust@cool.be') }}" placeholder="herhaal e-mailadres" required >
                    <label class="rij">
                        <input type="checkbox" name="nieuwsbrief" value="1"
                            {{ old('nieuwsbrief', $client->nieuwsbrief ?? 0) == 1 ? 'checked' : '' }}>
                        nieuwsbrief&nbsp;<i class="small">(max 4x per jaar)</i>
                    </label>
                    <input type="hidden" name="boeket_A" value="0">
                    <input type="hidden" name="boeket_B" value="0">
                    <input type="hidden" name="boeket_C" value="0">
                    <input type="hidden" name="kaart_A" value="0">
                    <input type="hidden" name="kaart_B" value="0">
                    <input type="hidden" name="kaart_C" value="0">
                    <input type="hidden" name="inzetten_A" value="0">
                    <input type="hidden" name="inzetten_B" value="0">
                    <input type="hidden" name="inzetten_C" value="0">
                    <input type="hidden" name="cadeau" value="0">
                    <input type="hidden" name="day" value="0">
                    @foreach ($turnCards as $card)
                    <input type="hidden" name="turnCardCodes[]" value="{{$card->code}}">             
                    @endforeach
                    @foreach ($giftCards as $card)
                    <input type="hidden" name="giftCardCodes[]" value="{{$card->code}}">
                    @endforeach
        </fieldset>
        <input type="submit" value="Betaal met Bancontact">
    </form>
</main>
    {{-- <section>
        <h2>Jouw gegevens</h2>
        <p>Naam: <b>{{$client->first_name}} {{$client->last_name}}</b></p>
        <p>Telefoonnummer: <b>{{$client->phone}}</b> <i class="small">(wordt enkel gebruikt indien noodzakelijk)</i></p>
        <p>E-mailadres: <b>{{$client->email}}</b></p>
        <p>Nieuwsbrief: 
            @if ($client->nieuwsbrief)
            <b>Ja</b> <i class="small">(ongeveer 4 keer per jaar)</i>
            @else
            <b>Nee bedankt</b>
            @endif
        </p>
    </section>
    <section>
        <h2>Jouw bestelling (nog niet betaald)</h2>
        <ul>
            <li>Schattig boeket x {{ $order->option1 }} = €{{ number_format(29 * $order->option1, 2 , ',')}}</li>
            <li>Charmant boeket x {{ $order->option2 }} = €{{ number_format(39 * $order->option2, 2 , ',')}}</li>
            <li>Magnifiek boeket x {{ $order->option3 }} = €{{ number_format(49 * $order->option3, 2 , ',')}}</li>
        </ul>
        <p><strong>Totaal: €{{ number_format((29 * $order->option1) + (39 * $order->option2) + (49 * $order->option3), 2, ',') }}</strong></p>
        <br>
        <p>Je komt jouw boeket halen op <b>{{$dag}} {{$datum}}
            @if ($dag === 'vrijdag')
            (tussen 15u en 19u)
            @else
            (tussen 10u en 13u)
            @endif
            </b>
        </p>
    </section>
    <section>
        <a href="{{ route('checkout.backToForm', ['order' => $order, 'client' => $client]) }}">
            klik hier om nog even iets aanpassen
        </a>
    </section>
    <input type="submit" id="payButton" value="Betaal met Bancontact">
    @if(session('message'))
    <br>
    <p class="error">⚠️ <b>{{ session('message') }}</b></p>
    @endif
</main>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const payButton = document.getElementById('payButton');

    payButton.addEventListener('click', async (e) => {
        e.preventDefault();

        const {error} = await stripe.confirmBancontactPayment(
            '{{ $clientSecret }}', {
                payment_method: {
                    billing_details: {
                        name: '{{ $client->first_name }} {{ $client->last_name ?? "" }}',
                        email: '{{ $client->email }}',
                        phone: '{{ $client->phone }}',
                    }
                },
                return_url: '{{ route("checkout.success") }}'
            }
        );

        if (error) {
            alert(error.message);
        }
    });
</script> --}}

<script>
    let amount_A = 0;
    let amount_B = 0
    let amount_C = 0
    let amountGift = 0
    @foreach ($turnCards as $card)
        amount_A += {{ $card->option1 ?? 0 }};
        amount_B += {{ $card->option2 ?? 0 }};
        amount_C += {{ $card->option3 ?? 0 }};
    @endforeach
    // @foreach ($giftCards as $card)
    //     amountGift += {{$card->amount}};
    // @endforeach
</script>
@endsection