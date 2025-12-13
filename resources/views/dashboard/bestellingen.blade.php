@extends('dashboard._layout')

@section('title', 'bestellingen')

@section('main')
<main>
@auth
    <section>
        <h2>Komende bestellingen</h2>
        <p>OPM: pas vanaf 13/12/2025 staan de effectief betaalde prijs. Tot ervoor geldt '€0' is betaald, anders staar er een 'nee'</p>
        <table>
            <thead>
                <th>naam</th>
                <th>mail</th>
                <th>❀ sch.</th>
                <th>❀ cha.</th>
                <th>❀ mag.</th>
                <th>▰ sch.</th>
                <th>▰ cha.</th>
                <th>▰ mag.</th>
                <th>▩ bon</th>
                <th>codes</th>
                <th>dag</th>
                <th>betaald</th>
            </thead>
            <tbody>
                @foreach ($bestellingen as $bestelling)
                <tr>
                    <td>{{$bestelling->client->first_name}}</td>
                    <td>{{$bestelling->client->email}}</td>
                    <td>{{$bestelling->option1}}</td>
                    <td>{{$bestelling->option2}}</td>
                    <td>{{$bestelling->option3}}</td>
                    <td>{{$bestelling->schattigeVouchers->count()}}</td>
                    <td>{{$bestelling->charmanteVouchers->count()}}</td>
                    <td>{{$bestelling->magnifiekeVouchers->count()}}</td>
                    <td>{{$bestelling->giftVoucher?->amount ?? "" }}</td>
                    <td>{{
                            ($bestelling->giftVouchersUsed?->count() ?? 0)
                            +
                            ($bestelling->turnVouchersUsed?->count() ?? 0)
                        }}
                    </td>
                    <td>{{$bestelling->day}}</td>
                    <td>
                        @if ($bestelling->payed)
                        €{{$bestelling->total_discount}}
                        @else 
                        nee
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@else
    @include('dashboard._login')
@endauth
</main>
@endsection