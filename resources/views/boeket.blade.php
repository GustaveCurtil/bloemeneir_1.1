@extends('_layout')

@section('title', 'boeket 1')

@section('main')

    <main>
        <h2>boeketten bestellen</h2>
        <section>
            <p>De boeketten kunnen vrijdag 26 september bij ons worden afgehaald in de <a href="https://maps.app.goo.gl/Hf76uVXTM3qEuUUi9" target="_blank">Stijn steruvelslaan 24</a> in Kessel-Lo</p>
        </section>
        
            <form action="{{ route('order') }}" method="POST" >
                @csrf
                <fieldset id="aantal">
                    <div>
                        <img src="{{asset('/media/boeket.png')}}" alt="">
                        <label for="boeket1">
                            <p>Aantal boeketten pakket 1</p>
                            <p>30 euro</p>
                        </label>
                        <input type="number" name="option1" id="boeket1" placeholder="0" min="0">
                    </div>
                    <div>
                        <img src="{{asset('/media/boeket.png')}}" alt="">
                        <label for="boeket2">
                            <p>Aantal boeketten pakket 2</p>
                            <p>50 euro</p>
                        </label>
                        <input type="number" name="option2" id="boeket2" placeholder="0" min="0">                      
                    </div>
                    <div>
                        <img src="{{asset('/media/boeket.png')}}" alt="">
                        <label for="boeket2">
                            <p>Aantal boeketten pakket 2</p>
                            <p>60 euro</p>
                        </label>
                        <input type="number" name="option3" id="boeket3" placeholder="0"  min="0">                        
                    </div>
                </fieldset>
                <fieldset>
                    <label for="naam">naam</label>
                    <input type="text" name="first_name" id="naam">
                    <label for="nummer">telefoonnummer*</label>
                    <input type="tel" name="phone" id="nummer" required>
                    <label for="email">email*</label>
                    <input type="email" name="email" id="email" required>
                </fieldset>
                <fieldset>
                    <label for="">
                    <input type="checkbox" name="akkoord" id=""> Ik kom mijn bestelling vrijdag 26 september halen.
                    </label>
                </fieldset>
                <input type="submit" value="bestellen">
            </form>
    </main>

@endsection
