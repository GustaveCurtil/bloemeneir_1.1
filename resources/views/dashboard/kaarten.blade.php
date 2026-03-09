@extends('dashboard._layout')

@section('title', 'kaarten')

@section('main')
<main>
@auth
    <section>
        <h2>5-beurtenkaarten</h2>
        <table>
            <thead>
                <th>gekocht door</th>
                <th>mail</th>
                <th>soort</th>
                <th>overblijvend</th>
                <th>van de</th>
                <th>aangekocht op</th>
                <th>geldig tot</th>
            </thead>
            <tbody>
                @foreach ($kaarten as $kaart)
                <tr>
                    <td>{{$kaart->order->client->first_name}}</td>
                    <td>{{$kaart->order->client->email}}</td>
                    <td>{{$kaart->name}}</td>
                    @if ($kaart->name === 'schattig')
                    <td>{{$kaart->option1}}</td>
                    <td>{{$kaart->option1_original}}</td>
                    @elseif ($kaart->name === 'charmant')
                    <td>{{$kaart->option2}}</td>
                    <td>{{$kaart->option2_original}}</td> 
                    @elseif ($kaart->name === 'magnifiek')
                    <td>{{$kaart->option3}}</td>
                    <td>{{$kaart->option3_original}}</td> 
                    @endif                                       
                    <td>{{$kaart->created_at}}</td>
                    <td>{{$kaart->valid_date}}</td>
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