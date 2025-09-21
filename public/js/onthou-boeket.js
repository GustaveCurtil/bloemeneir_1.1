        document.querySelectorAll("a[data-boeket]").forEach(link => {
            link.addEventListener("click", (e) => {
                e.preventDefault(); // voorkomt dat de link direct navigeert
                const boeket = link.dataset.boeket;
                localStorage.setItem("gekozenBoeket", boeket);

                // Dan pas navigeren
                window.location.href = link.href;
            });
        });