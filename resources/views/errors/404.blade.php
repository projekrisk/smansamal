<x-layouts.app
    title="Halaman Tidak Ditemukan (404) - SMAN 1 Malingping"
    description="Halaman yang Anda cari tidak ditemukan atau telah dipindahkan. Kembali ke beranda SMAN 1 Malingping untuk menemukan informasi resmi sekolah, berita terkini, dan profil lembaga."
    type="website">

    <main class="flex-grow pt-28 md:pt-36 pb-20 px-4 sm:px-6 relative overflow-hidden bg-stone-50/50">
        {{-- Subtle ambient glow background --}}
        <div class="pointer-events-none absolute -top-24 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-b from-forest/10 via-terracotta/5 to-transparent rounded-full blur-3xl -z-10" aria-hidden="true"></div>
        <div class="pointer-events-none absolute top-1/2 -left-40 w-80 h-80 bg-forest/5 rounded-full blur-2xl -z-10" aria-hidden="true"></div>
        <div class="pointer-events-none absolute top-1/3 -right-40 w-80 h-80 bg-terracotta/5 rounded-full blur-2xl -z-10" aria-hidden="true"></div>

        <div class="w-full max-w-4xl mx-auto">

            {{-- Breadcrumb --}}
            <nav aria-label="Breadcrumb" class="flex items-center justify-center gap-2 mb-6 text-xs font-sans">
                <a href="{{ route('home') }}" class="text-stone-500 hover:text-stone-900 transition-colors">Beranda</a>
                <span class="text-stone-400">/</span>
                <span class="text-terracotta font-semibold">404 Tidak Ditemukan</span>
            </nav>

            {{-- Main 404 Hero Card --}}
            <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-10 md:p-14 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-forest via-terracotta to-forest"></div>

                {{-- Badge Status --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-terracotta/10 text-terracotta text-xs font-bold uppercase tracking-wider mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-terracotta opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-terracotta"></span>
                    </span>
                    Galat 404 &bull; Halaman Tidak Ditemukan
                </div>

                {{-- Visual Display "404" --}}
                <div class="flex items-center justify-center gap-2 sm:gap-4 my-2 select-none" aria-hidden="true">
                    <span class="font-serif text-7xl sm:text-8xl md:text-9xl font-extrabold text-forest tracking-tight">4</span>
                    <div class="relative w-16 h-16 sm:w-24 sm:h-24 md:w-28 md:h-28 rounded-2xl sm:rounded-3xl bg-gradient-to-br from-terracotta/20 to-terracotta/5 border border-terracotta/30 flex items-center justify-center shadow-inner group">
                        <svg class="w-8 h-8 sm:w-12 sm:h-12 md:w-14 md:h-14 text-terracotta animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-terracotta text-white flex items-center justify-center text-[10px] sm:text-xs font-bold shadow-sm">!</span>
                    </div>
                    <span class="font-serif text-7xl sm:text-8xl md:text-9xl font-extrabold text-forest tracking-tight">4</span>
                </div>

                {{-- Headings --}}
                <h1 class="font-serif text-2xl sm:text-3xl md:text-4xl font-bold text-stone-900 mt-4 mb-3 tracking-tight">
                    Oops! Halaman yang Anda Cari Tidak Ditemukan
                </h1>
                <p class="font-sans text-stone-600 text-sm sm:text-base max-w-xl mx-auto leading-relaxed mb-8">
                    Tautan yang Anda tuju mungkin sudah dipindahkan, dihapus, atau salah diketik. Jangan khawatir, Anda dapat mencari informasi yang diinginkan atau kembali ke halaman utama.
                </p>

                {{-- Action Buttons --}}
                <div class="flex flex-wrap items-center justify-center gap-3 font-sans text-sm">
                    <a
                        href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-forest text-white font-medium hover:bg-forest/90 shadow-2xs hover:shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-forest/40"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
