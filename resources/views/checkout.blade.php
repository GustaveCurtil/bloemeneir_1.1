@extends('_layout')

@section('title', 'Betaling')

@section('main')
<main>
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
            (tussen 16u en 19u)
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