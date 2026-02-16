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
/*!*****************************!*\
  !*** ./style/Front/home.js ***!
  \*****************************/
__webpack_require__.r(__webpack_exports__);
function hideFlash(flash) {
  if (!flash) return;
  flash.style.opacity = "0";
  setTimeout(function () {
    return flash.remove();
  }, 300);
}
document.addEventListener("click", function (e) {
  var btn = e.target.closest('[data-close="flash"]');
  if (!btn) return;
  e.preventDefault();
  var flash = btn.closest(".flash");
  hideFlash(flash);
});

// spouští autohide pro všechny .flash
function initFlashes(context) {
  var root = context || document;
  root.querySelectorAll(".flash").forEach(function (flash) {
    if (flash.dataset.flashBound) return;
    flash.dataset.flashBound = "1";
    setTimeout(function () {
      return hideFlash(flash);
    }, 4000);
  });
}
document.addEventListener("DOMContentLoaded", initFlashes);

// ==============================
// FLATPICKR (datum) – stejný design + funguje i po AJAXu
// ==============================

// najde všechny relevantní inputy na datum (reservationForm i transferForm)
function getDateInputs(root) {
  var ctx = root || document;

  // Přidej/odeber selektory podle toho, jaké ID reálně máš ve formulářích:
  var selectors = ["#frm-reservationForm-date", "#frm-transferForm-date"];
  return selectors.map(function (sel) {
    return ctx.querySelector(sel);
  }).filter(Boolean);
}
function initFlatpickr(context) {
  if (typeof flatpickr === "undefined") return;
  var inputs = getDateInputs(context);
  if (!inputs.length) return;

  // CZ lokalizace (musí být načtená l10ns.cs)
  if (flatpickr.l10ns && flatpickr.l10ns.cs) {
    flatpickr.localize(flatpickr.l10ns.cs);
  }
  inputs.forEach(function (input) {
    // ať se to nenainicializuje víckrát
    if (input.dataset.fpBound) return;
    input.dataset.fpBound = "1";
    flatpickr(input, {
      dateFormat: "Y-m-d",
      // do DB
      altInput: true,
      altFormat: "j. F Y",
      // pro člověka
      minDate: "today",
      disableMobile: true,
      onReady: function onReady(selectedDates, dateStr, instance) {
        // altInput je to pole, které uživatel opravdu vidí
        // dáme mu stejné CSS třídy, jako mají tvoje inputy
        if (instance.altInput) {
          instance.altInput.classList.add("transfer-flatpickr-input");
        }
      }
    });
  });
}
document.addEventListener("DOMContentLoaded", function () {
  initFlatpickr(document);
});

// po AJAXu (nette.ajax) znovu inicializujeme flash + flatpickr
if (window.nette && nette.ajax) {
  nette.ajax.ext("flashInit", {
    success: function success() {
      var snippetFlash = document.getElementById("snippet-flash");
      if (snippetFlash) initFlashes(snippetFlash);

      // Flatpickr po ajax renderu modalu/snippetu
      initFlatpickr(document);
    }
  });
}
/******/ })()
;
//# sourceMappingURL=home-js.js.map