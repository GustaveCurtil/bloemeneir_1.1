let bestelFlowLink = document.querySelector('a#bestel-flow');

let bestelUrl = localStorage.getItem('huidigBestelPad');

document.addEventListener('DOMContentLoaded', () => {

    if (bestelUrl) {
        bestelFlowLink.href = bestelUrl;
    }
})
