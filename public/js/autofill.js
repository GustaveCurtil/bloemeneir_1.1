document.addEventListener("DOMContentLoaded", () => {
    // --- BOEKETTEN ---
    const boeketFields = [
        {id: "boeket1", key: "option1"},
        {id: "boeket2", key: "option2"},
        {id: "boeket3", key: "option3"}
    ];

    // Vul eerdere waarden in
    boeketFields.forEach(b => {
        const el = document.getElementById(b.id);
        const saved = localStorage.getItem(b.key);
        if (saved) el.value = saved;

        // Opslaan bij wijziging
        el.addEventListener("input", () => {
            localStorage.setItem(b.key, el.value);
        });
    });

    // Indien er een gekozenBoeket is opgeslagen (bijv. bij klikken op een boeket)
    const gekozenBoeket = localStorage.getItem("gekozenBoeket");
    if (gekozenBoeket) {
        const match = boeketFields.find(b => b.id === gekozenBoeket);
        if (match) {
            match.value = 1;
            localStorage.setItem(match.key, "1"); // direct opslaan
        }
        localStorage.removeItem("gekozenBoeket"); // weg na gebruik
    }

    // --- FORMULIERVELDEN ---
    const fields = [
        {id: "naam", key: "bestellingNaam"},
        {id: "nummer", key: "bestellingTelefoon"},
        {id: "email", key: "bestellingEmail"}
    ];

    fields.forEach(f => {
        const el = document.getElementById(f.id);
        const saved = localStorage.getItem(f.key);
        if (saved) el.value = saved;

        el.addEventListener("input", () => {
            localStorage.setItem(f.key, el.value);
        });
    });
});