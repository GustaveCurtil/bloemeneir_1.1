let afhaalopties = document.querySelectorAll('[data-datum]');
let afhaalmoment = localStorage.getItem("afhaalmoment")

setActiveDate()

function setActiveDate() {
    afhaalmoment = localStorage.getItem("afhaalmoment")
    afhaalopties.forEach(optie => {
        optie.classList.remove('active')
        if (optie.dataset.datum === afhaalmoment ) {
            optie.classList.add('active')
        }
    });
}


afhaalopties.forEach(optie => {
    optie.addEventListener('click', (e) => {
        afhaalmoment = optie.dataset.datum
        localStorage.setItem("afhaalmoment", afhaalmoment)
        setActiveDate()
        // window.location.href = "/winkel/winkelmandje"
    })
});