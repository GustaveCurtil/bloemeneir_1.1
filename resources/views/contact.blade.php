@extends('_layout')

@section('title', 'informatie')

@section('links')
<script src="{{asset('/js/kopieren.js')}}" defer></script>
@endsection

@section('main')

    <main>
        <section id="contact">
            <p>
              In het hartje van Kessel-Lo, <br>
              in het kleinste pand van de <a href="https://maps.app.goo.gl/qAkeHriBos8S4XMcA" target="_blank" style="text-wrap-mode: nowrap">Koning Albertlaan</a>, <br>
              op nummer 77, <br><br>
              Daar vind je de Bloemenier.
            </p>
        </section>
        <section id="kaart">
          <div>
            <a href="https://maps.app.goo.gl/qAkeHriBos8S4XMcA" target="_blank">
            <img src="{{asset('/media/kaart1.png')}}" alt="">
            </a>
          </div>
          <img src="{{asset('/media/huis.png')}}" alt="">
        </section>
        <section id="contact">
          <h2 style="text-align: center">Contact</h2>
            <p><u onclick="copy('info@bloemenier.be', 'info@bloemenier.be')">info@bloemenier.be</u></p>
            <p><a href="https://www.instagram.com/bloemenier/#" target="_blank">instagram-pagina</a></p>
        </section>
    </main>

 {{-- <script>
const img = document.querySelector("#kaart img");
const link = document.querySelector("#kaart a");

// Mouse events
img.addEventListener('mouseenter', () => img.classList.add('mouse'));
img.addEventListener('mouseleave', () => img.classList.remove('mouse'));

// Touch events
img.addEventListener('touchstart', () => {
  img.classList.add('mouse');
});

img.addEventListener('touchend', (e) => {
  img.classList.remove('mouse');
  // If the user just tapped (not scrolled), follow the link
  if (e.changedTouches.length === 1 && !didScroll) {
    window.open(link.href, link.target || "_self");
  }
  didScroll = false; // reset
});

img.addEventListener('touchcancel', () => {
  img.classList.remove('mouse');
});

// Detect scroll during touch
let startY = 0;
let didScroll = false;

img.addEventListener('touchstart', (e) => {
  startY = e.touches[0].clientY;
  didScroll = false;
});

img.addEventListener('touchmove', (e) => {
  const currentY = e.touches[0].clientY;
  if (Math.abs(currentY - startY) > 10) {
    didScroll = true; // mark as scroll, not a tap
  }
});
</script> --}}

@endsection
