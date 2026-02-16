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
/*!******************************!*\
  !*** ./style/Admin/flash.js ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
console.log('FLASH SCRIPT NACTENY');
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

// spouští autohide pro všechny .flash
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

// po AJAXu (nette.ajax) znovu inicializujeme flash
if (window.nette && nette.ajax) {
  nette.ajax.ext('flashInit', {
    success: function success() {
      var snippet = document.getElementById('snippet-flash');
      if (snippet) initFlashes(snippet);
    }
  });
}
/******/ })()
;
//# sourceMappingURL=flash-js.js.map