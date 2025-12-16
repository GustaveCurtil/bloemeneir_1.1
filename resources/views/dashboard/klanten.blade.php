@extends('dashboard._layout')

@section('title', 'klanten')

@section('main')
<main>
@auth
    <section>
        <h2>Alle klanten</h2>
        <table>
            <thead>
                <th>naam</th>
                <th>nr</th>
                <th>mail</th>
                <th>nieuwsbrief</th>
            </thead>
            <tbody>
                @foreach ($klanten as $klant)
                <tr>
                    <td>{{$klant->first_name}}</td>
                    <td>{{$klant->phone}}</td>
                    <td>{{$klant->email}}</td>
                    <td>
                        @if ($klant->nieuwsbrief)
                        ja
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