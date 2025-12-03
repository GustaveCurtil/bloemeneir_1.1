let boeket_A = Number(localStorage.getItem("boeket_A")) || 0;
let boeket_B = Number(localStorage.getItem("boeket_B")) || 0;
let boeket_C = Number(localStorage.getItem("boeket_C")) || 0;

let kaart_A = Number(localStorage.getItem("kaart_A")) || 0;
let kaart_B = Number(localStorage.getItem("kaart_B")) || 0;
let kaart_C = Number(localStorage.getItem("kaart_C")) || 0;

let priceBoeket_A = 29;
let priceBoeket_B = 39;
let priceBoeket_C = 49;
let priceKaart_A = 145;
let priceKaart_B = 190;
let priceKaart_C = 239;

let inzetten_A = JSON.parse(localStorage.getItem("inzetten_A")) ?? false;
let inzetten_B = JSON.parse(localStorage.getItem("inzetten_B")) ?? false;
let inzetten_C = JSON.parse(localStorage.getItem("inzetten_C")) ?? false;

let cadeau = Number(localStorage.getItem("cadeau")) || 0;

let total = 0;

let overzicht = document.querySelector('ul');
let totalPlaceholder = document.querySelector('.totaal .prijs');

addBoeketKaartGroup('schattig', boeket_A, kaart_A, amount_A, inzetten_A, priceBoeket_A, priceKaart_A);
addBoeketKaartGroup('charmant', boeket_B, kaart_B, amount_B, inzetten_B, priceBoeket_B, priceKaart_B);
addBoeketKaartGroup('magnifiek', boeket_C, kaart_C, amount_C, inzetten_C, priceBoeket_C, priceKaart_C);
updateTotal();

function addBoeketKaartGroup(label, boeketten, kaarten, gratisBeurten, inzetten, prijsBoeket, prijsKaart) {
  
  let inzetBeurten = 0;
  let totaalBeurten = 0;

  if (inzetten) {
    inzetBeurten = (kaarten * 5)
    totaalBeurten = inzetBeurten + gratisBeurten;
  } else {
    totaalBeurten = gratisBeurten;
  }

  if (boeketten > 0) {
    if (totaalBeurten > 0) {
      if (boeketten < totaalBeurten) {
        let boeketItem = document.createElement("li");
        boeketItem.id = "boeketten"
        boeketItem.innerHTML = `${label} boeket x ${boeketten} <span>= <s>€${formatEuro(boeketten * prijsBoeket)}</s> €0,00</span>`;
        overzicht.appendChild(boeketItem);
      } else {
        let overblijvend = boeketten - (totaalBeurten);
        let boeketItem = document.createElement("li");
        boeketItem.id = "boeketten"
        boeketItem.innerHTML = `${label} boeket x ${boeketten} <span>= <s>€${formatEuro(boeketten * prijsBoeket)}</s> €${formatEuro(overblijvend * prijsBoeket)}</span>`;
        overzicht.appendChild(boeketItem);
      }
    } else {
        let boeketItem = document.createElement("li");
        boeketItem.id = "boeketten"
        boeketItem.innerHTML = `${label} boeket x ${boeketten} <span>= €${formatEuro(boeketten * prijsBoeket)}</span>`;
        overzicht.appendChild(boeketItem);
    }
  }

  if (kaarten > 0) {
    for (let i = 0; i < kaarten; i++) {
      let kaartItem = document.createElement("li");
      kaartItem.id = "kaarten"
      kaartItem.innerHTML = `${label}e 5-beurtenkaart <span>= €${formatEuro(prijsKaart)}</span>`;
      overzicht.appendChild(kaartItem); 

      if (0 < boeketten && inzetBeurten > 0) {
        let aftrekken;
        if (5 <= boeketten) {
          boeketten -= 5;
          inzetBeurten -= 5
          aftrekken = 5;
        } else if (inzetBeurten > boeketten) {     
          inzetBeurten -= boeketten;
          aftrekken = boeketten;
          boeketten = 0
        }
        let p = document.createElement("p");
        p.innerHTML = `&nbsp;⤷  meteen gebruiken: ${(5 - aftrekken)} over`;
        overzicht.appendChild(p);
      }
    }
  }
  let kortingen = document.querySelectorAll('[data-name="' + label + '"]');
  console.log(kortingen.length)
  kortingen.forEach(korting => {
    let kortingBeurtenPlaceholder = korting.querySelector('p:last-of-type>span');
    let kortingBeurten = Number(kortingBeurtenPlaceholder.textContent);
    let aftrekken = 0;
    if (boeketten < kortingBeurten) {
      aftrekken = boeketten;
      boeketten = 0;
    } else {
      aftrekken = kortingBeurten;
    }

    if (aftrekken > 0) {
      kortingBeurtenPlaceholder.innerHTML = `<s>${kortingBeurten}</s> ${kortingBeurten - aftrekken }`
    }
    
  });
  console.log(boeketten)
  total += boeketten * prijsBoeket;
  total += kaarten * prijsKaart;
}

function updateTotal() {
  totalPlaceholder.innerHTML = total + ",00 euro"
}

function formatEuro(value) {
    return value.toLocaleString('nl-NL', {
        minimumFractionDigits: 2,
        useGrouping: false
    });
};

