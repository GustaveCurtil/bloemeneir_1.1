@extends('_layout')

@section('title', 'Betaling')

@section('main')
<main>
    <form action="">
        <fieldset>
                    <label for="naam">jouw voornaam*:</label>
                    <input type="text" name="first_name" id="naam" value="{{ old('first_name', $client->first_name ?? '') }}" placeholder="vul hier in" required>
                    <label for="achternaam">jouw achternaam:</label>
                    <input type="text" name="last_name" id="achternaam" value="{{ old('last_name', $client->last_name ?? '') }}" placeholder="vul hier in" required>
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
    </form>
    <section>
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
</script>
@endsection