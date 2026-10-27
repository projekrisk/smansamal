

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

    // Auto-hide kontainer AdSense jika status iklan unfilled (kosong)
    const handleUnfilledAds = () => {
        document.querySelectorAll('.ad-container ins.adsbygoogle').forEach((ins) => {
            const checkStatus = () => {
                if (ins.getAttribute('data-ad-status') === 'unfilled') {
                    const container = ins.closest('.ad-container');
                    if (container) container.style.display = 'none';
                }
            };
            checkStatus();
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'data-ad-status') {
                        checkStatus();
                    }
                });
            });
            observer.observe(ins, { attributes: true, attributeFilter: ['data-ad-status'] });
        });
    };
    handleUnfilledAds();
});

