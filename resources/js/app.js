

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.prose table').forEach((table) => {
        if (!table.parentElement.classList.contains('prose-table-wrap')) {
            const wrap = document.createElement('div');
            wrap.className = 'prose-table-wrap';
            table.parentNode.insertBefore(wrap, table);
            wrap.appendChild(table);
        }
    });
});

