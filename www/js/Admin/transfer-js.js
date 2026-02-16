/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./style/Admin/transfer.js ***!
  \*********************************/
__webpack_require__.r(__webpack_exports__);
(function () {
  function lockScroll() {
    var open = document.querySelector('[data-modal="transfer-detail"]');
    document.body.classList.toggle('modal-open', !!open);
  }

  // zavřít klikem na overlay
  document.addEventListener('click', function (e) {
    var backdrop = e.target.closest('[data-modal="transfer-detail"]');
    var closeBtn = e.target.closest('[data-modal-close]');

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
      var link = backdrop.querySelector('[data-modal-close]');
      if (link) link.click();
    }
  });

  // zavřít ESC
  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    var backdrop = document.querySelector('[data-modal="transfer-detail"]');
    if (!backdrop) return;
    var link = backdrop.querySelector('[data-modal-close]');
    if (link) link.click();
  });
  document.addEventListener('DOMContentLoaded', lockScroll);

  // pokud používáš nette.ajax/snippety, znovu zkontroluj po requestu
  if (window.nette && nette.ajax) {
    nette.ajax.ext('modalScrollLock', {
      success: function success() {
        lockScroll();
      }
    });
  }
})();
/******/ })()
;
//# sourceMappingURL=transfer-js.js.map