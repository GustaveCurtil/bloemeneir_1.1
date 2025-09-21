document.addEventListener("DOMContentLoaded", () => {
    console.log('test')

    const omhoog = document.getElementById("omhoog");
    const scrollDoos = document.querySelector('body>div')

    // Show/hide based on scroll
   scrollDoos.addEventListener("scroll", () => {

    if (scrollDoos.scrollTop > scrollDoos.clientHeight) {
        // fully past the first viewport
        omhoog.classList.add("show");
        console.log('toon')
    } else {
        console.log('weg')
        omhoog.classList.remove("show");
    }
    });

    // Scroll to top on click
    omhoog.addEventListener("click", () => {
    scrollDoos.scrollTo({
        top: 0,
        behavior: "smooth"
    });
    });

    console.log(omhoog)
});