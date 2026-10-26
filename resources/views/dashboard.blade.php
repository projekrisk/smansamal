<x-layouts.warga title="Dasbor Warga - SMAN 1 Malingping" headerTitle="Ringkasan Dasbor">

    @if(!$user->is_active)
        <div class="mb-5 p-4 sm:p-5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 font-sans flex items-start gap-3.5 shadow-2xs">
            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div>
                <h4 class="font-bold text-sm text-amber-900 mb-0.5">Akun Anda Dalam Tahap Aktivasi</h4>
                <p class="text-sm text-amber-800 leading-relaxed">
                    Sesuai ketentuan portal literasi SMAN 1 Malingping, akun baru memerlukan verifikasi data dari pengelola sekolah sebelum Anda dapat menerbitkan tulisan ke publik. Anda tetap dapat menyimpan draf artikel terlebih dahulu.
                </p>
            </div>
        </div>
    @endif

    <div class="bg-forest rounded-2xl p-6 sm:p-7 text-white relative overflow-hidden mb-6 flex flex-col md:flex-row items-center justify-between gap-5 shadow-xs">

        <svg class="absolute -bottom-14 -right-8 w-56 h-56 text-white/5 pointer-events-none" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>

        <div class="relative z-10 text-center md:text-left">
            <h1 class="font-serif text-2xl sm:text-3xl font-bold mb-1.5">Halo, {{ Str::before($user->name, ' ') }}!</h1>
            <p class="font-sans text-stone-200 text-sm max-w-xl leading-relaxed">Mari bagikan pengalaman dan opini Anda hari ini. Suara Anda berkontribusi dalam membangun literasi digital warga sekolah.</p>
        </div>

        <div class="relative z-10 flex-shrink-0">
            <a href="{{ route('warga.articles.create') }}" class="bg-white text-forest px-5 py-2.5 rounded-xl font-sans text-sm font-bold shadow-xs hover:bg-stone-100 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Tulis Artikel Baru</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        <div class="bg-white p-4 sm:p-5 rounded-xl border border-stone-200 shadow-2xs relative overflow-hidden group hover:border-forest transition-colors">
            <svg class="absolute -right-3 -bottom-3 w-24 h-24 text-forest/5 group-hover:text-forest/10 transition-colors pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <div class="relative z-10">
                <p class="font-sans text-sm font-bold text-stone-500 tracking-wider mb-1">Total Karya</p>
                <h3 class="font-serif text-3xl font-bold text-stone-900 leading-none">{{ $totalArticles }}</h3>
                <p class="font-sans text-sm text-stone-500 mt-1.5">Artikel & Suara Warga</p>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-xl border border-stone-200 shadow-2xs relative overflow-hidden group hover:border-terracotta transition-colors">
            <svg class="absolute -right-3 -bottom-3 w-24 h-24 text-terracotta/5 group-hover:text-terracotta/10 transition-colors pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            <div class="relative z-10">
                <p class="font-sans text-sm font-bold text-stone-500 tracking-wider mb-1">Total Apresiasi</p>
                <h3 class="font-serif text-3xl font-bold text-stone-900 leading-none">
                    {{ $totalLikes >= 1000 ? number_format($totalLikes / 1000, 1) . 'k' : $totalLikes }}
                </h3>
                <p class="font-sans text-sm text-stone-500 mt-1.5">Suka dari Pembaca</p>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-xl border border-stone-200 shadow-2xs relative overflow-hidden group hover:border-stone-400 transition-colors">
            <svg class="absolute -right-3 -bottom-3 w-24 h-24 text-stone-300/30 group-hover:text-stone-300/60 transition-colors pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            <div class="relative z-10">
                <p class="font-sans text-sm font-bold text-stone-500 tracking-wider mb-1">Komentar Masuk</p>
                <h3 class="font-serif text-3xl font-bold text-stone-900 leading-none">{{ $totalComments }}</h3>
                <p class="font-sans text-sm text-stone-500 mt-1.5">Tanggapan Diskusi</p>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <div class="flex items-center justify-between mb-3.5">
            <div>
                <h2 class="font-serif text-lg text-stone-900 font-bold">Panduan & Pedoman Literasi Warga</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs hover:shadow-xs transition-all overflow-hidden flex flex-col group">
                <div class="p-5 sm:p-6 flex-1 flex flex-col">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[11px] uppercase font-bold tracking-wider bg-forest/10 text-forest border border-forest/15">
                            Panduan Teknis
                        </span>
                    </div>

                    <h3 class="font-serif text-lg font-bold text-stone-900 group-hover:text-forest transition-colors mb-2">
                        Panduan Menulis & Publikasi Suara Warga
                    </h3>

                    <p class="font-sans text-xs text-stone-600 leading-relaxed mb-4">
                        Petunjuk praktis bagi siswa, guru, dan alumni dalam menulis karya naskah, mengunggah banner gambar, pengelompokan tag tugas guru, dan pengelolaan diskusi komentar.
                    </p>

                    <div class="space-y-2 text-xs font-sans text-stone-600 mb-5 bg-stone-50/80 p-3.5 rounded-xl border border-stone-100 mt-auto">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-forest text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">1</span>
                            <span>Cara membuat naskah artikel, judul memikat, dan ringkasan excerpt.</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-forest text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">2</span>
                            <span>Format gambar cover 16:9, takarir (caption), dan hak atribusi foto.</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-forest text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">3</span>
                            <span>Pemilihan rubrik kategori dan pemberian label tag tugas kelas (<code class="text-[10px] bg-stone-200/70 px-1 py-0.5 rounded text-stone-800">#TagTugas</code>).</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-forest text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">4</span>
                            <span>Alur peninjauan (review) redaksi sekolah hingga artikel terbit ke publik.</span>
                        </div>
                    </div>

                    <a href="{{ route('panduan-suara-warga') }}" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-forest hover:bg-forest/90 text-white font-sans text-xs font-bold text-center inline-flex items-center justify-center gap-2 transition-all shadow-2xs">
                        <span>Buka Buku Panduan Menulis</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs hover:shadow-xs transition-all overflow-hidden flex flex-col group">
                <div class="p-5 sm:p-6 flex-1 flex flex-col">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-terracotta/10 text-terracotta flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[11px] uppercase font-bold tracking-wider bg-terracotta/10 text-terracotta border border-terracotta/15">
                            Etika & Regulasi
                        </span>
                    </div>

                    <h3 class="font-serif text-lg font-bold text-stone-900 group-hover:text-terracotta transition-colors mb-2">
                        Pedoman Komunitas & Etika Berpendapat
                    </h3>

                    <p class="font-sans text-xs text-stone-600 leading-relaxed mb-4">
                        Aturan dan etika yang mengikat seluruh civitas akademika SMAN 1 Malingping untuk menjaga iklim literasi yang mendidik, santun, ilmiah, dan beradab.
                    </p>

                    <div class="space-y-2 text-xs font-sans text-stone-600 mb-5 bg-stone-50/80 p-3.5 rounded-xl border border-stone-100 mt-auto">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-terracotta text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">✓</span>
                            <span>Berlandaskan 4 Pilar Sekolah: <strong>Cageur, Bageur, Bener, Pinter</strong>.</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-terracotta text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">✓</span>
                            <span>Larangan plagiarisme, kutipan ilegal, & wajib mencantumkan sumber asli.</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-terracotta text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">✓</span>
                            <span>Nol toleransi terhadap ujaran kebencian, SARA, pelecehan, dan perundungan.</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-terracotta text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">✓</span>
                            <span>Pencegahan informasi palsu (hoaks) dan ketentuan sanksi moderasi redaksi.</span>
                        </div>
                    </div>

                    <a href="{{ route('pedoman-komunitas') }}" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-terracotta hover:bg-terracotta/90 text-white font-sans text-xs font-bold text-center inline-flex items-center justify-center gap-2 transition-all shadow-2xs">
                        <span>Baca Seluruh Pedoman Komunitas</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="border-t border-stone-200/60 pt-4 mt-auto pb-4 flex flex-col md:flex-row items-center justify-between gap-3 font-sans text-sm text-stone-500">
        <p>&copy; {{ date('Y') }} SMAN 1 Malingping. Internal System.</p>
        <div class="flex gap-4">
            <a href="{{ route('home') }}" class="hover:text-stone-800 transition-colors">Portal Utama</a>
            <a href="mailto:admin@sman1malingping.sch.id" class="hover:text-stone-800 transition-colors">Bantuan / Kontak</a>
        </div>
    </footer>

</x-layouts.warga>
