// -----------------------------
// Helpers
// -----------------------------
const getNumber = key => Number(localStorage.getItem(key)) || 0;
const getBool = key => JSON.parse(localStorage.getItem(key)) ?? false;

function formatEuro(value) {
  return value.toLocaleString("nl-NL", {
    minimumFractionDigits: 2,
    useGrouping: false
  });
}

function addLine(id, html) {
  const li = document.createElement("li");
  li.id = id;
  li.innerHTML = html;
  overzicht.appendChild(li);
}

function addInfo(html) {
  const p = document.createElement("p");
  p.innerHTML = html;
  overzicht.appendChild(p);
}

// -----------------------------
// Product configuration
// -----------------------------
const products = {
  schattig: {
    boeketten: getNumber("boeket_A"),
    kaarten: getNumber("kaart_A"),
    gratisBeurten: amount_A,
    inzetten: getBool("inzetten_A"),
    prijsBoeket: 29,
    prijsKaart: 145
  },
  charmant: {
    boeketten: getNumber("boeket_B"),
    kaarten: getNumber("kaart_B"),
    gratisBeurten: amount_B,
    inzetten: getBool("inzetten_B"),
    prijsBoeket: 39,
    prijsKaart: 190
  },
  magnifiek: {
    boeketten: getNumber("boeket_C"),
    kaarten: getNumber("kaart_C"),
    gratisBeurten: amount_C,
    inzetten: getBool("inzetten_C"),
    prijsBoeket: 49,
    prijsKaart: 239
  }
};

const cadeau = localStorage.getItem("cadeau") || null;

// -----------------------------
// DOM references
// -----------------------------
let overzicht = document.querySelector("ul");
let totalPlaceholder = document.querySelector(".totaal .prijs");
let total = 0;
let newTotal;

// -----------------------------
// Main function for each group
// -----------------------------
function addBoeketKaartGroup(label, cfg) {
  let { boeketten, kaarten, gratisBeurten, inzetten, prijsBoeket, prijsKaart } = cfg;

  const origBoeketten = boeketten;   // keep for UI display

  // ---------------------------------------
  // 1. Apply KORTINGEN from DOM first
  // ---------------------------------------
  boeketten = applyBeurten(label, boeketten);
  let boekettenAfterDOMKorting = boeketten;

  // ---------------------------------------
  // 2. Combine ALL FREE BEURTEN into ONE pool
  // ---------------------------------------
  let totalFree = 0;

  if (inzetten) {
    totalFree += kaarten * 5;     // kaarten = also free beurten
  }

  // ---------------------------------------
  // 3. Apply all remaining free beurten
  // ---------------------------------------
  let boekettenAfterAllFree = Math.max(boekettenAfterDOMKorting - totalFree, 0);

  // This is the final number of PAID boeketten:
  let betaaldeBoeketten = boekettenAfterAllFree;

  // ---------------------------------------
  // 4. Display boeketten row
  // ---------------------------------------
  if (origBoeketten > 0) {
    const originalPrice = formatEuro(origBoeketten * prijsBoeket);

    if (betaaldeBoeketten === 0) {
      addLine(
        "boeketten",
        `${label} boeket x ${origBoeketten} <span>= <s>€${originalPrice}</s> €0,00</span>`
      );
    } else {
      const finalPrice = formatEuro(betaaldeBoeketten * prijsBoeket);
      if (originalPrice === finalPrice) {
        addLine(
            "boeketten",
            `${label} boeket x ${origBoeketten} <span>= €${originalPrice}</span>`
        );
      } else {
        addLine(
            "boeketten",
            `${label} boeket x ${origBoeketten} <span>= <s>€${originalPrice}</s> €${finalPrice}</span>`
        );        
      }
    }
  }

  // ---------------------------------------
  // 5. Add kaarten rows (visual only)
  // ---------------------------------------
  // Show “meteen gebruiken” based on how many FREE boeketten
  // remain AFTER DOM korting (not after totalFree)
  let remainingFreeForCards = Math.min(boekettenAfterDOMKorting, kaarten * 5);

  for (let i = 0; i < kaarten; i++) {
    addLine("kaarten", `${label}e 5-beurtenkaart <span>= €${formatEuro(prijsKaart)}</span>`);

    if (inzetten && remainingFreeForCards > 0) {
      let used = Math.min(5, remainingFreeForCards);
      remainingFreeForCards -= used;

      addInfo(`&nbsp;⤷ meteen gebruiken: ${5 - used} over`);
    }
  }

  // ---------------------------------------
  // 6. Update totals
  // ---------------------------------------
  total += betaaldeBoeketten * prijsBoeket;
  total += kaarten * prijsKaart;


}

// -----------------------------
// Update korting-rows
// -----------------------------
function applyBeurten(label, boeketten) {
  const kortingen = document.querySelectorAll(`[data-name="${label}"]`);

  kortingen.forEach(el => {
    let span = el.querySelector("p:last-of-type>span");
    let kortingBeurten = Number(span.textContent);

    if (!kortingBeurten) return;

    let used = Math.min(kortingBeurten, boeketten);
    boeketten -= used;

    if (used > 0) {
      span.innerHTML = `<s>${kortingBeurten}</s> ${kortingBeurten - used}`;
    }
  });

  return boeketten;
}

function applyKortingen() {
  const kortingen = document.querySelectorAll(`[data-name="cadeau"]`);
  if (kortingen.length > 0) {
    newTotal = total;
    kortingen.forEach(el => {
      let span = el.querySelector("p:last-of-type>span");
      let spanSpan = span.querySelector("span");
      let korting = Number(spanSpan.textContent);

      amountGift += korting;

      let used = Math.min(korting, newTotal);

      if (used > 0) {
        if (total >= used) {
          newTotal -= used;
          amountGift = 0
        } else {
          newTotal = 0
          used = 0;
        }
      }

      if (used > 0) {
        span.innerHTML = `<s>${formatEuro(korting)}</s> ${formatEuro(korting - used)} euro`;
      }
    });
  }
}

// -----------------------------
// Update total price
// -----------------------------
function updateTotal() {
  applyKortingen()

  console.log(newTotal)
  if (newTotal >= 0) {
    totalPlaceholder.innerHTML = `<s>${formatEuro(total)}</s> ${formatEuro(newTotal)} euro`;
  } else {
    totalPlaceholder.innerHTML = `${formatEuro(total)} euro`;
  }
  
}

// -----------------------------
// Run everything
// -----------------------------
for (const [label, cfg] of Object.entries(products)) {
  addBoeketKaartGroup(label, cfg);
}


updateTotal();


function setValue(fieldName, newValue) {
    const el = document.querySelector(`input[name="${fieldName}"]`);
    if (el) el.value = newValue;
}

setValue("boeket_A", getNumber("boeket_A"));
setValue("boeket_B", getNumber("boeket_B"));
setValue("boeket_C", getNumber("boeket_C"));
setValue("kaart_A", getNumber("kaart_A"));
setValue("kaart_B", getNumber("kaart_B"));
setValue("kaart_C", getNumber("kaart_C"));
setValue("inzetten_A", getBool("inzetten_A") ? 1 : 0);
setValue("inzetten_B", getBool("inzetten_B") ? 1 : 0);
setValue("inzetten_C", getBool("inzetten_C") ? 1 : 0);
setValue("cadeau", getNumber("cadeau"));
setValue("day", localStorage.getItem('afhaalmoment'));

