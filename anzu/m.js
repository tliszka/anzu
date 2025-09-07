// Megvárjuk, amíg a teljes HTML dokumentum betöltődik.
document.addEventListener('DOMContentLoaded', function() {

    // --- Nézetek és Navigációs Linkek Kezelése ---
    const views = document.querySelectorAll('main > div[id^="view-"]');
    const navLinks = document.querySelectorAll('.view-switcher');

    // Funkció egy adott nézet megjelenítésére ID alapján
    function showView(viewId) {
        // Elrejtjük az összes nézetet
        views.forEach(view => {
            view.style.display = 'none';
        });

        // Megjelenítjük a kért nézetet
        const viewToShow = document.getElementById(viewId);
        if (viewToShow) {
            viewToShow.style.display = 'block';
        }
    }

    // Eseménykezelő a navigációs linkekhez
    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Megakadályozzuk az oldal újratöltését
            const targetViewId = this.getAttribute('data-view');
            showView(targetViewId);
        });
    });

    // --- "Vásárlás" Gombok Kezelése ---
    const buyButtons = document.querySelectorAll('.pass-card .button-primary');

    buyButtons.forEach(button => {
        button.addEventListener('click', function() {
            // A gomb feletti H3 elemből kinyerjük a bérlet nevét
            const passCard = this.closest('.pass-card');
            const passName = passCard.querySelector('h3').textContent;
            
            alert(`"${passName}" bérlet vásárlása folyamatban!\n(Ez egy dummy interakció.)`);
        });
    });

    // Alapértelmezett nézet beállítása betöltődéskor
    showView('view-customer');

});