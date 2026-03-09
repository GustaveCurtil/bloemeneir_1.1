@extends('dashboard._layout')

@section('title', 'development')

@section('main')
<main>
@auth
<section class="text">
    <p>Hey Anne-Sophie,</p><br>
    <p>Op deze pagina wil ik jou graag op de hoogte willen houden van wat er her en der nog kan aangepast worden voor een optimale website.</p>
    <p>Sommige dingen zijn piepklein, sommigen vragen wat meer werk, en sommigen iets tussen de twee. 😉</p>
    <br>
    <p><b>📋 TD's:</b></p>
    <ul>
        <li>terug een landingspagina</li>
        <li>afhaalmomenten uitschakelen wanneer iemand enkel bonnen of kaarten besteld...</li>
        <li><s>... in de tussentijd duidelijk communiceren dat de afhaalmoment niet veel uitmaakt.</s> ✅ <i>29/12/2025</i></li>
        <li><s>foto Petra en Anne-Sophie bij 'over ons' aanpassen</s> ✅ <i>29/12/2025</i></li>
        <li>bugg met pagina die wegvalt bij de browser Edge onderzoeken</li>
        <li>bugg met meerdere mails voor eenzelfde bestelling oplossen</li>
        <li><s>popup/boodschap voor wanneer Bloemenier op verlof is schrijven</s> ✅ <i>29/12/2025</i></li>

        <li>aangeven of je een factuur wil (+ BTW en adres ingeven), maar in de tussentijd...</li>
        <li>boodschap toevoegen (net voor afrekenen + evt. in mail) in de aard van: "Had je graag een factuur gewenst? Gelieve een mailtje te sturen naar ...ATbloemnier.be met jouw bestelling, btw nummer en adres."</li>
        <li>in het winkelmandje: kleurtjes inputvelden van magnifieke boeket en kaart aanpassen</li>
        <li>in het winkelmandje: meer 'witruimte' tussen de elementen</li>
        <li>momenteel kan je surfen naar <a href="https://bloemenier.be/winkel/afrekenen">/winkel/afrekenen</a> met een lege winkelmand → zou moeten herleiden naar de bestelpagina</li>
        <li>kleuren van de magnifieke boeket, kaart en miniatuurtekening veranderen naar? (ik ben hier zelf geen krak in dus graag zelf te bepalen)</li>
        <li>momenteel is het nog niet mogelijk om handmatig af te melden van dit 'overzichtspaneel' (gebeurt na verloop van tijd wel, maar dus niet wanneer je bv op 'terug naar website' klikt)</li>
        <li>ik heb de database heel orderlijk herontworpen, zodanig dat ik in de toekomst je relatief makkelijk zelf de ophaalmomenten (incl. speciallekes, het ingeven van de laatst mogelijke tijdstip van bestellen, symbooltje indien gewenst, welke data al zichtbaar zullen zijn, etc.)</li>
        <li>overzicht bestellingen kan nog een pak duidelijker en met mogelijkheid tot doorklikken naar kaarten en bonnen (met daar ook telkens een overzicht van wie de voucher heeft gekocht en wie die wanneer heeft gebruikt)</li>
        <br>
        <li><s>winkelbanner niet meer kunnen verwijderen/resetten, maar eerder werken met...</s> ✅</li>
        <li><s>zowel kunnen toevoegen als aftrekken van items (nu kan je enkel toevoegen → kan tot frustraties leiden)</s> ✅</li>
        <li><s>bij cadeaubon (en andere inputvelden) lukte het me niet om een minimum waarde in te voeren → probleem oplossen</s> ✅</li>
        <li><s>bij '+' cadeaubon: alterneren tussen de volgende waarden → 0, 29, 39, 50, 75, 100, 150, 0</s> ✅</li>       
        <li><s>bugg bij inloggen (voor het overzicht)</s> ✅</li>
        <li><s>in 'winkel': data's moeten nog automatisch gelinkt worden met de database en gegroepeerd per bestelling bij de groothandel (met gelijkaardige 'laatst mogelijke bestelmoment'</s> ✅</li>
    </ul>
    <br>
    <p><b>✨ Ideëen:</b></p>
    <ul>
        <li>al verschillende mensen horen zeggen dat ze bij het bestellen van een boeket, graag (een) echte foto('s) van het boeket willen zien. Voorstel: bij het hoveren/klikken over/op een fiche, veranderd deze momenteel van perspectief → daar eventueel een afbeelding in de plaats.</li>
    </ul>
    <br>
    <p><b>📢 Communicatie:</b></p>
    <ul>
        <li>Dit 'overzichtspaneel' is gemaakt voor desktop en, tenzij anders gewenst, ben ik niet van plan deze te optimaliseren voor mobile.</li>
    </ul>
</section>

@else
    @include('dashboard._login')
@endauth
</main>
@endsection