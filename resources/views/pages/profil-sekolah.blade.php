@push('styles')
<style>
    .tab-prose p,
    .tab-prose li {
        font-size: 0.9375rem;
        line-height: 1.65;
    }
    @media (min-width: 640px) {
        .tab-prose p,
        .tab-prose li {
            font-size: 1rem;
            line-height: 1.75;
        }
    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endpush

<x-layouts.app
    title="Profil Sekolah - SMAN 1 Malingping"
    description="Profil lengkap SMAN 1 Malingping: sejarah pendirian, data pokok NPSN 20601836, daftar pimpinan sekolah dari masa ke masa, visi-misi, 4 pilar karakter, ekstrakurikuler, dan fasilitas."
    type="article">

    <main
        class="flex-grow pt-0 w-full pb-20"
        x-data="{
            activeTab: 'tentang'
        }"
        x-init="
            const validTabs = ['tentang', 'sejarah', 'pimpinan', 'visi-misi', 'pilar', 'ekskul', 'fasilitas', 'kontak'];
            if (window.location.hash) {
                const h = window.location.hash.substring(1);
                if (validTabs.includes(h)) {
                    activeTab = h;
                }
            }
            window.addEventListener('hashchange', () => {
                const h = window.location.hash.substring(1);
                if (validTabs.includes(h)) {
                    activeTab = h;
                }
            });
        "
    >

        <div class="w-full h-60 sm:h-72 md:h-80 relative bg-stone-900 overflow-hidden">
            <img
                src="{{ asset('images/bg.jpg') }}"
                alt="Gedung Kampus SMAN 1 Malingping"
                class="w-full h-full object-cover mix-blend-overlay opacity-60"
                loading="eager"
            >
            <div class="absolute inset-0 bg-stone-900/40"></div>

            <div class="max-w-[1000px] mx-auto px-4 sm:px-6 pt-24 sm:pt-28 md:pt-32 flex items-center gap-2 text-stone-200 text-xs sm:text-sm font-sans relative z-10">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <span class="text-stone-400">/</span>
                <span class="text-white font-semibold">Profil Sekolah</span>
            </div>
        </div>

        <div class="w-full max-w-[1000px] mx-auto px-3 sm:px-6 relative -mt-16 sm:-mt-20 md:-mt-24 mb-6">
            <div class="bg-white p-4 sm:p-7 md:p-8 rounded-2xl md:rounded-[2rem] shadow-sm border border-stone-200 flex flex-col md:flex-row items-center md:items-end gap-4 sm:gap-6 md:gap-8">

                <div class="w-20 h-20 sm:w-28 sm:h-28 md:w-32 md:h-32 rounded-2xl border-4 border-white overflow-hidden flex-shrink-0 bg-stone-50 shadow-md relative z-10 -mt-12 sm:-mt-16 flex items-center justify-center p-2.5">
                    <img
                        src="{{ asset('icon.png') }}"
                        alt="Logo SMAN 1 Malingping"
                        class="w-full h-full object-contain"
                    >
                </div>

                <div class="flex-grow text-center md:text-left">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-1.5 sm:gap-2 mb-1.5">
                        <span class="inline-flex items-center gap-1 bg-forest text-white font-sans text-[11px] sm:text-xs font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            Akreditasi A
                        </span>
                        <span class="inline-flex items-center text-[11px] sm:text-xs font-semibold text-stone-700 bg-stone-100 border border-stone-200 px-2.5 py-0.5 rounded-full">
                            NPSN: 20601836
                        </span>
                        <span class="inline-flex items-center text-[11px] sm:text-xs font-semibold text-terracotta bg-terracotta/10 border border-terracotta/20 px-2.5 py-0.5 rounded-full">
                            Kurikulum Merdeka
                        </span>
                    </div>

                    <h1 class="font-serif text-2xl sm:text-3xl md:text-4xl text-stone-900 leading-tight mb-1">
                        SMAN 1 Malingping
                    </h1>

                    <p class="font-sans text-stone-600 text-xs sm:text-sm md:text-base leading-relaxed max-w-2xl">
                        Mewujudkan peserta didik yang cerdas, berkarakter baik, dan peduli terhadap lingkungan.
                    </p>
                </div>

                <div class="flex-shrink-0 flex items-center gap-2 mt-1 md:mt-0">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-full border border-stone-200 text-stone-700 font-sans text-xs sm:text-sm font-semibold hover:border-forest hover:text-forest transition-colors bg-white shadow-2xs">
                        Kembali
                    </a>
                    <a href="{{ route('login') }}" class="px-5 py-2 rounded-full bg-forest text-white font-sans text-xs sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs">
                        Portal Warga
                    </a>
                </div>
            </div>

            <div class="mt-6 border-b border-stone-200 relative"
                x-data="{
                    canScrollLeft: false,
                    canScrollRight: true,
                    checkScroll() {
                        const el = this.$refs.tabNav;
                        if (!el) return;
                        this.canScrollLeft = el.scrollLeft > 5;
                        this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 5);
                    },
                    scrollTabs(amount) {
                        this.$refs.tabNav.scrollBy({ left: amount, behavior: 'smooth' });
                    }
                }"
                x-init="
                    $nextTick(() => { checkScroll(); });
                    setTimeout(() => { checkScroll(); }, 150);
                    window.addEventListener('resize', () => { checkScroll(); });
                "
            >
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <button
                        type="button"
                        @click="scrollTabs(-220)"
                        :disabled="!canScrollLeft"
                        :class="canScrollLeft ? 'opacity-100 text-stone-700 hover:text-white hover:bg-forest hover:border-forest shadow-xs cursor-pointer' : 'opacity-30 text-stone-400 border-stone-200 cursor-not-allowed pointer-events-none'"
                        class="flex-shrink-0 w-8 h-8 rounded-full bg-white border border-stone-200 flex items-center justify-center transition-all focus:outline-none mb-1.5"
                        title="Geser tab ke kiri"
                        aria-label="Geser tab ke kiri"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>

                    <nav
                        x-ref="tabNav"
                        @scroll.passive="checkScroll()"
                        @wheel="if (!$event.shiftKey) { $event.preventDefault(); $el.scrollLeft += $event.deltaY; checkScroll(); }"
                        class="flex-1 min-w-0 flex space-x-1 sm:space-x-3 md:space-x-5 overflow-x-auto no-scrollbar font-sans text-sm sm:text-sm md:text-base scroll-smooth select-none -mb-px"
                    >

                    <button
                        type="button"
                        @click="activeTab = 'tentang'; window.location.hash = 'tentang'"
                        :class="activeTab === 'tentang' ? 'border-forest text-forest font-bold border-b-2 pb-3' : 'border-transparent text-stone-500 hover:text-stone-800 border-b-2 pb-3 font-medium'"
                        class="whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer pt-1.5 px-1.5 sm:px-2 flex-shrink-0"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Tentang</span>
                    </button>

                    <button
                        type="button"
                        @click="activeTab = 'sejarah'; window.location.hash = 'sejarah'"
                        :class="activeTab === 'sejarah' ? 'border-forest text-forest font-bold border-b-2 pb-3' : 'border-transparent text-stone-500 hover:text-stone-800 border-b-2 pb-3 font-medium'"
                        class="whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer pt-1.5 px-1.5 sm:px-2 flex-shrink-0"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Sejarah</span>
                    </button>

                    <button
                        type="button"
                        @click="activeTab = 'pimpinan'; window.location.hash = 'pimpinan'"
                        :class="activeTab === 'pimpinan' ? 'border-forest text-forest font-bold border-b-2 pb-3' : 'border-transparent text-stone-500 hover:text-stone-800 border-b-2 pb-3 font-medium'"
                        class="whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer pt-1.5 px-1.5 sm:px-2 flex-shrink-0"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Pimpinan</span>
                    </button>

                    <button
                        type="button"
                        @click="activeTab = 'visi-misi'; window.location.hash = 'visi-misi'"
                        :class="activeTab === 'visi-misi' ? 'border-forest text-forest font-bold border-b-2 pb-3' : 'border-transparent text-stone-500 hover:text-stone-800 border-b-2 pb-3 font-medium'"
                        class="whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer pt-1.5 px-1.5 sm:px-2 flex-shrink-0"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Visi & Misi</span>
                    </button>

                    <button
                        type="button"
                        @click="activeTab = 'pilar'; window.location.hash = 'pilar'"
                        :class="activeTab === 'pilar' ? 'border-forest text-forest font-bold border-b-2 pb-3' : 'border-transparent text-stone-500 hover:text-stone-800 border-b-2 pb-3 font-medium'"
                        class="whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer pt-1.5 px-1.5 sm:px-2 flex-shrink-0"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>4 Pilar</span>
                    </button>

                    <button
                        type="button"
                        @click="activeTab = 'ekskul'; window.location.hash = 'ekskul'"
                        :class="activeTab === 'ekskul' ? 'border-forest text-forest font-bold border-b-2 pb-3' : 'border-transparent text-stone-500 hover:text-stone-800 border-b-2 pb-3 font-medium'"
                        class="whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer pt-1.5 px-1.5 sm:px-2 flex-shrink-0"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>Ekstrakurikuler</span>
                    </button>

                    <button
                        type="button"
                        @click="activeTab = 'fasilitas'; window.location.hash = 'fasilitas'"
                        :class="activeTab === 'fasilitas' ? 'border-forest text-forest font-bold border-b-2 pb-3' : 'border-transparent text-stone-500 hover:text-stone-800 border-b-2 pb-3 font-medium'"
                        class="whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer pt-1.5 px-1.5 sm:px-2 flex-shrink-0"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Fasilitas</span>
                    </button>

                    <button
                        type="button"
                        @click="activeTab = 'kontak'; window.location.hash = 'kontak'"
                        :class="activeTab === 'kontak' ? 'border-forest text-forest font-bold border-b-2 pb-3' : 'border-transparent text-stone-500 hover:text-stone-800 border-b-2 pb-3 font-medium'"
                        class="whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer pt-1.5 px-1.5 sm:px-2 flex-shrink-0"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Kontak</span>
                    </button>
                </nav>

                    <button
                        type="button"
                        @click="scrollTabs(220)"
                        :disabled="!canScrollRight"
                        :class="canScrollRight ? 'opacity-100 text-stone-700 hover:text-white hover:bg-forest hover:border-forest shadow-xs cursor-pointer' : 'opacity-30 text-stone-400 border-stone-200 cursor-not-allowed pointer-events-none'"
                        class="flex-shrink-0 w-8 h-8 rounded-full bg-white border border-stone-200 flex items-center justify-center transition-all focus:outline-none mb-1.5"
                        title="Geser tab ke kanan"
                        aria-label="Geser tab ke kanan"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="w-full max-w-[1000px] mx-auto px-3 sm:px-6 tab-prose">

            <div x-show="activeTab === 'tentang'" class="space-y-6">

                <div class="p-5 sm:p-7 rounded-2xl bg-stone-100/90 border border-stone-200">
                    <span class="font-sans text-[11px] sm:text-xs font-bold text-terracotta uppercase tracking-widest block mb-1.5">Sambutan Pimpinan Sekolah</span>
                    <h2 class="font-serif text-xl sm:text-2xl text-stone-900 mb-2.5 font-bold">
                        Mewujudkan Insan Berkarakter Unggul & Berkelanjutan
                    </h2>
                    <p class="text-stone-700 mb-2.5">
                        SMA Negeri 1 Malingping bertekad menyelenggarakan layanan pendidikan yang inklusif, berkualitas tinggi, dan ramah anak. Kami menanamkan nilai-nilai Profil Pelajar Pancasila yang dipadukan dengan kearifan lokal Banten Selatan agar para peserta didik mampu bersaing di tingkat nasional maupun global dengan integritas moral yang kokoh.
                    </p>
                    <p class="text-xs sm:text-sm font-bold text-stone-900">— Kepala SMA Negeri 1 Malingping</p>
                </div>

                <div>
                    <h3 class="font-serif text-xl sm:text-2xl text-stone-900 mb-3 font-bold">Data Pokok</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <span class="font-sans text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-0.5">Nama Satuan Pendidikan</span>
                            <span class="font-sans text-sm sm:text-base font-bold text-stone-900">SMA Negeri 1 Malingping</span>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <span class="font-sans text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-0.5">Nomor Pokok Sekolah Nasional (NPSN)</span>
                            <span class="font-sans text-sm sm:text-base font-bold text-forest">20601836</span>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <span class="font-sans text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-0.5">Bentuk Pendidikan & Status</span>
                            <span class="font-sans text-sm sm:text-base font-semibold text-stone-800">Sekolah Menengah Atas (SMA) / Negeri</span>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <span class="font-sans text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-0.5">Status Akreditasi</span>
                            <span class="font-sans text-sm sm:text-base font-bold text-forest flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-forest"></span>
                                Akreditasi A (Unggul)
                            </span>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <span class="font-sans text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-0.5">Kurikulum Pembelajaran</span>
                            <span class="font-sans text-sm sm:text-base font-semibold text-stone-800">Kurikulum Merdeka</span>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <span class="font-sans text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-0.5">Naungan & Pengelola</span>
                            <span class="font-sans text-sm sm:text-base font-semibold text-stone-800">Dinas Pendidikan Provinsi Banten</span>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs sm:col-span-2">
                            <span class="font-sans text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-0.5">Alamat Kampus</span>
                            <span class="font-sans text-sm sm:text-base font-semibold text-stone-800">Jln. Raya Bayah KM. 4 No. 39, Desa Pagelaran Kecamatan Malingping, Kabupaten Lebak, Banten 42391.</span>
                        </div>
                    </div>
                </div>

            </div>

            <div x-show="activeTab === 'sejarah'" style="display: none;" class="space-y-6">

                <div class="p-5 sm:p-7 rounded-2xl bg-white border border-stone-200 shadow-2xs">
                    <div class="flex items-center gap-2.5 mb-3">
                        <span class="w-2 h-5 bg-forest rounded-full"></span>
                        <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-bold">Sejarah SMAN 1 Malingping</h2>
                    </div>

                    <div class="space-y-4 text-stone-700 leading-relaxed">
                        <div>
                            <p>
                                Pada awal 1980-an, pendidikan menengah atas di Kabupaten Lebak sangat terbatas. Satu-satunya SMA saat itu adalah SMAN 1 Rangkasbitung. Akibatnya, banyak lulusan SMP/MTs di wilayah Malingping dan Banten Selatan terhambat untuk melanjutkan pendidikan karena kendala ekonomi dan jarak tempuh yang jauh.
                            </p>

                            <br>

                            <p>
                                Tingginya semangat masyarakat terhadap pendidikan mendorong tokoh-tokoh pendidikan di Malingping untuk membuka sekolah filial yang menumpang di SMPN 1 Malingping. Inisiatif lokal ini menjadi cikal bakal berdirinya SMA Negeri 1 Malingping.
                            </p>

                            <br>

                            <p>
                                Melihat besarnya kebutuhan dan antusiasme masyarakat, pemerintah pun mengambil langkah nyata. Pada tahun 1982, dibangun Unit Gedung Baru (UGB) dengan lima ruang kelas khusus untuk SMA. Sejak tahun ajaran 1984/1985, seluruh kegiatan belajar mengajar dipusatkan di gedung permanen di Jalan Raya Bayah Km 4, Malingping.
                            </p>

                            <br>

                            <p>
                                Sejak saat itu, SMAN 1 Malingping terus tumbuh sebagai institusi pendidikan yang diperhitungkan. Dukungan masyarakat, ketersediaan guru berkualitas, peningkatan sarana belajar, serta semangat peserta didik menjadikan sekolah ini berkembang pesat, baik dari sisi akademik maupun non-akademik. Tak sedikit pula alumni yang kembali sebagai pendidik, membuktikan ikatan kuat antara sekolah dan lulusannya.
                            </p>

                            <br>

                            <p>
                                Hingga kini, SMAN 1 Malingping telah mengalami 18 kali pergantian kepala sekolah. Setiap pemimpin membawa kontribusi penting dalam membangun karakter dan visi sekolah. Dari masa ke masa, sekolah ini menjelma menjadi simbol kemajuan pendidikan di Banten Selatan.
                            </p>

                            <br>

                            <p>
                                Dengan sejarah panjang yang berakar pada perjuangan masyarakat, SMAN 1 Malingping terus melangkah maju menjadi sekolah yang tidak hanya mencerdaskan, tetapi juga menginspirasi.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div class="p-4 rounded-xl bg-forest/5 border border-forest/20 text-center">
                        <span class="font-serif text-2xl font-bold text-forest block mb-1">1983</span>
                        <span class="text-xs text-stone-600 font-sans font-medium">Tahun Resmi Pendirian</span>
                    </div>
                    <div class="p-4 rounded-xl bg-terracotta/10 border border-terracotta/20 text-center">
                        <span class="font-serif text-2xl font-bold text-terracotta block mb-1">Akreditasi A</span>
                        <span class="text-xs text-stone-600 font-sans font-medium">Predikat Unggul BAN-SM</span>
                    </div>
                    <div class="p-4 rounded-xl bg-stone-100 border border-stone-200 text-center">
                        <span class="font-serif text-2xl font-bold text-stone-900 block mb-1">40+ Tahun</span>
                        <span class="text-xs text-stone-600 font-sans font-medium">Dedikasi Pengabdian</span>
                    </div>
                </div>

            </div>

            <div x-show="activeTab === 'pimpinan'" style="display: none;" class="space-y-6">

                <div class="mb-3">
                    <h2 class="font-serif text-xl sm:text-2xl md:text-3xl text-stone-900 font-bold mb-1">Daftar Pimpinan</h2>
                    <p class="font-sans text-stone-600 text-xs sm:text-sm">Riwayat para kepala sekolah yang telah memimpin dan mendedikasikan pengabdiannya di SMAN 1 Malingping.</p>
                </div>

                <div class="overflow-hidden bg-white rounded-2xl border border-stone-200 shadow-2xs">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-sans text-xs sm:text-sm border-collapse">
                            <thead>
                                <tr class="bg-stone-100/90 border-b border-stone-200 text-stone-700 uppercase tracking-wider text-[11px] font-bold">
                                    <th class="py-3 px-3 sm:px-4 text-center w-12">No</th>
                                    <th class="py-3 px-3 sm:px-4 min-w-[180px]">Nama Kepala Sekolah</th>
                                    <th class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">Tahun Menjabat</th>
                                    <th class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">Akhir Menjabat</th>
                                    <th class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">Status Pengabdian</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100 text-stone-800">
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">1</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs. Onon Karnawijaya</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1982</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1983</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">2</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">E. Sastra Mulyana, BA</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1983</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1990</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">3</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs. H. Asikin</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1988</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1989</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">4</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs. Ansor</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1989</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1991</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">5</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs Asmin Tisna Sucipta</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1992</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1992</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">6</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Djuchri Arham, BA</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1992</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1994</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">7</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">H. Halimi Sueb, BSc</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1994</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1994</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">8</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs. Purbo Suroyo</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1995</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1998</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">9</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs. Dadang Sofyan</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1998</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1998</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">10</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs. Adin Wahyuddin</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">1998</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2001</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">11</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs. Suhendi</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2001</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2004</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">12</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs. H. Dedeng Sugandi</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2004</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2011</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">13</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Raden Supardan, S.Pd, M.Si.</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2011</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2012</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">14</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Barni, M.Pd.</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2012</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2018</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">15</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs. H. Endi Rusli Sungkawa, M.Pd.</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2018</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2020</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">16</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Fachruddin, S.Pd., M.Pd</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2020</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2020</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">17</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Drs. H. Saepudin</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2020</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2021</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-stone-500">18</td>
                                    <td class="py-3 px-3 sm:px-4 font-semibold text-stone-900">Mursidi, S.Pd.</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2021</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap">2026</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600">Purna Bakti</span>
                                    </td>
                                </tr>
                                <tr class="bg-forest/5 hover:bg-forest/10 transition-colors">
                                    <td class="py-3 px-3 sm:px-4 text-center font-bold text-forest">19</td>
                                    <td class="py-3 px-3 sm:px-4 font-bold text-forest">Zeni Januar Pamungkas, S.Si, M.Pd. (Plt)</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap font-semibold">2026</td>
                                    <td class="py-3 px-3 sm:px-4 text-center whitespace-nowrap font-bold text-forest">Sekarang</td>
                                    <td class="py-3 px-3 sm:px-4 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-forest text-white shadow-2xs">Aktif Menjabat</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div x-show="activeTab === 'visi-misi'" style="display: none;" class="space-y-6">

                <div class="p-6 sm:p-8 rounded-2xl bg-forest text-white shadow-sm">
                    <span class="font-sans text-[11px] font-bold uppercase tracking-widest text-stone-200 block mb-2">Visi Sekolah</span>
                    <h2 class="font-serif text-xl sm:text-2xl md:text-3xl leading-snug font-bold">
                        "Terwujudnya Insan yang Berakhlak Mulia, Cerdas, Kreatif dan Kolaboratif."
                    </h2>
                </div>

                <div class="p-5 sm:p-7 rounded-2xl bg-white border border-stone-200">
                    <h3 class="font-serif text-xl sm:text-2xl text-stone-900 mb-4 font-bold">Misi Sekolah</h3>

                    <div class="space-y-3.5">
                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-forest/10 text-forest font-serif font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                            <p class="text-stone-700">
                                Mewujudkan penghayatan terhadap ajaran agama yang dianut dan budaya bangsa sehingga menjadi sumber kearipan dalam bertindak.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-forest/10 text-forest font-serif font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                            <p class="text-stone-700">
                                Mewujudkan kebiasaan literasi dan mampu memanfaatkan ilmu pengetahuan serta tekonologi untuk berkontribusi secara positif dalam masyarakat digital yang dinamis.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-forest/10 text-forest font-serif font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                            <p class="text-stone-700">
                                Mewujudkan pembinaan pengembangan diri dan ekstrakurikuler sebagai wahana pengembangan kreativitas peserta didik.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-forest/10 text-forest font-serif font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">4</span>
                            <p class="text-stone-700">
                                Mewujudkan ekosistem sekolah yang kondusif melalui kemitraan yang sinergis dalam pengembagnan kompetensi abad 21.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div x-show="activeTab === 'pilar'" style="display: none;" class="space-y-5">

                <div class="mb-3">
                    <h2 class="font-serif text-xl sm:text-2xl md:text-3xl text-stone-900 font-bold mb-1">4 Pilar Karakter Warga Sekolah</h2>
                    <p class="font-sans text-stone-600 text-xs sm:text-sm">Nilai filosofis kearifan lokal yang menjadi pedoman etika civitas akademika SMAN 1 Malingping.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="p-5 rounded-2xl bg-white border border-stone-200 hover:border-forest/50 transition-colors">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="w-9 h-9 rounded-xl bg-forest/10 text-forest flex items-center justify-center font-serif text-base font-bold">01</span>
                            <h3 class="font-serif text-xl text-stone-900 font-bold">Cageur (Kesehatan)</h3>
                        </div>
                        <p class="text-stone-700 text-sm">
                            Memiliki kebugaran jasmani, ketenangan rohani, dan kesehatan mental yang seimbang. Menjaga pola hidup sehat, kebersihan diri, dan lingkungan belajar.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white border border-stone-200 hover:border-terracotta/50 transition-colors">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="w-9 h-9 rounded-xl bg-terracotta/15 text-terracotta flex items-center justify-center font-serif text-base font-bold">02</span>
                            <h3 class="font-serif text-xl text-stone-900 font-bold">Bageur (Keluhuran Budi)</h3>
                        </div>
                        <p class="text-stone-700 text-sm">
                            Berakhlak terpuji, bertutur kata sopan, saling menghargai keberagaman, memiliki jiwa empati, dan konsisten menerapkan budaya Senyum, Salam, Sapa, Sopan, dan Santun (5S).
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white border border-stone-200 hover:border-stone-400 transition-colors">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="w-9 h-9 rounded-xl bg-stone-100 text-stone-800 flex items-center justify-center font-serif text-base font-bold">03</span>
                            <h3 class="font-serif text-xl text-stone-900 font-bold">Bener (Integritas)</h3>
                        </div>
                        <p class="text-stone-700 text-sm">
                            Menjunjung tinggi kejujuran intelektual, anti-plagiarisme, mematuhi tata tertib, memegang teguh amanah, dan berani bersikap adil serta bertanggung jawab.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white border border-stone-200 hover:border-forest/50 transition-colors">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="w-9 h-9 rounded-xl bg-forest/10 text-forest flex items-center justify-center font-serif text-base font-bold">04</span>
                            <h3 class="font-serif text-xl text-stone-900 font-bold">Pinter (Kecerdasan)</h3>
                        </div>
                        <p class="text-stone-700 text-sm">
                            Cerdas bernalar kritis, gemar membaca literatur, haus akan inovasi teknologi, serta gigih mengejar prestasi akademik maupun non-akademik di tingkat regional dan nasional.
                        </p>
                    </div>
                </div>

            </div>

            <div x-show="activeTab === 'ekskul'" style="display: none;" class="space-y-6">

                <div class="mb-3">
                    <h2 class="font-serif text-xl sm:text-2xl md:text-3xl text-stone-900 font-bold mb-1">Ekstrakurikuler & Organisasi Siswa</h2>
                    <p class="font-sans text-stone-600 text-xs sm:text-sm">Wadah penyaluran minat, bakat, kepemimpinan, dan prestasi civitas peserta didik SMAN 1 Malingping.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5">

                    <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-forest/10 text-forest mb-2">Kepemimpinan</span>
                        <h4 class="font-serif text-base font-bold text-stone-900 mb-1">OSIS & MPK</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Organisasi induk kepengurusan siswa yang memfasilitasi aspirasi, kepemimpinan, dan penyelenggaraan kegiatan sekolah.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-amber-500/10 text-amber-700 mb-2">Kepanduan</span>
                        <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Pramuka (Gugus Depan)</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Membentuk ketangguhan mental, kepedulian alam bebas, kedisiplinan, kemandirian, dan semangat gotong royong.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-red-500/10 text-red-700 mb-2">Kebangsaan</span>
                        <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Paskibra Satuan Sekolah</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Pelatihan baris-berbaris, tata upacara resmi, penempaan fisik, serta penanaman jiwa nasionalisme cinta tanah air.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-rose-500/10 text-rose-700 mb-2">Kemanusiaan</span>
                        <h4 class="font-serif text-base font-bold text-stone-900 mb-1">PMR Wira (Palang Merah)</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Keterampilan pertolongan pertama pada kecelakaan (PPGD), mitigasi bencana, donor darah, dan bakti sosial.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-500/10 text-blue-700 mb-2">Sains & Riset</span>
                        <h4 class="font-serif text-base font-bold text-stone-900 mb-1">KIR & Klub Olimpiade (OSN)</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Penelitian ilmiah remaja, karya tulis inovatif, dan pembinaan intensif ajang Olimpiade Sains Nasional.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-700 mb-2">Kerohanian</span>
                        <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Rohis & Keputrian</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Kajian keagamaan Islam, peringatan hari besar, pembinaan akhlak mulia, serta kegiatan tahsin dan tahfidz Al-Qur'an.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-orange-500/10 text-orange-700 mb-2">Olahraga</span>
                        <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Klub Olahraga Prestasi</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Latihan rutin futsal, bola basket, bola voli, bulutangkis, dan pencak silat untuk kejuaraan O2SN antarsekolah.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-purple-500/10 text-purple-700 mb-2">Seni Budaya</span>
                        <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Sanggar Seni & Teater</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Pengembangan seni tari tradisional Banten, musik akustik, paduan suara, dan pementasan teater sastra.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-stone-500/10 text-stone-700 mb-2">Literasi & Media</span>
                        <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Jurnalistik & Fotografi</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Edukasi peliputan warta, kepenulisan artikel portal warga, fotografi dokumenter, dan pengelolaan mading sekolah.</p>
                    </div>

                </div>

            </div>

            <div x-show="activeTab === 'fasilitas'" style="display: none;" class="space-y-6">

                <div>
                    <h2 class="font-serif text-xl sm:text-2xl text-stone-900 font-bold mb-3">Fasilitas</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5">
                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Laboratorium Komputer</h4>
                            <p class="text-stone-600 text-xs leading-relaxed">Dilengkapi puluhan PC dan koneksi internet serat optik berkecepatan tinggi untuk asesmen digital.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Laboratorium Sains Lengkap</h4>
                            <p class="text-stone-600 text-xs leading-relaxed">Laboratorium Fisika, Kimia, dan Biologi dengan instrumen praktikum terstandarl.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Perpustakaan & Ruang Baca</h4>
                            <p class="text-stone-600 text-xs leading-relaxed">Ribuan koleksi buku teks, referensi ilmiah, karya sastra, serta area baca berpendingin udara yang tenang.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Lapangan Olahraga Terbuka</h4>
                            <p class="text-stone-600 text-xs leading-relaxed">Sarana multifungsi untuk cabang bola basket, bola voli, futsal, dan upacara bendera sekolah.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Masjid</h4>
                            <p class="text-stone-600 text-xs leading-relaxed">Pusat pembinaan keagamaan, shalat berjamaah, dan kegiatan kerohanian Islam seluruh civitas akademika.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-stone-200 shadow-2xs">
                            <h4 class="font-serif text-base font-bold text-stone-900 mb-1">Aula Pertemuan</h4>
                            <p class="text-stone-600 text-xs leading-relaxed">Ruang pertemuan yang dilengkapi dengan sound system dan proyektor untuk kegiatan akademik dan kegiatan sekolah lainnya.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div x-show="activeTab === 'kontak'" style="display: none;" class="space-y-6">

                <div class="p-5 sm:p-7 rounded-2xl bg-white border border-stone-200 shadow-2xs">
                    <h2 class="font-serif text-xl sm:text-2xl text-stone-900 mb-4 font-bold">Kontak Pelayanan</h2>

                    <div class="space-y-4 text-xs sm:text-sm">
                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-lg bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <div>
                                <strong class="font-sans text-stone-900 block text-sm sm:text-base">Alamat Sekolah:</strong>
                                <p class="text-stone-700 leading-relaxed">
                                    Jln. Raya Bayah KM. 4 No. 39, Kecamatan Malingping, Kabupaten Lebak, Banten 42391.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-lg bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <div>
                                <strong class="font-sans text-stone-900 block text-sm sm:text-base">Email Resmi:</strong>
                                <p class="text-stone-700 leading-relaxed">info@sman1malingping.sch.id</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-lg bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <div>
                                <strong class="font-sans text-stone-900 block text-sm sm:text-base">Jam Pelayanan:</strong>
                                <p class="text-stone-700 leading-relaxed">Senin – Jumat: Pukul 07.15 – 16.00 WIB</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-5 border-t border-stone-200 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <a
                                href="https://maps.google.com/?q=SMAN+1+Malingping"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-forest text-white font-sans text-xs sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Google Maps</span>
                            </a>
                            <a
                                href="{{ route('contact') }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full border border-stone-300 text-stone-700 hover:text-forest hover:border-forest font-sans text-xs sm:text-sm font-semibold transition-colors"
                            >
                                <span>Halaman Kontak</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </main>

</x-layouts.app>
