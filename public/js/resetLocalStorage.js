function resetLocalStorage() {
    [
        'afhaalmoment', 
        'afhaalmoment_geformatteerd',
        'boeket_A', 
        'boeket_B',
        'boeket_C',
        'cadeau',
        'kaart_A',
        'kaart_B',
        'kaart_C',
        'inzetten_A',
        'inzetten_B',
        'inzetten_C',
    ].forEach(key => localStorage.removeItem(key));
}   