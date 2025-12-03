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

// -----------------------------
// DOM references
// -----------------------------
let overzicht = document.querySelector("ul");
let totalPlaceholder = document.querySelector(".totaal .prijs");
let total = 0;

// -----------------------------
// Main function for each group
// -----------------------------
function addBoeketKaartGroup(label, cfg) {
  let { boeketten, kaarten, gratisBeurten, inzetten, prijsBoeket, prijsKaart } = cfg;

  const origBoeketten = boeketten;   // keep for UI display

  // ---------------------------------------
  // 1. Apply KORTINGEN from DOM first
  // ---------------------------------------
  boeketten = applyKorting(label, boeketten);
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
function applyKorting(label, boeketten) {
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

// -----------------------------
// Update total price
// -----------------------------
function updateTotal() {
  totalPlaceholder.textContent = `${formatEuro(total)} euro`;
}

// -----------------------------
// Run everything
// -----------------------------
for (const [label, cfg] of Object.entries(products)) {
  addBoeketKaartGroup(label, cfg);
}

updateTotal();
