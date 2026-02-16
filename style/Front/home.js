function hideFlash(flash) {
    if (!flash) return;
    flash.style.opacity = "0";
    setTimeout(() => flash.remove(), 300);
}

document.addEventListener("click", (e) => {
    const btn = e.target.closest('[data-close="flash"]');
    if (!btn) return;

    e.preventDefault();
    const flash = btn.closest(".flash");
    hideFlash(flash);
});

// spouští autohide pro všechny .flash
function initFlashes(context) {
    const root = context || document;
    root.querySelectorAll(".flash").forEach((flash) => {
        if (flash.dataset.flashBound) return;
        flash.dataset.flashBound = "1";
        setTimeout(() => hideFlash(flash), 4000);
    });
}

document.addEventListener("DOMContentLoaded", initFlashes);

// ==============================
// FLATPICKR (datum) – stejný design + funguje i po AJAXu
// ==============================

// najde všechny relevantní inputy na datum (reservationForm i transferForm)
function getDateInputs(root) {
    const ctx = root || document;

    // Přidej/odeber selektory podle toho, jaké ID reálně máš ve formulářích:
    const selectors = [
        "#frm-reservationForm-date",
        "#frm-transferForm-date"
    ];

    return selectors
        .map((sel) => ctx.querySelector(sel))
        .filter(Boolean);
}

function initFlatpickr(context) {
    if (typeof flatpickr === "undefined") return;

    const inputs = getDateInputs(context);
    if (!inputs.length) return;

    // CZ lokalizace (musí být načtená l10ns.cs)
    if (flatpickr.l10ns && flatpickr.l10ns.cs) {
        flatpickr.localize(flatpickr.l10ns.cs);
    }

    inputs.forEach((input) => {
        // ať se to nenainicializuje víckrát
        if (input.dataset.fpBound) return;
        input.dataset.fpBound = "1";

        flatpickr(input, {
            dateFormat: "Y-m-d",  // do DB
            altInput: true,
            altFormat: "j. F Y",  // pro člověka
            minDate: "today",
            disableMobile: true,

            onReady: function (selectedDates, dateStr, instance) {
                // altInput je to pole, které uživatel opravdu vidí
                // dáme mu stejné CSS třídy, jako mají tvoje inputy
                if (instance.altInput) {
                    instance.altInput.classList.add("transfer-flatpickr-input");
                }
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    initFlatpickr(document);
});

// po AJAXu (nette.ajax) znovu inicializujeme flash + flatpickr
if (window.nette && nette.ajax) {
    nette.ajax.ext("flashInit", {
        success: function () {
            const snippetFlash = document.getElementById("snippet-flash");
            if (snippetFlash) initFlashes(snippetFlash);

            // Flatpickr po ajax renderu modalu/snippetu
            initFlatpickr(document);
        }
    });
}
