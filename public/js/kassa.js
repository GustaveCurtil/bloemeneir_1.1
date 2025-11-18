let inputBoeket_A = document.querySelector('input#boeket_A')
let inputBoeket_B = document.querySelector('input#boeket_B')
let inputBoeket_C = document.querySelector('input#boeket_C')
let inputKaart_A = document.querySelector('input#kaart_A')
let inputKaart_B = document.querySelector('input#kaart_B')
let inputKaart_C = document.querySelector('input#kaart_C')
let inputCadeau = document.querySelector('input#cadeau')

let inputs = document.querySelectorAll('[data-aanbod]')

let afhaalselector = document.querySelector('select#afhaalmoment');
let afhaalmomenten = document.querySelectorAll('option');


let legeBestelling = document.querySelector('.lege-bestelling');

let boeketInputten = document.querySelectorAll('#boeketten .plusmin>input');
let kaartInputten = document.querySelectorAll('#kaarten .plusmin>input');
let gebruikCheckboxen = document.querySelectorAll('.inzetten');

document.addEventListener('DOMContentLoaded', () => {
    inputBoeket_A.value = boeket_A
    inputBoeket_B.value = boeket_B
    inputBoeket_C.value = boeket_C
    inputKaart_A.value = kaart_A
    inputKaart_B.value = kaart_B
    inputKaart_C.value = kaart_C
    inputCadeau.value = cadeau

    updateGebruikCheckboxen()

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            localStorage.setItem(input.dataset.aanbod, input.value);
            totaal = berekenTotaal();
            if (totaal > 0) {
                legeBestelling.classList.remove('active')
            }
             updateGebruikCheckboxen()
        });
    });

    for (let i = 0; i < gebruikCheckboxen.length; i++) {
        const gebruikCheckbox = gebruikCheckboxen[i];
        gebruikCheckbox.addEventListener('change', (e) => {
            
        })
    }


    afhaalmomenten.forEach(afhaalmoment => {
        if (afhaalmoment.value === localStorage.getItem("afhaalmoment")) {
            afhaalmoment.selected = true;
        }
    });

    afhaalselector.addEventListener('input', (e) => {
        localStorage.setItem("afhaalmoment", e.target.value);
    })
    
})

function gaNaarBetaling() {
    if (totaal === 0) {
        let legeBestelling = document.querySelector('.lege-bestelling');
        legeBestelling.classList.add('active')
        return false
    } else {
        return true
    }
}

function updateGebruikCheckboxen() {
    for (let i = 0; i < kaartInputten.length; i++) {
        const input = kaartInputten[i];
        if (input.value > 0) {
            gebruikCheckboxen[i].classList.add('active');
        } else {
            gebruikCheckboxen[i].classList.remove('active');
        }
    }
}