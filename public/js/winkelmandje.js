let boeket_A = Number(localStorage.getItem("boeket_A")) || 0;
let boeket_B = Number(localStorage.getItem("boeket_B")) || 0;
let boeket_C = Number(localStorage.getItem("boeket_C")) || 0;
let kaart_A = Number(localStorage.getItem("kaart_A")) || 0;
let kaart_B = Number(localStorage.getItem("kaart_B")) || 0;
let kaart_C = Number(localStorage.getItem("kaart_C")) || 0;
let cadeau = Number(localStorage.getItem("cadeau")) || 0;

const inkoopMap = { boeket_A, boeket_B, boeket_C, kaart_A, kaart_B, kaart_C, cadeau };

let inzetten_A = JSON.parse(localStorage.getItem("inzetten_A")) ?? false;
let inzetten_B = JSON.parse(localStorage.getItem("inzetten_B")) ?? false;
let inzetten_C = JSON.parse(localStorage.getItem("inzetten_C")) ?? false;

let datum = localStorage.getItem("datum") ?? null;

let totaal = 0;

let winkelmandje = document.querySelector('#shopping-card');
const knoppen = document.querySelectorAll('button[data-aanbod]');

document.addEventListener('DOMContentLoaded', () => {
    updateMandjes()
    berekenTotaal();
    if (winkelmandje) {
        updateWinkelmandje();
        winkelmandje.addEventListener('click', (e) => {
            window.location.href = "/aanbod/winkelmandje"
        })
    }


})


function berekenTotaal() {
    let cadeaubon = cadeau > 0 ? 1 : 0;
    return boeket_A + boeket_B + boeket_C + kaart_A + kaart_B + kaart_C + cadeaubon;
}

function updateMandjes() {
    knoppen.forEach(knop => {
        let span = knop.querySelector('span');
        span.textContent = `(${inkoopMap[knop.dataset.aanbod] ?? 0})`;
    });
}

function updateWinkelmandje() {
    const totaal = berekenTotaal();
    let aantalDingen = document.querySelector('span#amount')
    if (totaal > 0) {
        winkelmandje.classList.add('active');
        aantalDingen.textContent = totaal + " dingen"
    } else {
        winkelmandje.classList.remove('active');
    }
}