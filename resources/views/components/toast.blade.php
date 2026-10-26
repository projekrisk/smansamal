
<div id="toast-container" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3 max-w-sm w-full pointer-events-none font-sans">
    @if(session('success'))
        <div class="toast-item pointer-events-auto bg-white border border-forest/30 shadow-xl rounded-2xl p-4 flex items-start gap-3 toast-slide-in">
            <div class="w-8 h-8 rounded-xl bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="flex-1">
                <h5 class="text-xs font-bold uppercase tracking-wider text-forest mb-0.5">Berhasil</h5>
                <p class="text-xs text-stone-700 leading-relaxed">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="dismissToast(this.closest('.toast-item'))" class="text-stone-400 hover:text-stone-700 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="toast-item pointer-events-auto bg-white border border-red-200 shadow-xl rounded-2xl p-4 flex items-start gap-3 toast-slide-in">
            <div class="w-8 h-8 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div class="flex-1">
                <h5 class="text-xs font-bold uppercase tracking-wider text-red-600 mb-0.5">Perhatian</h5>
                <p class="text-xs text-stone-700 leading-relaxed">{{ session('error') ?? $errors->first() }}</p>
            </div>
            <button type="button" onclick="dismissToast(this.closest('.toast-item'))" class="text-stone-400 hover:text-stone-700 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('warning') || session('status'))
        <div class="toast-item pointer-events-auto bg-white border border-amber-200 shadow-xl rounded-2xl p-4 flex items-start gap-3 toast-slide-in">
            <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="flex-1">
                <h5 class="text-xs font-bold uppercase tracking-wider text-amber-700 mb-0.5">Informasi</h5>
                <p class="text-xs text-stone-700 leading-relaxed">{{ session('warning') ?? session('status') }}</p>
            </div>
            <button type="button" onclick="dismissToast(this.closest('.toast-item'))" class="text-stone-400 hover:text-stone-700 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif
</div>

<style>
    .toast-slide-in {
        animation: toastSlideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .toast-slide-out {
        animation: toastSlideOut 0.3s ease forwards;
    }
    @keyframes toastSlideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes toastSlideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
</style>

<script>
    function dismissToast(el) {
        if (!el) return;
        el.classList.remove('toast-slide-in');
        el.classList.add('toast-slide-out');
        setTimeout(() => { el.remove(); }, 300);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const toasts = document.querySelectorAll('.toast-item');
        toasts.forEach(t => {
            setTimeout(() => { dismissToast(t); }, 4500);
        });
    });

    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        let icon = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        let borderClass = 'border-forest/30';
        let badgeClass = 'bg-forest/10 text-forest';
        let title = 'Berhasil';
        let textTitleColor = 'text-forest';

        if (type === 'error') {
            icon = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
            borderClass = 'border-red-200';
            badgeClass = 'bg-red-100 text-red-600';
            title = 'Perhatian';
            textTitleColor = 'text-red-600';
        } else if (type === 'warning' || type === 'info') {
            icon = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            borderClass = 'border-amber-200';
            badgeClass = 'bg-amber-100 text-amber-700';
            title = 'Informasi';
            textTitleColor = 'text-amber-700';
        }

        const toast = document.createElement('div');
        toast.className = `toast-item pointer-events-auto bg-white border ${borderClass} shadow-xl rounded-2xl p-4 flex items-start gap-3 toast-slide-in`;
        toast.innerHTML = `
            <div class="w-8 h-8 rounded-xl ${badgeClass} flex items-center justify-center flex-shrink-0 mt-0.5">
                ${icon}
            </div>
            <div class="flex-1">
                <h5 class="text-xs font-bold uppercase tracking-wider ${textTitleColor} mb-0.5">${title}</h5>
                <p class="text-xs text-stone-700 leading-relaxed">${message}</p>
            </div>
            <button type="button" onclick="dismissToast(this.closest('.toast-item'))" class="text-stone-400 hover:text-stone-700 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        `;

        container.appendChild(toast);
        setTimeout(() => { dismissToast(toast); }, 4500);
    };

    window.copyCurrentUrl = function(message = 'Tautan berhasil disalin!') {
        const url = window.location.href;
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url)
                .then(() => {
                    window.showToast(message, 'success');
                })
                .catch(() => {
                    fallbackCopyUrl(url, message);
                });
        } else {
            fallbackCopyUrl(url, message);
        }
    };

    function fallbackCopyUrl(text, message) {
        const input = document.createElement('textarea');
        input.value = text;
        input.style.position = 'fixed';
        input.style.opacity = '0';
        document.body.appendChild(input);
        input.focus();
        input.select();
        try {
            document.execCommand('copy');
            window.showToast(message, 'success');
        } catch (e) {
            window.showToast('Gagal menyalin tautan.', 'error');
        }
        document.body.removeChild(input);
    }
</script>
