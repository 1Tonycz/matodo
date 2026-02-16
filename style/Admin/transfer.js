(function () {
    function lockScroll() {
        const open = document.querySelector('[data-modal="transfer-detail"]');
        document.body.classList.toggle('modal-open', !!open);
    }

    // zavřít klikem na overlay
    document.addEventListener('click', (e) => {
        const backdrop = e.target.closest('[data-modal="transfer-detail"]');
        const closeBtn = e.target.closest('[data-modal-close]');

        // klik na close button
        if (closeBtn) {
            // zavření udělá odkaz n:href="this" (server), tady jen lock
            setTimeout(lockScroll, 0);
            return;
        }

        // klik přímo na backdrop (ne na modal)
        if (backdrop && e.target === backdrop) {
            // pokud chceš zavření čistě JS bez requestu:
            // -> musíš mít vlastní endpoint nebo JS toggle
            // nejjednodušší: simuluj klik na close link uvnitř
            const link = backdrop.querySelector('[data-modal-close]');
            if (link) link.click();
        }
    });

    // zavřít ESC
    document.addEventListener('keydown', (e) => {
        if (e.key !== 'Escape') return;
        const backdrop = document.querySelector('[data-modal="transfer-detail"]');
        if (!backdrop) return;
        const link = backdrop.querySelector('[data-modal-close]');
        if (link) link.click();
    });

    document.addEventListener('DOMContentLoaded', lockScroll);

    // pokud používáš nette.ajax/snippety, znovu zkontroluj po requestu
    if (window.nette && nette.ajax) {
        nette.ajax.ext('modalScrollLock', {
            success: function () {
                lockScroll();
            }
        });
    }
})();
