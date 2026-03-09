@extends('dashboard._layout')

@section('title', 'bonnen')

@section('main')
<main>
@auth
    <section>
        <h2>Cadeaubonnen</h2>
        <table>
            <thead>
                <th>gekocht door</th>
                <th>mail</th>
                <th>overblijvend</th>
                <th>twv</th>
                <th>aangekocht op</th>
                <th>geldig tot</th>
            </thead>
            <tbody>
                @foreach ($bonnen as $bon)
                <tr>
                    <td>{{$bon->order->client->first_name}}</td>
                    <td>{{$bon->order->client->email}}</td>
                    <td>{{$bon->amount}}</td>
                    <td>{{$bon->original_amount}}</td>
                    <td>{{$bon->created_at}}</td>
                    <td>{{$bon->valid_date}}</td>
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