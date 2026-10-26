@props([
    'threshold' => 350,
    'id' => 'btn-back-to-top',
    'ringId' => 'scroll-progress-ring'
])

<div class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-50">
    <button
        id="{{ $id }}"
        type="button"
        class="relative w-11 h-11 md:w-12 md:h-12 bg-white/95 backdrop-blur-md rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.15)] border border-stone-200/80 flex items-center justify-center text-stone-700 hover:text-forest transition-all duration-500 focus:outline-none opacity-0 translate-y-8 pointer-events-none group cursor-pointer"
        title="Kembali ke Atas"
        aria-label="Kembali ke Atas">
        <svg class="w-5 h-5 relative z-10 transition-transform group-hover:-translate-y-1 text-stone-700 group-hover:text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
        <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none" viewBox="0 0 36 36">
            <path class="text-stone-100" stroke-width="2.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
            <path id="{{ $ringId }}" class="text-forest transition-all duration-150" stroke-dasharray="0, 100" stroke-width="2.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
        </svg>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('{{ $id }}');
        const ring = document.getElementById('{{ $ringId }}');
        const threshold = {{ $threshold }};

        if (!btn) return;

        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = docHeight > 0 ? Math.min(scrollTop / docHeight, 1) : 0;

            if (ring) {
                ring.style.strokeDasharray = `${scrollPercent * 100}, 100`;
            }

            if (scrollTop > threshold) {
                btn.classList.remove('opacity-0', 'translate-y-8', 'pointer-events-none');
            } else {
                btn.classList.add('opacity-0', 'translate-y-8', 'pointer-events-none');
            }
        });

        btn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>
