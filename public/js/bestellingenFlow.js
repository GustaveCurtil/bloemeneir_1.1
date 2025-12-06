let bestelFlowLink = document.querySelector('a#bestel-flow');

let bestelUrl = sessionStorage.getItem('huidigBestelPad');

if (bestelUrl) {
    bestelFlowLink.href = bestelUrl;
}