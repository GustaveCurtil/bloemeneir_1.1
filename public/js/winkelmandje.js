let boeket_A = Number(localStorage.getItem("boeket_A")) || 0;
let boeket_B = Number(localStorage.getItem("boeket_B")) || 0;
let boeket_C = Number(localStorage.getItem("boeket_C")) || 0;
let kaart_A = Number(localStorage.getItem("kaart_A")) || 0;
let kaart_B = Number(localStorage.getItem("kaart_B")) || 0;
let kaart_C = Number(localStorage.getItem("kaart_C")) || 0;
let cadeau = Number(localStorage.getItem("cadeau")) || 0;

let inkoopMap = { boeket_A, boeket_B, boeket_C, kaart_A, kaart_B, kaart_C, cadeau };

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
    }


})


function berekenTotaal() {
    boeket_A = Number(localStorage.getItem("boeket_A")) || 0;
    boeket_B = Number(localStorage.getItem("boeket_B")) || 0;
    boeket_C = Number(localStorage.getItem("boeket_C")) || 0;
    kaart_A = Number(localStorage.getItem("kaart_A")) || 0;
    kaart_B = Number(localStorage.getItem("kaart_B")) || 0;
    kaart_C = Number(localStorage.getItem("kaart_C")) || 0;
    let cado = Number(localStorage.getItem("cadeau")) || 0;

    inkoopMap = { boeket_A, boeket_B, boeket_C, kaart_A, kaart_B, kaart_C, cadeau: cado };

    // zorg dat we geen 'cadeau' dubbel tellen: cadeau telt als 1 wanneer >0
    const { cadeau, ...rest } = inkoopMap;

    // sommeer alle overige items (forceer naar Number)
    const totaalAndere = Object.values(rest)
        .reduce((sum, v) => sum + (Number(v) || 0), 0);

    const cadeaubon = Number(cadeau) > 0 ? 1 : 0;
    return totaalAndere + cadeaubon;
}

function updateMandjes() {
    knoppen.forEach(knop => {
        let span = knop.querySelector('span');
        if (knop.dataset.aanbod === "cadeau") {
            span.textContent = `(${inkoopMap[knop.dataset.aanbod] ?? 0} euro)`;
        } else {
            span.textContent = `(${inkoopMap[knop.dataset.aanbod] ?? 0})`;
        }
        
    });
}

function updateWinkelmandje() {
    let totaal = berekenTotaal();
    let aantalDingen = document.querySelector('span#amount')
    if (totaal > 0) {
        winkelmandje.classList.add('active');
        if (totaal === 1) {
            aantalDingen.textContent = totaal + " iets"
        } else {
            aantalDingen.textContent = totaal + " dingen"
        }
        
    } else {
        winkelmandje.classList.remove('active');
    }
}

function resetWinkelwagen() {
    Object.keys(inkoopMap).forEach(item => {
        inkoopMap[item] = 0;
        console.log(item + ": " + inkoopMap[item] )
        localStorage.setItem(item, 0);
    });
    console.log(boeket_A )
    updateMandjes()
    updateWinkelmandje()
}