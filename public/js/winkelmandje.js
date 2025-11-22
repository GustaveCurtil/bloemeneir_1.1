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
let momentGekozen = false;


let legeBestelling = document.querySelector('.lege-bestelling');

let boeketInputten = document.querySelectorAll('#boeketten .plusmin>input');
let kaartInputten = document.querySelectorAll('#kaarten .plusmin>input');
let gebruikCheckboxen = document.querySelectorAll('.inzetten');

document.addEventListener('DOMContentLoaded', () => {
    updateInputFields();

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
        const checkbox = gebruikCheckboxen[i].querySelector('input');
        const span = gebruikCheckboxen[i].querySelector('span');
        const boeket = boeketInputten[i];
        checkbox.addEventListener('change', (e) => {
            if (checkbox.checked) {
                localStorage.setItem(checkbox.id, true);
                if (boeket.value == 0) {
                    console.log(boeket.value);
                    localStorage.setItem(boeket.dataset.aanbod, Number(boeket.value) + 1);
                    berekenTotaal();
                    updateInputFields();
                }
            } else {
                localStorage.setItem(checkbox.id, false);
            }
        })
    }

    for (let i = 0; i < boeketInputten.length; i++) {
        const boeket = boeketInputten[i];
        const checkbox = gebruikCheckboxen[i].querySelector('input');
        const span = gebruikCheckboxen[i].querySelector('span');
        boeket.addEventListener('input', (e) => {
            if (boeket.value == 0) {
                checkbox.checked = false;
                localStorage.setItem(checkbox.id, false);
            }
            
        })
        
    }


    afhaalmomenten.forEach(afhaalmoment => {
        if (afhaalmoment.value === localStorage.getItem("afhaalmoment")) {
            afhaalmoment.selected = true;
            momentGekozen = true;
        }
    });

    afhaalselector.addEventListener('input', (e) => {
        localStorage.setItem("afhaalmoment", e.target.value);
        momentGekozen = true;
    })
    
})

function gaNaarBetaling() {
    totaal = berekenTotaal();
    if (totaal === 0) {
        let legeBestelling = document.querySelector('.lege-bestelling');
        legeBestelling.classList.add('active')
        return false;
    } else {
        if (!momentGekozen) {
            let geenMoment = document.querySelector('.geen-moment');
            geenMoment.classList.add('active')
            return false; 
        } else {
            window.location.href = '/winkel/kassa';
            return true;
        } 
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

function updateInputFields() {
    inputBoeket_A.value = boeket_A
    inputBoeket_B.value = boeket_B
    inputBoeket_C.value = boeket_C
    inputKaart_A.value = kaart_A
    inputKaart_B.value = kaart_B
    inputKaart_C.value = kaart_C
    inputCadeau.value = cadeau

    for (let i = 0; i < gebruikCheckboxen.length; i++) {
        const checkbox = gebruikCheckboxen[i].querySelector('input');
        const span = gebruikCheckboxen[i].querySelector('span');
        const boeket = boeketInputten[i];
        console.log(localStorage.getItem(checkbox.id));
        if (localStorage.getItem(checkbox.id) === "true") {
            checkbox.checked = true;
            if (boeket.value == 0) {
                localStorage.setItem(boeket.dataset.aanbod, Number(boeket.value) + 1);
                berekenTotaal();
                updateInputFields();
            }
        } else {
            checkbox.checked = false;
        }
    }

}