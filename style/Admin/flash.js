console.log('FLASH SCRIPT NACTENY');
function hideFlash(flash) {
    if (!flash) return;
    flash.style.opacity = "0";
    setTimeout(() => flash.remove(), 300);
}

document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-close="flash"]');
    if (!btn) return;

    e.preventDefault();
    const flash = btn.closest('.flash');
    hideFlash(flash);
});

// spouští autohide pro všechny .flash
function initFlashes(context) {
    const root = context || document;
    root.querySelectorAll('.flash').forEach(flash => {
        if (flash.dataset.flashBound) return;
        flash.dataset.flashBound = '1';
        setTimeout(() => hideFlash(flash), 4000);
    });
}

document.addEventListener('DOMContentLoaded', initFlashes);

// po AJAXu (nette.ajax) znovu inicializujeme flash
if (window.nette && nette.ajax) {
    nette.ajax.ext('flashInit', {
        success: function () {
            const snippet = document.getElementById('snippet-flash');
            if (snippet) initFlashes(snippet);
        }
    });
}