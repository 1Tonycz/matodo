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
  !*** ./style/Admin/calendar.js ***!
  \*********************************/
__webpack_require__.r(__webpack_exports__);
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
document.addEventListener('DOMContentLoaded', function () {
  var root = document.getElementById('adminCalendar');
  if (!root || typeof dayjs === 'undefined') return;

  // events: { "YYYY-MM-DD": [ {id,title,name,detailUrl,type,status,time,route}, ... ], ... }
  var events = {};
  try {
    events = JSON.parse(root.dataset.events || '{}');
  } catch (e) {
    events = {};
  }
  var current = dayjs(root.dataset.month || dayjs().format('YYYY-MM-01'));
  var monthLabel = root.querySelector('[data-calendar-label]');
  var grid = root.querySelector('[data-calendar-grid]');
  var prevBtn = root.querySelector('[data-calendar-prev]');
  var nextBtn = root.querySelector('[data-calendar-next]');
  var detailDate = root.querySelector('[data-calendar-detail-date]');
  var detailList = root.querySelector('[data-calendar-detail-list]');
  function escapeHtml(s) {
    return String(s !== null && s !== void 0 ? s : '').replace(/[&<>"']/g, function (m) {
      return {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      }[m];
    });
  }

  // "pending|confirm|canceled" => "Čeká|Potvrzeno|Zrušeno"
  function statusLabel(status) {
    if (status === 'confirm') return 'Potvrzeno';
    if (status === 'canceled') return 'Zrušeno';
    return 'Čeká';
  }

  // classes for status badge (optional)
  function statusClass(status) {
    if (status === 'confirm') return 'is-confirm';
    if (status === 'canceled') return 'is-canceled';
    return 'is-pending';
  }
  function typeLabel(type) {
    return type === 'transfer' ? 'Transfer' : 'Rezervace';
  }
  function typeClass(type) {
    return type === 'transfer' ? 'is-transfer' : 'is-reservation';
  }
  function renderCalendar() {
    monthLabel.textContent = current.format('MMMM YYYY'); // např. "prosinec 2025"

    // Začátek tabulky – pondělí jako první den
    var start = current.startOf('month');
    var startWeekday = start.day(); // 0 = neděle, 1 = pondělí, ...
    var offset = (startWeekday + 6) % 7; // pondělí = 0
    start = start.subtract(offset, 'day');
    grid.innerHTML = '';
    var _loop = function _loop() {
      var date = start.add(i, 'day');
      var dateStr = date.format('YYYY-MM-DD');
      var isCurrentMonth = date.month() === current.month();
      var dayEl = document.createElement('button');
      dayEl.type = 'button';
      dayEl.className = 'admin-calendar__day';
      if (!isCurrentMonth) dayEl.classList.add('is-outmonth');
      var eventsForDay = events[dateStr] || [];
      if (eventsForDay.length > 0) dayEl.classList.add('has-events');
      dayEl.dataset.date = dateStr;
      dayEl.innerHTML = "\n        <span class=\"admin-calendar__day-number\">".concat(date.date(), "</span>\n        ").concat(eventsForDay.length ? "<span class=\"admin-calendar__day-badge\">".concat(eventsForDay.length, "</span>") : '', "\n      ");
      dayEl.addEventListener('click', function () {
        return selectDate(date);
      });
      grid.appendChild(dayEl);
    };
    for (var i = 0; i < 42; i++) {
      _loop();
    }

    // defaultně vyber den odpovídající current (typicky 1. v měsíci z data-month)
    selectDate(current, false);
  }
  function selectDate(date) {
    var changeMonth = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
    current = date.startOf('day');

    // zruš starý výběr
    grid.querySelectorAll('.admin-calendar__day.is-selected').forEach(function (el) {
      return el.classList.remove('is-selected');
    });
    var currentStr = current.format('YYYY-MM-DD');
    var selected = Array.from(grid.querySelectorAll('.admin-calendar__day')).find(function (el) {
      return el.dataset.date === currentStr;
    });
    if (selected) selected.classList.add('is-selected');

    // pravý panel
    detailDate.textContent = current.format('D. MMMM YYYY');
    var eventsForDay = events[currentStr] || [];
    if (!eventsForDay.length) {
      detailList.innerHTML = "<p class=\"admin-calendar-detail__empty\">\u017D\xE1dn\xE9 v\xFDlety na tento den.</p>";
      return;
    }

    // (volitelně) seřadit: nejdřív confirm, pak pending, pak canceled + podle času
    var sorted = _toConsumableArray(eventsForDay).sort(function (a, b) {
      var order = function order(s) {
        return s === 'confirm' ? 0 : s === 'pending' ? 1 : 2;
      };
      var oa = order(a.status);
      var ob = order(b.status);
      if (oa !== ob) return oa - ob;
      var ta = a.time || '';
      var tb = b.time || '';
      return ta.localeCompare(tb);
    });
    var ul = document.createElement('ul');
    ul.className = 'admin-calendar-detail__list';
    sorted.forEach(function (ev) {
      var li = document.createElement('li');
      li.className = 'admin-calendar-detail__item';
      var tLabel = typeLabel(ev.type);
      var tClass = typeClass(ev.type);
      var sLabel = statusLabel(ev.status);
      var sClass = statusClass(ev.status);

      // Extra info pro transfery
      var extra = ev.type === 'transfer' ? "\n            ".concat(ev.time ? "<div class=\"admin-calendar-detail__meta\">\uD83D\uDD52 ".concat(escapeHtml(ev.time), "</div>") : '', "\n            ").concat(ev.route ? "<div class=\"admin-calendar-detail__meta\">\uD83D\uDCCD ".concat(escapeHtml(ev.route), "</div>") : '', "\n          ") : '';
      li.innerHTML = "\n        <div class=\"admin-calendar-detail__item-main\">\n          <div class=\"admin-calendar-detail__title\">\n            <span class=\"admin-calendar-detail__type ".concat(tClass, "\">").concat(escapeHtml(tLabel), "</span>\n            ").concat(escapeHtml(ev.title), "\n            ").concat(ev.status ? "<span class=\"admin-calendar-detail__status ".concat(sClass, "\">").concat(escapeHtml(sLabel), "</span>") : '', "\n          </div>\n          <div class=\"admin-calendar-detail__name\">").concat(escapeHtml(ev.name), "</div>\n          ").concat(extra, "\n        </div>\n        <a class=\"admin-calendar-detail__btn\" href=\"").concat(escapeHtml(ev.detailUrl), "\">Detail</a>\n      ");
      ul.appendChild(li);
    });
    detailList.innerHTML = '';
    detailList.appendChild(ul);
  }
  prevBtn.addEventListener('click', function () {
    current = current.subtract(1, 'month');
    renderCalendar();
  });
  nextBtn.addEventListener('click', function () {
    current = current.add(1, 'month');
    renderCalendar();
  });
  renderCalendar();
});
/******/ })()
;
//# sourceMappingURL=calendar-js.js.map