

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', () => {
const optelbaren = document.querySelectorAll('[data-aanbod] button.plus');
const aftrekbaren = document.querySelectorAll('[data-aanbod] button.min');

    optelbaren.forEach(optelbare => {
        optelbare.addEventListener('click', (e) => {
            updateInkopen(e.currentTarget, 'boven') 
        });
    });
    
    aftrekbaren.forEach(aftrekbare => {
        
        aftrekbare.addEventListener('click', (e) => {
            updateInkopen(e.currentTarget, 'beneden') 
        });
    });
});

const steps = [29, 39, 49, 50, 75, 100, 150];
let index = 0;

function updateInkopen(target, richting) {
    let aanbod = target.dataset.aanbod; // e.g., "boeket_A"
    console.log(aanbod)
    console.log(inkoopMap.hasOwnProperty(aanbod));
    if(inkoopMap.hasOwnProperty(aanbod)) {
        // Increment in the map
        if (aanbod === "cadeau") {
            inkoopMap[aanbod] = steps[index];
            index = (index + 1) % steps.length;
        } else {
            if (richting === "boven") {
                inkoopMap[aanbod]++;
            } else {
                if (inkoopMap[aanbod] > 0) {
                   inkoopMap[aanbod]--; 
                }
                
            }
        }
        
        
        // Update the standalone variable
        switch(aanbod) {
            case "boeket_A": boeket_A = inkoopMap[aanbod]; break;
            case "boeket_B": boeket_B = inkoopMap[aanbod]; break;
            case "boeket_C": boeket_C = inkoopMap[aanbod]; break;
            case "kaart_A":   kaart_A   = inkoopMap[aanbod]; break;
            case "kaart_B":   kaart_B   = inkoopMap[aanbod]; break;
            case "kaart_C":   kaart_C   = inkoopMap[aanbod]; break;
            case "cadeau":    cadeau    = inkoopMap[aanbod]; break;
        }

        // Sync with localStorage
        localStorage.setItem(aanbod, inkoopMap[aanbod]);

        updateMandjes();
        // Call your functions
        berekenTotaal();  // get the latest total
        updateWinkelmandje(); 

        console.log(`${aanbod} = ${inkoopMap[aanbod]}`);
    } else {
        console.warn(`Unknown aanbod: ${aanbod}`);
    }
}