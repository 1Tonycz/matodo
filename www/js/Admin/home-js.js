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
  !*** ./style/Admin/home.js ***!
  \*****************************/
__webpack_require__.r(__webpack_exports__);
document.addEventListener("DOMContentLoaded", function () {
  // Data načtená z dataset atributu v HTML
  var chartElement = document.getElementById("reservationsChart");
  if (!chartElement) return;
  var labels = JSON.parse(chartElement.dataset.labels);
  var values = JSON.parse(chartElement.dataset.values);
  var ctx = chartElement.getContext("2d");
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Počet rezervací',
        data: values,
        backgroundColor: '#03c4c9',
        borderColor: '#02a4a8',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      },
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });
});
/******/ })()
;
//# sourceMappingURL=home-js.js.map