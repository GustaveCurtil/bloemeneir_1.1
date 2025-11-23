let boeket_A = Number(localStorage.getItem("boeket_A")) || 0;
let boeket_B = Number(localStorage.getItem("boeket_B")) || 0;
let boeket_C = Number(localStorage.getItem("boeket_C")) || 0;
let kaart_A = Number(localStorage.getItem("kaart_A")) || 0;
let kaart_B = Number(localStorage.getItem("kaart_B")) || 0;
let kaart_C = Number(localStorage.getItem("kaart_C")) || 0;
let cadeau = Number(localStorage.getItem("cadeau")) || 0;

let inzetten_A = JSON.parse(localStorage.getItem("inzetten_A")) ?? false;
let inzetten_B = JSON.parse(localStorage.getItem("inzetten_B")) ?? false;
let inzetten_C = JSON.parse(localStorage.getItem("inzetten_C")) ?? false;

let overzicht = document.querySelector('ul#overzicht');

addItem("Schattig boeket", boeket_A, 29.00);
addItem("Charmant boeket", boeket_B, 39.00);
addItem("Magnifiek boeket", boeket_C, 49.00);
addItem("Schattige 5-beurtenkaart", kaart_A, 120.00);
addBoolean("5-beurtenkaart inzetten", inzetten_A);
addItem("Charmante 5-beurtenkaart", kaart_B, 160.00);
addBoolean("5-beurtenkaart inzetten", inzetten_B);
addItem("Magnifiek 5-beurtenkaart", kaart_C, 200.00);
addBoolean("5-beurtenkaart inzetten", inzetten_C);
addItem("Cadeaubon", cadeau);

function addItem(label, value, price) {
  if (value > 0) {
    let li = document.createElement("li");
    li.innerHTML = `${label} x ${value} <span>= €${(value * price).toFixed(2)}</span>`;
    overzicht.appendChild(li);
  }
}

function addBoolean(label, value) {
  let li = document.createElement("li");
  li.textContent = `${label}: ${value ? "Ja" : "Nee"}`;
  overzicht.appendChild(li);
}

