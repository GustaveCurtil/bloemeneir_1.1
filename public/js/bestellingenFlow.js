let bestelFlowLink = document.querySelector('a#bestel-flow');

let bestelUrl = localStorage.getItem('huidigBestelPad');

if (bestelUrl) {
    bestelFlowLink.href = bestelUrl;
}