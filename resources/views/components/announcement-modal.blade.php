@php
    $popupAnnouncement = \App\Models\Announcement::active()->forPopup()->latest('id')->first();
    $floatingAnnouncement = \App\Models\Announcement::active()->forFloating()->latest('id')->first();

    if ($popupAnnouncement) {
        $popupAnnouncement->increment('views_count');
    }
    if ($floatingAnnouncement && (!$popupAnnouncement || $floatingAnnouncement->id !== $popupAnnouncement->id)) {
        $floatingAnnouncement->increment('views_count');
    }
@endphp

@if($popupAnnouncement)
<div
    x-data="{
        open: false,
        dontShowAgain: false,
        announcementId: {{ $popupAnnouncement->id }},
        init() {
            const dismissedKey = 'dismissed_announcement_' + this.announcementId;
            const isDismissed = localStorage.getItem(dismissedKey);

            if (!isDismissed) {
                setTimeout(() => {
                    this.open = true;
                }, 600);
            }
        },
        closeModal() {
            this.open = false;
            if (this.dontShowAgain) {
                const dismissedKey = 'dismissed_announcement_' + this.announcementId;
                localStorage.setItem(dismissedKey, 'true');
            }
        }
    }"
    x-show="open"
    x-cloak
    @keydown.escape.window="closeModal()"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 overflow-y-auto font-sans"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    aria-labelledby="popup-announcement-title"
>
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closeModal()"
        class="fixed inset-0 bg-stone-950/80 backdrop-blur-md transition-opacity"
    ></div>

    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-3"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-3"
        class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-stone-200/90 z-10 font-sans my-auto flex flex-col ring-1 ring-black/5 overflow-hidden"
    >
        <button
            type="button"
            @click="closeModal()"
            class="absolute top-4 right-4 z-30 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/95 hover:bg-white text-stone-700 hover:text-stone-950 border border-stone-200 shadow-lg flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-forest/40 cursor-pointer group"
            title="Tutup Pengumuman"
            aria-label="Tutup Pengumuman"
        >
            <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 transition-transform duration-200 group-hover:rotate-90 text-stone-700 group-hover:text-stone-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        @if($popupAnnouncement->image_url)
            <div class="relative w-full aspect-video sm:aspect-[16/9] bg-stone-100 rounded-t-3xl overflow-hidden border-b border-stone-100 flex-shrink-0">
                <img
                    src="{{ $popupAnnouncement->image_url }}"
                    alt="{{ $popupAnnouncement->title }}"
                    class="w-full h-full object-cover"
                    loading="eager"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
            </div>
        @endif

        <div class="p-6 sm:p-7 flex flex-col {{ !$popupAnnouncement->image_url ? 'pt-8' : '' }}">
            <div class="flex items-center gap-2 mb-2.5">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-terracotta/10 text-terracotta border border-terracotta/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-terracotta animate-pulse"></span>
                    Pengumuman Resmi
                </span>
            </div>

            <h3 id="popup-announcement-title" class="font-serif text-xl sm:text-2xl font-bold text-stone-900 leading-snug mb-3 pr-10">
                {{ $popupAnnouncement->title }}
            </h3>

            @if($popupAnnouncement->content)
                <div class="text-xs sm:text-sm text-stone-600 leading-relaxed space-y-2 mb-6 max-h-52 overflow-y-auto pr-1">
                    {!! nl2br(e($popupAnnouncement->content)) !!}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-4 border-t border-stone-100 mt-auto">
                <label class="inline-flex items-center gap-2 text-xs text-stone-500 cursor-pointer select-none">
                    <input type="checkbox" x-model="dontShowAgain" class="w-3.5 h-3.5 text-forest rounded border-stone-300 focus:ring-forest cursor-pointer">
                    <span>Jangan tampilkan lagi</span>
                </label>

                <div class="flex items-center gap-2 justify-end">
                    <button
                        type="button"
                        @click="closeModal()"
                        class="px-4 py-2 rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 text-xs sm:text-sm font-semibold transition-colors cursor-pointer"
                    >
                        Tutup
                    </button>
                    @if($popupAnnouncement->button_url && $popupAnnouncement->button_text)
                        <a
                            href="{{ $popupAnnouncement->button_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-1.5 bg-forest hover:bg-stone-900 text-white px-5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-colors shadow-2xs"
                        >
                            <span>{{ $popupAnnouncement->button_text }}</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($floatingAnnouncement)
<div
    x-data="{
        floatingOpen: false,
        openFloatingModal() {
            this.floatingOpen = true;
        },
        closeFloatingModal() {
            this.floatingOpen = false;
        }
    }"
    class="font-sans"
>
    <aside
        aria-label="Pengumuman Mengambang"
        class="fixed bottom-4 left-4 sm:bottom-6 sm:left-6 z-40"
    >
        <button
            type="button"
            @click="openFloatingModal()"
            class="group relative inline-flex items-center gap-2 sm:gap-2.5 px-3.5 py-2.5 sm:px-4 sm:py-3 rounded-full bg-white/95 hover:bg-white text-stone-800 hover:text-forest border border-stone-200/90 shadow-[0_8px_30px_rgb(0,0,0,0.12)] backdrop-blur-md transition-all duration-300 hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-2 cursor-pointer"
            title="{{ $floatingAnnouncement->title }}"
            aria-haspopup="dialog"
            :aria-expanded="floatingOpen.toString()"
        >
            <span class="relative flex h-2.5 w-2.5 flex-shrink-0">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-terracotta opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-400"></span>
            </span>

            <div class="w-7 h-7 rounded-full bg-forest/10 text-forest group-hover:bg-forest group-hover:text-white flex items-center justify-center flex-shrink-0 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>

            <span class="font-sans text-xs font-bold text-stone-800 group-hover:text-forest transition-colors max-w-[110px] sm:max-w-[200px] truncate leading-tight">
                {{ $floatingAnnouncement->title }}
            </span>
        </button>
    </aside>

    <div
        x-show="floatingOpen"
        x-cloak
        @keydown.escape.window="closeFloatingModal()"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
        style="display: none;"
        role="dialog"
        aria-modal="true"
        aria-labelledby="floating-announcement-title"
    >
        <div
            x-show="floatingOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeFloatingModal()"
            class="fixed inset-0 bg-stone-950/80 backdrop-blur-md transition-opacity"
        ></div>

        <div
            x-show="floatingOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-3"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-3"
            class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-stone-200/90 z-10 font-sans my-auto flex flex-col ring-1 ring-black/5 overflow-hidden"
        >
            <button
                type="button"
                @click="closeFloatingModal()"
                class="absolute top-4 right-4 z-30 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/95 hover:bg-white text-stone-700 hover:text-stone-950 border border-stone-200 shadow-lg flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-forest/40 cursor-pointer group"
                title="Tutup Pengumuman"
                aria-label="Tutup Pengumuman"
            >
                <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 transition-transform duration-200 group-hover:rotate-90 text-stone-700 group-hover:text-stone-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            @if($floatingAnnouncement->image_url)
                <div class="relative w-full aspect-video sm:aspect-[16/9] bg-stone-100 rounded-t-3xl overflow-hidden border-b border-stone-100 flex-shrink-0">
                    <img
                        src="{{ $floatingAnnouncement->image_url }}"
                        alt="{{ $floatingAnnouncement->title }}"
                        class="w-full h-full object-cover"
                        loading="eager"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
                </div>
            @endif

            <div class="p-6 sm:p-7 flex flex-col {{ !$floatingAnnouncement->image_url ? 'pt-8' : '' }}">
                <div class="flex items-center gap-2 mb-2.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-forest/10 text-forest border border-forest/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-forest animate-pulse"></span>
                        Informasi & Survei
                    </span>
                </div>

                <h3 id="floating-announcement-title" class="font-serif text-xl sm:text-2xl font-bold text-stone-900 leading-snug mb-3 pr-10">
                    {{ $floatingAnnouncement->title }}
                </h3>

                @if($floatingAnnouncement->content)
                    <div class="text-xs sm:text-sm text-stone-600 leading-relaxed space-y-2 mb-6 max-h-52 overflow-y-auto pr-1">
                        {!! nl2br(e($floatingAnnouncement->content)) !!}
                    </div>
                @endif

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-stone-100 mt-auto">
                    <button
                        type="button"
                        @click="closeFloatingModal()"
                        class="px-4 py-2 rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 text-xs sm:text-sm font-semibold transition-colors cursor-pointer"
                    >
                        Tutup
                    </button>
                    @if($floatingAnnouncement->button_url && $floatingAnnouncement->button_text)
                        <a
                            href="{{ $floatingAnnouncement->button_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-1.5 bg-forest hover:bg-stone-900 text-white px-5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-colors shadow-2xs"
                        >
                            <span>{{ $floatingAnnouncement->button_text }}</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif
