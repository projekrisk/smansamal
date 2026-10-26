@push('styles')
<style>
    .home-section-p {
        font-size: 0.9375rem;
        line-height: 1.65;
    }
    @media (min-width: 640px) {
        .home-section-p {
            font-size: 1rem;
            line-height: 1.75;
        }
    }
</style>
@endpush

<x-layouts.app :isHome="true">

    <section id="hero" class="relative w-full h-screen overflow-hidden flex flex-col justify-between">

        <div class="absolute inset-0 w-full h-full">
            <img src="{{ asset('images/bg.jpg') }}" alt="Kampus SMAN 1 Malingping" class="w-full h-full object-cover" fetchpriority="high" loading="eager" decoding="async">

            <div class="absolute inset-0 bg-stone-900/60"></div>
        </div>

        <div class="absolute inset-0 z-10 flex items-center justify-center text-center px-6 pointer-events-none">
            <div class="max-w-3xl pointer-events-auto flex flex-col items-center">
                <p class="font-sans text-stone-50 text-xs md:text-sm font-medium tracking-widest uppercase mb-4 drop-shadow-md">Cageur, Bageur, Bener, Pinter.</p>
                <h1 class="font-serif text-3xl sm:text-5xl md:text-6xl text-white leading-tight mb-8 drop-shadow-lg">
                    Tempat Bertumbuh <br>Meraih <i class="text-stone-200">Masa Depan</i>.
                </h1>

                <a href="{{ route('profil-sekolah') }}" class="inline-block bg-white text-stone-900 px-7 sm:px-8 py-3 sm:py-3.5 rounded-full text-xs sm:text-sm font-bold hover:bg-forest hover:text-white transition-colors duration-300 shadow-lg pointer-events-auto">
                    Profil Sekolah
                </a>
            </div>
        </div>

        <div class="absolute bottom-8 w-full flex justify-center z-20 pointer-events-auto">
            <a href="#umum" class="flex flex-col items-center text-white/90 hover:text-white transition-colors animate-bounce">
                <span class="font-sans text-[10px] md:text-xs uppercase tracking-widest mb-2 font-medium">Scroll ke Bawah</span>
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </a>
        </div>

    </section>

    <section id="umum" class="w-full bg-stone-50 py-16 sm:py-20 md:py-28 flex justify-center scroll-mt-12 relative">
        <div id="pilar" class="absolute -top-12"></div>
        <div class="w-full max-w-[1000px] px-4 sm:px-6">

            <div class="text-center mb-10 md:mb-14">
                <span class="inline-block text-[11px] sm:text-xs font-bold font-sans uppercase tracking-widest text-forest bg-forest/10 px-3.5 py-1 rounded-full mb-2.5">Informasi Umum</span>
                <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl text-stone-900 mb-3 font-bold">Data Pokok Sekolah</h2>
                <p class="font-sans text-stone-600 max-w-xl mx-auto home-section-p">
                    Informasi profil kelembagaan resmi SMA Negeri 1 Malingping yang berlaku sebagai pedoman identitas, legalitas penyelenggaraan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">

                <div class="bg-white p-5 sm:p-6 md:p-7 rounded-2xl md:rounded-[1.75rem] shadow-sm border border-stone-200/80 hover:border-forest hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] font-bold text-terracotta uppercase tracking-wider font-sans">Status Lembaga</span>
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 group-hover:bg-forest group-hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        </div>
                        <h3 class="font-serif text-xl sm:text-2xl text-stone-900 mb-1.5 font-semibold">SMA Negeri</h3>
                        <p class="font-sans text-xs sm:text-sm text-stone-600 leading-relaxed">
                            Pemerintah Provinsi Banten &bull; Dinas Pendidikan & Kebudayaan
                        </p>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 md:p-7 rounded-2xl md:rounded-[1.75rem] shadow-sm border border-stone-200/80 hover:border-forest hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] font-bold text-terracotta uppercase tracking-wider font-sans">Identitas Pokok</span>
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 group-hover:bg-forest group-hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                        </div>
                        <h3 class="font-serif text-xl sm:text-2xl text-stone-900 mb-1.5 font-mono font-semibold">20601859</h3>
                        <p class="font-sans text-xs sm:text-sm text-stone-600 leading-relaxed">
                            Nomor Pokok Sekolah Nasional resmi terdaftar Kemendikbudristek
                        </p>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 md:p-7 rounded-2xl md:rounded-[1.75rem] shadow-sm border border-stone-200/80 hover:border-forest hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] font-bold text-terracotta uppercase tracking-wider font-sans">Bentuk Pendidikan</span>
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 group-hover:bg-forest group-hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                        </div>
                        <h3 class="font-serif text-xl sm:text-2xl text-stone-900 mb-1.5 font-semibold">Kelas X - XII</h3>
                        <p class="font-sans text-xs sm:text-sm text-stone-600 leading-relaxed">
                            Pendidikan formal tingkat menengah atas dengan kurikulum nasional
                        </p>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 md:p-7 rounded-2xl md:rounded-[1.75rem] shadow-sm border border-stone-200/80 hover:border-forest hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] font-bold text-terracotta uppercase tracking-wider font-sans">Wilayah & Domisili</span>
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 group-hover:bg-forest group-hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        </div>
                        <h3 class="font-serif text-xl sm:text-2xl text-stone-900 mb-1.5 font-semibold">Lebak, Banten</h3>
                        <p class="font-sans text-xs sm:text-sm text-stone-600 leading-relaxed">
                            Jl. Raya Bayah, Kecamatan Malingping, Kabupaten Lebak, Banten
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="news" class="w-full bg-white py-16 sm:py-20 md:py-28 flex justify-center scroll-mt-12">
        <div class="w-full max-w-[1000px] px-4 sm:px-6">
            <div class="text-center mb-8 sm:mb-12 md:mb-16">
                <span class="inline-block text-[11px] sm:text-xs font-bold font-sans uppercase tracking-widest text-forest bg-forest/10 px-3.5 py-1 rounded-full mb-2.5">Warta & Kabar</span>
                <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl text-stone-900 mb-3 font-bold">Berita Sekolah</h2>
                <p class="font-sans text-stone-600 max-w-lg mx-auto home-section-p">Cerita terbaru dari aktivitas, pembelajaran, dan eksplorasi siswa-siswi SMAN 1 Malingping di dalam dan luar kelas.</p>
            </div>

            <div class="flex flex-col gap-6 md:grid md:grid-cols-3 md:gap-x-6 md:gap-y-10">
                @forelse($jurnalArticles as $article)
                    <x-article-card-jurnal :article="$article" />
                @empty
                    <div class="col-span-3 text-center py-10 text-stone-500 font-sans text-sm">Belum ada jurnal sekolah yang dipublikasikan.</div>
                @endforelse
            </div>

            <div class="mt-10 md:mt-14 text-center">
                <a href="{{ route('berita.index') }}" class="inline-block border border-stone-300 text-stone-800 px-7 sm:px-8 py-2.5 sm:py-3 rounded-full text-xs sm:text-sm font-semibold hover:bg-stone-200 transition-colors duration-300">
                    Semua Berita
                </a>
            </div>
        </div>
    </section>

    <section id="artikel" class="w-full bg-stone-100 py-16 sm:py-20 md:py-28 flex justify-center border-t border-stone-200/50 scroll-mt-12">
        <div class="w-full max-w-[1000px] px-4 sm:px-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 sm:mb-12 md:mb-14 gap-4 sm:gap-6">
                <div class="max-w-xl">
                    <span class="inline-block text-[11px] sm:text-xs font-bold font-sans uppercase tracking-widest text-terracotta bg-terracotta/10 px-3.5 py-1 rounded-full mb-2.5">Opini & Esai</span>
                    <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl text-stone-900 mb-2 font-bold">Suara Warga Sekolah</h2>
                    <p class="font-sans text-stone-600 home-section-p">Kumpulan opini, esai, dan karya tulis inspiratif yang ditulis langsung oleh pemikiran kritis siswa, guru, dan alumni.</p>
                </div>
                <a href="{{ route('suara-warga.index') }}" class="font-sans text-xs sm:text-sm font-semibold text-terracotta hover:text-forest transition-colors flex items-center gap-1.5 pb-1">
                    Semua Tulisan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                @forelse($suaraWargaArticles as $swArticle)
                    <x-article-card-suara-warga :article="$swArticle" layout="vertical" />
                @empty
                    <div class="col-span-3 text-center py-12 text-stone-500 font-sans">Belum ada karya tulis Suara Warga saat ini.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="agenda" class="w-full bg-forest text-white py-16 sm:py-20 md:py-28 flex justify-center relative scroll-mt-12">
        <div class="w-full max-w-[1000px] px-4 sm:px-6">
            <div class="text-center mb-8 sm:mb-12 md:mb-14">
                <span class="inline-block text-[11px] sm:text-xs font-bold font-sans uppercase tracking-widest text-stone-200 bg-white/10 px-3.5 py-1 rounded-full mb-2.5">Kalender Kegiatan</span>
                <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl text-stone-50 mb-3 font-bold">Agenda Mendatang</h2>
                <p class="font-sans text-stone-300 max-w-lg mx-auto home-section-p">Kalender akademik dan kegiatan penting sekolah. Klik pada tanggal yang ditandai untuk melihat detail kegiatan.</p>
            </div>

            <div class="bg-white/10 p-5 sm:p-8 md:p-10 rounded-2xl md:rounded-[2rem] backdrop-blur-md border border-white/20 mx-auto max-w-3xl">

                <div class="flex justify-between items-center mb-6 sm:mb-8">
                    <button class="p-2 hover:bg-white/10 rounded-full transition-colors text-white/70 hover:text-white focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <h3 class="font-serif text-xl sm:text-2xl md:text-3xl font-medium tracking-wide">Oktober 2026</h3>
                    <button class="p-2 hover:bg-white/10 rounded-full transition-colors text-white/70 hover:text-white focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <div class="grid grid-cols-7 gap-1.5 sm:gap-3 md:gap-4 text-center font-sans text-xs sm:text-sm md:text-base mb-2">
                    <div class="font-semibold text-terracotta">Min</div>
                    <div class="font-semibold text-stone-300">Sen</div>
                    <div class="font-semibold text-stone-300">Sel</div>
                    <div class="font-semibold text-stone-300">Rab</div>
                    <div class="font-semibold text-stone-300">Kam</div>
                    <div class="font-semibold text-stone-300">Jum</div>
                    <div class="font-semibold text-stone-300">Sab</div>
                </div>

                <div class="grid grid-cols-7 gap-y-3 gap-x-1.5 sm:gap-3 md:gap-4 text-center font-sans text-xs sm:text-sm md:text-base">

                    <div class="py-2 text-white/30">27</div>
                    <div class="py-2 text-white/30">28</div>
                    <div class="py-2 text-white/30">29</div>
                    <div class="py-2 text-white/30">30</div>

                    @for($day = 1; $day <= 14; $day++)
                        <div class="py-2">{{ $day }}</div>
                    @endfor

                    <div class="py-2 bg-terracotta text-white rounded-full cursor-pointer hover:bg-white hover:text-terracotta transition-colors shadow-lg event-day font-bold"
                         data-date="15 Oktober 2026"
                         data-title="Pekan Olahraga dan Seni (Porseni)"
                         data-desc="Kegiatan kompetisi olahraga dan pertunjukan seni antar kelas yang diadakan di Lapangan Utama & Gelora SMAN 1 Malingping. Wajib diikuti oleh perwakilan seluruh kelas.">
                         15
                    </div>

                    @for($day = 16; $day <= 21; $day++)
                        <div class="py-2">{{ $day }}</div>
                    @endfor

                    <div class="py-2 bg-terracotta text-white rounded-full cursor-pointer hover:bg-white hover:text-terracotta transition-colors shadow-lg event-day font-bold"
                         data-date="22 Oktober 2026"
                         data-title="Seminar Kewirausahaan Pemuda"
                         data-desc="Seminar terbuka di Aula Serbaguna yang mengundang pengusaha muda lokal untuk membagikan pengalaman merintis bisnis sejak di bangku sekolah. Acara dimulai pukul 09:00 - 12:00 WIB.">
                         22
                    </div>

                    @for($day = 23; $day <= 31; $day++)
                        <div class="py-2">{{ $day }}</div>
                    @endfor
                </div>
            </div>
        </div>

        <div id="agenda-modal" class="fixed inset-0 z-[100] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm cursor-pointer" id="modal-backdrop"></div>
            <div class="bg-white text-stone-900 w-[90%] max-w-md p-6 sm:p-8 rounded-2xl md:rounded-[2rem] shadow-2xl relative z-10 transform scale-95 transition-transform duration-300" id="modal-content">
                <button id="close-modal" class="absolute top-5 right-5 text-stone-400 hover:text-stone-900 transition-colors focus:outline-none">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="flex items-center gap-2.5 mb-2.5">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p id="modal-date" class="text-terracotta font-sans text-xs sm:text-sm font-semibold tracking-wider uppercase">Tanggal</p>
                </div>
                <h4 id="modal-title" class="font-serif text-xl sm:text-2xl mb-3 leading-tight font-bold">Judul Acara</h4>
                <p id="modal-desc" class="font-sans text-stone-600 text-xs sm:text-sm md:text-base leading-relaxed">Deskripsi lengkap mengenai acara yang akan diselenggarakan...</p>
            </div>
        </div>
    </section>

    <section id="alumni" class="w-full bg-white py-16 sm:py-20 md:py-28 flex justify-center border-b border-stone-200/50 scroll-mt-12">
        <div class="w-full max-w-[1000px] px-4 sm:px-6 relative">
            <div class="text-center mb-8 sm:mb-12 md:mb-14">
                <span class="inline-block text-[11px] sm:text-xs font-bold font-sans uppercase tracking-widest text-terracotta bg-terracotta/10 px-3.5 py-1 rounded-full mb-2.5">Kisah Inspiratif</span>
                <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl text-stone-900 mb-3 font-bold">Kata Alumni</h2>
                <p class="font-sans text-stone-600 max-w-lg mx-auto home-section-p">Jejak langkah dan kisah sukses lulusan SMAN 1 Malingping setelah menempuh pendidikan bersama kami.</p>
            </div>

            <div class="relative w-full max-w-4xl mx-auto overflow-hidden pb-10 group">

                <div class="flex transition-transform duration-700 ease-in-out w-full" id="alumni-track">
                    @forelse($testimonials as $testi)
                        <div class="w-full flex-shrink-0 px-2 sm:px-6 md:px-12 box-border">
                            <div class="bg-stone-50 p-6 sm:p-10 md:p-12 rounded-2xl md:rounded-[2rem] border border-stone-100 flex flex-col justify-between text-center h-full">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-terracotta/30 mx-auto mb-4 sm:mb-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                                <p class="font-serif text-stone-800 text-base sm:text-lg md:text-xl leading-relaxed mb-6">
                                    {{ $testi->content }}
                                </p>
                                <div class="flex flex-col items-center">
                                    @if($testi->avatar_url)
                                        @if($testi->profile_url)
                                            <a href="{{ $testi->profile_url }}" class="inline-block mb-3 group/avatar" title="Lihat profil {{ $testi->name }}">
                                                <img src="{{ $testi->avatar_url }}" alt="{{ $testi->name }}" class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover border-2 border-stone-200 group-hover/avatar:border-forest group-hover/avatar:ring-2 group-hover/avatar:ring-forest/20 transition-all duration-300 shadow-2xs">
                                            </a>
                                        @else
                                            <div class="mb-3">
                                                <img src="{{ $testi->avatar_url }}" alt="{{ $testi->name }}" class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover border-2 border-stone-200 shadow-2xs">
                                            </div>
                                        @endif
                                    @endif

                                    @if($testi->profile_url)
                                        <a href="{{ $testi->profile_url }}" class="inline-flex items-center justify-center gap-1.5 group/alumni hover:text-forest transition-colors focus:outline-none" title="Lihat profil {{ $testi->name }}">
                                            <h4 class="font-sans font-bold text-base sm:text-lg text-stone-900 group-hover/alumni:text-forest group-hover/alumni:underline underline-offset-4 transition-colors">
                                                {{ $testi->name }}
                                            </h4>
                                            <svg class="w-3.5 h-3.5 text-stone-400 group-hover/alumni:text-forest transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    @else
                                        <h4 class="font-sans font-bold text-base sm:text-lg text-stone-900">{{ $testi->name }}</h4>
                                    @endif
                                    <p class="font-sans text-xs text-stone-500 uppercase tracking-widest mt-1">{{ $testi->role_subtitle }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-full text-center py-10 text-stone-500 font-sans text-sm">Belum ada testimoni.</div>
                    @endforelse
                </div>

                <button id="btn-prev" class="absolute top-[40%] -translate-y-1/2 left-0 sm:left-2 md:left-4 z-10 w-9 h-9 sm:w-11 sm:h-11 bg-white/95 backdrop-blur border border-stone-200 text-stone-600 rounded-full flex items-center justify-center shadow-md hover:bg-forest hover:text-white hover:border-forest transition-colors focus:outline-none opacity-100 md:opacity-0 md:group-hover:opacity-100 duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button id="btn-next" class="absolute top-[40%] -translate-y-1/2 right-0 sm:right-2 md:right-4 z-10 w-9 h-9 sm:w-11 sm:h-11 bg-white/95 backdrop-blur border border-stone-200 text-stone-600 rounded-full flex items-center justify-center shadow-md hover:bg-forest hover:text-white hover:border-forest transition-colors focus:outline-none opacity-100 md:opacity-0 md:group-hover:opacity-100 duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <div class="absolute bottom-0 left-0 right-0 flex justify-center gap-2.5" id="slider-dots"></div>
            </div>

            <div class="mt-10 sm:mt-14 text-center border-t border-stone-200/60 pt-8 sm:pt-10 max-w-2xl mx-auto" x-data="{ openTestiModal: false }">
                <h4 class="font-serif text-xl sm:text-2xl text-stone-900 mb-2 font-bold">Anda Alumni SMAN 1 Malingping?</h4>
                <p class="font-sans text-stone-600 mb-5 home-section-p">Mari menginspirasi adik-adik tingkat dengan membagikan perjalanan dan kisah sukses Anda setelah lulus dari sini.</p>
                @auth
                    @if(auth()->user()->testimonials()->exists())
                        <div class="inline-flex flex-wrap items-center justify-center gap-2 bg-stone-100 text-stone-700 px-6 py-2.5 rounded-full text-xs sm:text-sm font-semibold border border-stone-200">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Anda telah mengirimkan testimoni alumni (Terkunci)</span>
                            <a href="{{ route('warga.testimonials.index') }}" class="text-forest hover:text-stone-900 underline font-bold ml-1">Lihat Dasbor &rarr;</a>
                        </div>
                    @else
                        <button @click="openTestiModal = true" class="inline-flex items-center gap-2 bg-terracotta text-white px-7 sm:px-8 py-2.5 sm:py-3 rounded-full text-xs sm:text-sm font-semibold hover:bg-stone-900 transition-colors duration-300 shadow-sm hover:shadow-md cursor-pointer">
                            Tulis Alumni
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-terracotta text-white px-7 sm:px-8 py-2.5 sm:py-3 rounded-full text-xs sm:text-sm font-semibold hover:bg-stone-900 transition-colors duration-300 shadow-sm hover:shadow-md cursor-pointer">
                        Tulis Alumni
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @endauth

                <div x-show="openTestiModal" class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-stone-900/60 backdrop-blur-sm" style="display: none;">
                    <div @click.away="openTestiModal = false" class="bg-white rounded-2xl md:rounded-[2rem] max-w-lg w-full p-6 sm:p-8 text-left shadow-2xl relative">
                        <button @click="openTestiModal = false" class="absolute top-5 right-5 text-stone-400 hover:text-stone-900 focus:outline-none">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        <h3 class="font-serif text-xl sm:text-2xl text-stone-900 mb-1.5 font-bold">Bagikan Kisah Anda</h3>
                        <p class="font-sans text-xs text-stone-500 mb-3">Testimoni Anda akan ditampilkan di beranda portal sekolah.</p>

                        <div class="mb-4 p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 flex items-start gap-2">
                            <svg class="w-4 h-4 text-amber-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span>Setiap alumni hanya dapat membuat <strong>1 kali testimoni</strong>. Testimoni yang dikirimkan akan terkunci dan tidak dapat diedit atau dihapus.</span>
                        </div>

                        <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block font-sans text-xs font-bold text-stone-700 uppercase mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ auth()->user()?->name }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-sans text-xs font-bold text-stone-700 uppercase mb-1">Tahun Lulus</label>
                                    <input type="number" name="graduation_year" placeholder="2022" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest">
                                </div>
                                <div>
                                    <label class="block font-sans text-xs font-bold text-stone-700 uppercase mb-1">Pekerjaan / Kampus</label>
                                    <input type="text" name="current_role" placeholder="Mahasiswa UI" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest">
                                </div>
                            </div>
                            <div x-data="{ text: '', max: 300 }">
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block font-sans text-xs font-bold text-stone-700 uppercase">Testimoni Anda</label>
                                    <span class="text-[11px] font-semibold" :class="text.length > 270 ? (text.length >= max ? 'text-rose-600 font-bold' : 'text-amber-600') : 'text-stone-400'">
                                        <span x-text="text.length"></span>/300 karakter
                                    </span>
                                </div>
                                <textarea name="content" x-model="text" maxlength="300" rows="4" placeholder="Ceritakan bagaimana bekal pendidikan dari SMAN 1 Malingping membantu perjalanan Anda..." required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest resize-none"></textarea>
                                <span class="text-[11px] text-stone-400 mt-1 block">Maksimal 300 karakter agar tampilan kutipan tetap ringkas.</span>
                            </div>
                            <div class="text-right pt-2">
                                <button type="submit" class="bg-forest text-white px-6 py-2.5 rounded-full text-xs sm:text-sm font-semibold hover:bg-stone-900 transition-colors">
                                    Kirim Testimoni
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="w-full bg-stone-50 py-16 sm:py-20 md:py-28 flex justify-center border-b border-stone-200/50 scroll-mt-12">
        <div class="w-full max-w-[800px] px-4 sm:px-6">
            <div class="text-center mb-8 sm:mb-12 md:mb-14">
                <span class="inline-block text-[11px] sm:text-xs font-bold font-sans uppercase tracking-widest text-forest bg-forest/10 px-3.5 py-1 rounded-full mb-2.5">Bantuan & Informasi</span>
                <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl text-stone-900 mb-3 font-bold">Pertanyaan Umum</h2>
                <p class="font-sans text-stone-600 max-w-lg mx-auto home-section-p">Informasi seputar pendaftaran, fasilitas, dan program sekolah yang paling sering ditanyakan oleh calon siswa dan orang tua.</p>
            </div>

            <div class="space-y-3.5">

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group faq-item">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold faq-toggle focus:outline-none text-left">
                        Kapan pendaftaran siswa baru (SPMB) dibuka?
                        <svg class="w-5 h-5 text-terracotta faq-icon transition-transform duration-300 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                    <div class="faq-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <p class="font-sans text-stone-600 text-xs sm:text-sm md:text-base mt-3 pt-3 border-t border-stone-100 leading-relaxed">SPMB biasanya dibuka pada bulan Juni setiap tahunnya. Informasi lengkap mengenai jalur pendaftaran (prestasi, afirmasi, zonasi, dan perpindahan tugas) akan diumumkan melalui website resmi dan media sosial SMAN 1 Malingping.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group faq-item">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold faq-toggle focus:outline-none text-left">
                        Apa saja ekstrakurikuler yang tersedia?
                        <svg class="w-5 h-5 text-terracotta faq-icon transition-transform duration-300 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                    <div class="faq-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <p class="font-sans text-stone-600 text-xs sm:text-sm md:text-base mt-3 pt-3 border-t border-stone-100 leading-relaxed">Kami memiliki lebih dari 15 kegiatan ekstrakurikuler unggulan, di antaranya: Pramuka, Paskibra, PMR, Karya Ilmiah Remaja (KIR), Rohis, Paduan Suara, Teater, serta berbagai klub olahraga (Basket, Voli, Futsal).</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group faq-item">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold faq-toggle focus:outline-none text-left">
                        Apakah SMAN 1 Malingping menyediakan beasiswa?
                        <svg class="w-5 h-5 text-terracotta faq-icon transition-transform duration-300 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                    <div class="faq-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <p class="font-sans text-stone-600 text-xs sm:text-sm md:text-base mt-3 pt-3 border-t border-stone-100 leading-relaxed">Ya, kami membantu menyalurkan berbagai program beasiswa seperti PIP (Program Indonesia Pintar) dari pemerintah, serta beasiswa khusus dari komite sekolah dan mitra alumni bagi siswa berprestasi dan kurang mampu.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group faq-item">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold faq-toggle focus:outline-none text-left">
                        Bagaimana sistem keamanan dan fasilitas sekolah?
                        <svg class="w-5 h-5 text-terracotta faq-icon transition-transform duration-300 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                    <div class="faq-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <p class="font-sans text-stone-600 text-xs sm:text-sm md:text-base mt-3 pt-3 border-t border-stone-100 leading-relaxed">Sekolah dilengkapi dengan CCTV di area strategis, petugas keamanan 24 jam, laboratorium lengkap (Sains, Komputer, Bahasa), perpustakaan digital, serta lapangan olahraga multifungsi untuk mendukung kenyamanan belajar.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 sm:mt-10 text-center">
                <a href="{{ route('sop') }}" class="inline-flex items-center gap-2.5 px-6 py-3 rounded-full bg-forest text-white text-xs sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-sm">
                    <span>Lihat Standar Operasional Pelayanan (SOP) Lengkap</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        const eventDays = document.querySelectorAll('.event-day');
        const agendaModal = document.getElementById('agenda-modal');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const closeModal = document.getElementById('close-modal');
        const modalContent = document.getElementById('modal-content');

        const modalDate = document.getElementById('modal-date');
        const modalTitle = document.getElementById('modal-title');
        const modalDesc = document.getElementById('modal-desc');

        function openModal(date, title, desc) {
            modalDate.textContent = date;
            modalTitle.textContent = title;
            modalDesc.textContent = desc;

            agendaModal.classList.remove('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
            document.body.style.overflow = 'hidden';
        }

        function hideModal() {
            agendaModal.classList.add('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            document.body.style.overflow = '';
        }

        eventDays.forEach(day => {
            day.addEventListener('click', (e) => {
                const date = e.target.getAttribute('data-date');
                const title = e.target.getAttribute('data-title');
                const desc = e.target.getAttribute('data-desc');
                openModal(date, title, desc);
            });
        });

        if(closeModal) closeModal.addEventListener('click', hideModal);
        if(modalBackdrop) modalBackdrop.addEventListener('click', hideModal);

        const track = document.getElementById('alumni-track');
        if (track && track.children.length > 0) {
            const slides = track.children;
            const btnNext = document.getElementById('btn-next');
            const btnPrev = document.getElementById('btn-prev');
            const dotsContainer = document.getElementById('slider-dots');
            let currentSlide = 0;
            let slideInterval;

            for(let i=0; i<slides.length; i++) {
                const dot = document.createElement('button');
                dot.className = `w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none ${i === 0 ? 'bg-terracotta w-6' : 'bg-stone-300 hover:bg-stone-400'}`;
                dot.addEventListener('click', () => {
                    goToSlide(i);
                    resetInterval();
                });
                dotsContainer.appendChild(dot);
            }
            const dots = dotsContainer.children;

            function updateSliderUI() {
                track.style.transform = `translateX(-${currentSlide * 100}%)`;
                Array.from(dots).forEach((dot, index) => {
                    if(index === currentSlide) {
                        dot.className = 'w-6 h-2.5 rounded-full bg-terracotta transition-all duration-300 focus:outline-none';
                    } else {
                        dot.className = 'w-2.5 h-2.5 rounded-full bg-stone-300 hover:bg-stone-400 transition-all duration-300 focus:outline-none';
                    }
                });
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                updateSliderUI();
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                updateSliderUI();
            }

            function goToSlide(index) {
                currentSlide = index;
                updateSliderUI();
            }

            if(btnNext) btnNext.addEventListener('click', () => { nextSlide(); resetInterval(); });
            if(btnPrev) btnPrev.addEventListener('click', () => { prevSlide(); resetInterval(); });

            function startInterval() {
                slideInterval = setInterval(nextSlide, 5000);
            }

            function resetInterval() {
                clearInterval(slideInterval);
                startInterval();
            }

            track.addEventListener('mouseenter', () => clearInterval(slideInterval));
            track.addEventListener('mouseleave', startInterval);

            startInterval();
        }

        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            const toggle = item.querySelector('.faq-toggle');
            const content = item.querySelector('.faq-content');
            const icon = item.querySelector('.faq-icon');

            toggle.addEventListener('click', () => {
                const isOpen = content.style.gridTemplateRows === '1fr';

                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.querySelector('.faq-content').style.gridTemplateRows = '0fr';
                        otherItem.querySelector('.faq-content').style.opacity = '0';
                        otherItem.querySelector('.faq-icon').classList.remove('rotate-45');
                    }
                });

                if (!isOpen) {
                    content.style.gridTemplateRows = '1fr';
                    content.style.opacity = '1';
                    icon.classList.add('rotate-45');
                } else {
                    content.style.gridTemplateRows = '0fr';
                    content.style.opacity = '0';
                    icon.classList.remove('rotate-45');
                }
            });
        });

        const homeBackTop = document.getElementById('btn-home-back-top');
        const homeProgressRing = document.getElementById('home-scroll-progress-ring');

        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = docHeight > 0 ? Math.min(scrollTop / docHeight, 1) : 0;

            if (homeProgressRing) {
                homeProgressRing.style.strokeDasharray = `${scrollPercent * 100}, 100`;
            }

            if (scrollTop > 350) {
                homeBackTop.classList.remove('opacity-0', 'translate-y-8', 'pointer-events-none');
            } else {
                homeBackTop.classList.add('opacity-0', 'translate-y-8', 'pointer-events-none');
            }
        });

        if (homeBackTop) {
            homeBackTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    </script>
    @endpush

    <div class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-50">
        <button id="btn-home-back-top" class="relative w-12 h-12 md:w-14 md:h-14 bg-white/95 backdrop-blur-md rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.15)] border border-stone-200/80 flex items-center justify-center text-stone-700 hover:text-forest transition-all duration-500 focus:outline-none opacity-0 translate-y-8 pointer-events-none group cursor-pointer" title="Kembali ke Atas">
            <svg class="w-5 h-5 md:w-6 md:h-6 relative z-10 transition-transform group-hover:-translate-y-1 text-stone-700 group-hover:text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
            <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none" viewBox="0 0 36 36">
                <path class="text-stone-100" stroke-width="2.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path id="home-scroll-progress-ring" class="text-forest transition-all duration-150" stroke-dasharray="0, 100" stroke-width="2.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
            </svg>
        </button>
    </div>

</x-layouts.app>
