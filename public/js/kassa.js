let inputBoeket_A = document.querySelector('input#boeket_A')
let inputBoeket_B = document.querySelector('input#boeket_B')
let inputBoeket_C = document.querySelector('input#boeket_C')
let inputKaart_A = document.querySelector('input#kaart_A')
let inputKaart_B = document.querySelector('input#kaart_B')
let inputKaart_C = document.querySelector('input#kaart_C')
let inputCadeau = document.querySelector('input#cadeau')

let inputs = document.querySelectorAll('[data-aanbod]')

document.addEventListener('DOMContentLoaded', () => {
    inputBoeket_A.value = boeket_A
    inputBoeket_B.value = boeket_B
    inputBoeket_C.value = boeket_C
    inputKaart_A.value = kaart_A
    inputKaart_B.value = kaart_B
    inputKaart_C.value = kaart_C
    inputCadeau.value = cadeau
    console.log(inputs)
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            console.log(input.dataset.aanbod)
            localStorage.setItem(input.dataset.aanbod, input.value);
        });
    });
    
})