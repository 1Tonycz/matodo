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
/*!**********************************!*\
  !*** ./style/Front/excursion.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
document.addEventListener('DOMContentLoaded', function () {
  // -----------------------------
  // FLATPICKR (pouze povolené dny)
  // -----------------------------
  if (typeof flatpickr !== 'undefined') {
    var initTripDatePicker = function initTripDatePicker() {
      var dateInput = document.getElementById('frm-reservationForm-date');
      if (!dateInput) return;

      // allowed dates bereme z data-allowed-dates (spolehlivé i po AJAXu)
      var allowed = [];
      try {
        allowed = JSON.parse(dateInput.dataset.allowedDates || '[]').map(String);
      } catch (e) {
        allowed = [];
      }
      if (dateInput._flatpickr) {
        dateInput._flatpickr.destroy();
      }
      flatpickr(dateInput, {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'j. F Y',
        minDate: 'today',
        disableMobile: true,
        enable: allowed.length ? allowed : [],
        onReady: function onReady(selectedDates, dateStr, instance) {
          if (!allowed.length) {
            instance.input.setAttribute('disabled', 'disabled');
          } else {
            instance.input.removeAttribute('disabled');
          }
        }
      });
    };
    flatpickr.localize(flatpickr.l10ns.cs);
    initTripDatePicker();

    // po AJAXu (nette.ajax) znovu init flatpickr
    if (window.nette && nette.ajax) {
      nette.ajax.ext('tripDatePickerInit', {
        success: function success() {
          initTripDatePicker();
        }
      });
    }
  }
});

// -----------------------------
// FLASHES
// -----------------------------

function hideFlash(flash) {
  if (!flash) return;
  flash.style.opacity = "0";
  setTimeout(function () {
    return flash.remove();
  }, 300);
}
document.addEventListener('click', function (e) {
  var btn = e.target.closest('[data-close="flash"]');
  if (!btn) return;
  e.preventDefault();
  var flash = btn.closest('.flash');
  hideFlash(flash);
});
function initFlashes(context) {
  var root = context || document;
  root.querySelectorAll('.flash').forEach(function (flash) {
    if (flash.dataset.flashBound) return;
    flash.dataset.flashBound = '1';
    setTimeout(function () {
      return hideFlash(flash);
    }, 4000);
  });
}
document.addEventListener('DOMContentLoaded', initFlashes);
if (window.nette && nette.ajax) {
  nette.ajax.ext('flashInit', {
    success: function success() {
      var snippetFlash = document.getElementById('snippet-flash');
      if (snippetFlash) initFlashes(snippetFlash);
    }
  });
}

// -----------------------------
// PRICE BOX (cena z DB podle pickup)
// window.pickupPrices = {"pc":120,"bayahibe":130,"jd":150}
// -----------------------------
(function () {
  function safeNumber(v, fallback) {
    var n = Number(v);
    return Number.isFinite(n) ? n : fallback;
  }
  function formatMoney(n) {
    return Math.round(safeNumber(n, 0)).toString();
  }
  function getCheckedPickupKey(modal) {
    var radios = modal.querySelectorAll('input[name="pickup"]');
    for (var i = 0; i < radios.length; i++) {
      if (radios[i].checked) return radios[i].value;
    }
    return null;
  }
  function initReservationPriceBox() {
    var modal = document.querySelector('.reservation-modal');
    if (!modal) return;
    var summary = modal.querySelector('.reservation-modal__summary');
    if (!summary) return;
    var personsInput = modal.querySelector('#frm-reservationForm-persons');
    var elPP = summary.querySelector('[data-price="pp"]');
    var elPersons = summary.querySelector('[data-price="persons"]');
    var elTotal = summary.querySelector('[data-price="total"]');
    var priceMap = window.pickupPrices || {};
    function recalc() {
      var persons = safeNumber(personsInput ? personsInput.value : 1, 1);
      if (persons < 1) persons = 1;
      var pickupKey = getCheckedPickupKey(modal) || 'pc';
      var pricePP = priceMap[pickupKey] != null ? safeNumber(priceMap[pickupKey], 0) : 0;
      var total = pricePP * persons;
      if (elPP) elPP.textContent = formatMoney(pricePP);
      if (elPersons) elPersons.textContent = String(persons);
      if (elTotal) elTotal.textContent = formatMoney(total);
    }

    // bind - jen jednou
    if (personsInput && !personsInput.dataset.priceBound) {
      personsInput.addEventListener('input', recalc);
      personsInput.dataset.priceBound = '1';
    }
    var radios = modal.querySelectorAll('input[name="pickup"]');
    radios.forEach(function (r) {
      if (r.dataset.priceBound) return;
      r.addEventListener('change', recalc);
      r.dataset.priceBound = '1';
    });
    recalc();
  }
  document.addEventListener('DOMContentLoaded', initReservationPriceBox);
  if (window.nette && nette.ajax) {
    nette.ajax.ext('priceInit', {
      success: function success() {
        initReservationPriceBox();
      }
    });
  }
})();
/******/ })()
;
//# sourceMappingURL=excursion-js.js.map