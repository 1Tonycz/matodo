document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('adminCalendar');
    if (!root || typeof dayjs === 'undefined') return;

    // events: { "YYYY-MM-DD": [ {id,title,name,detailUrl,type,status,time,route}, ... ], ... }
    let events = {};
    try {
        events = JSON.parse(root.dataset.events || '{}');
    } catch (e) {
        events = {};
    }

    let current = dayjs(root.dataset.month || dayjs().format('YYYY-MM-01'));

    const monthLabel = root.querySelector('[data-calendar-label]');
    const grid = root.querySelector('[data-calendar-grid]');
    const prevBtn = root.querySelector('[data-calendar-prev]');
    const nextBtn = root.querySelector('[data-calendar-next]');
    const detailDate = root.querySelector('[data-calendar-detail-date]');
    const detailList = root.querySelector('[data-calendar-detail-list]');

    function escapeHtml(s) {
        return String(s ?? '').replace(/[&<>"']/g, (m) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        }[m]));
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
        let start = current.startOf('month');
        const startWeekday = start.day();      // 0 = neděle, 1 = pondělí, ...
        const offset = (startWeekday + 6) % 7; // pondělí = 0
        start = start.subtract(offset, 'day');

        grid.innerHTML = '';

        for (let i = 0; i < 42; i++) {
            const date = start.add(i, 'day');
            const dateStr = date.format('YYYY-MM-DD');
            const isCurrentMonth = date.month() === current.month();

            const dayEl = document.createElement('button');
            dayEl.type = 'button';
            dayEl.className = 'admin-calendar__day';
            if (!isCurrentMonth) dayEl.classList.add('is-outmonth');

            const eventsForDay = events[dateStr] || [];
            if (eventsForDay.length > 0) dayEl.classList.add('has-events');

            dayEl.dataset.date = dateStr;
            dayEl.innerHTML = `
        <span class="admin-calendar__day-number">${date.date()}</span>
        ${eventsForDay.length ? `<span class="admin-calendar__day-badge">${eventsForDay.length}</span>` : ''}
      `;

            dayEl.addEventListener('click', () => selectDate(date));
            grid.appendChild(dayEl);
        }

        // defaultně vyber den odpovídající current (typicky 1. v měsíci z data-month)
        selectDate(current, false);
    }

    function selectDate(date, changeMonth = true) {
        current = date.startOf('day');

        // zruš starý výběr
        grid.querySelectorAll('.admin-calendar__day.is-selected')
            .forEach((el) => el.classList.remove('is-selected'));

        const currentStr = current.format('YYYY-MM-DD');
        const selected = Array.from(grid.querySelectorAll('.admin-calendar__day'))
            .find((el) => el.dataset.date === currentStr);

        if (selected) selected.classList.add('is-selected');

        // pravý panel
        detailDate.textContent = current.format('D. MMMM YYYY');

        const eventsForDay = events[currentStr] || [];
        if (!eventsForDay.length) {
            detailList.innerHTML = `<p class="admin-calendar-detail__empty">Žádné výlety na tento den.</p>`;
            return;
        }

        // (volitelně) seřadit: nejdřív confirm, pak pending, pak canceled + podle času
        const sorted = [...eventsForDay].sort((a, b) => {
            const order = (s) => (s === 'confirm' ? 0 : s === 'pending' ? 1 : 2);
            const oa = order(a.status);
            const ob = order(b.status);
            if (oa !== ob) return oa - ob;

            const ta = a.time || '';
            const tb = b.time || '';
            return ta.localeCompare(tb);
        });

        const ul = document.createElement('ul');
        ul.className = 'admin-calendar-detail__list';

        sorted.forEach((ev) => {
            const li = document.createElement('li');
            li.className = 'admin-calendar-detail__item';

            const tLabel = typeLabel(ev.type);
            const tClass = typeClass(ev.type);

            const sLabel = statusLabel(ev.status);
            const sClass = statusClass(ev.status);

            // Extra info pro transfery
            const extra = ev.type === 'transfer'
                ? `
            ${ev.time ? `<div class="admin-calendar-detail__meta">🕒 ${escapeHtml(ev.time)}</div>` : ''}
            ${ev.route ? `<div class="admin-calendar-detail__meta">📍 ${escapeHtml(ev.route)}</div>` : ''}
          `
                : '';

            li.innerHTML = `
        <div class="admin-calendar-detail__item-main">
          <div class="admin-calendar-detail__title">
            <span class="admin-calendar-detail__type ${tClass}">${escapeHtml(tLabel)}</span>
            ${escapeHtml(ev.title)}
            ${ev.status ? `<span class="admin-calendar-detail__status ${sClass}">${escapeHtml(sLabel)}</span>` : ''}
          </div>
          <div class="admin-calendar-detail__name">${escapeHtml(ev.name)}</div>
          ${extra}
        </div>
        <a class="admin-calendar-detail__btn" href="${escapeHtml(ev.detailUrl)}">Detail</a>
      `;

            ul.appendChild(li);
        });

        detailList.innerHTML = '';
        detailList.appendChild(ul);
    }

    prevBtn.addEventListener('click', () => {
        current = current.subtract(1, 'month');
        renderCalendar();
    });

    nextBtn.addEventListener('click', () => {
        current = current.add(1, 'month');
        renderCalendar();
    });

    renderCalendar();
});
