<x-layouts.app
    :title="($page?->title ?? 'Kontak') . ' - SMAN 1 Malingping'"
    :description="$page?->meta_description ?? 'Informasi kontak resmi SMA Negeri 1 Malingping: alamat kampus, surel resmi, jam pelayanan tata usaha, dan panduan kunjungan tamu.'"
    type="article">

    <main class="flex-grow pt-28 md:pt-32 pb-20 px-4 sm:px-6">
        <div class="w-full max-w-6xl mx-auto">

            <div class="flex flex-col items-center text-center mb-8 md:mb-10">
                <div class="flex items-center gap-2.5 mb-4 text-xs font-sans">
                    <a href="{{ route('home') }}" class="text-stone-500 hover:text-stone-900 transition-colors">Beranda</a>
                    <span class="text-stone-400">/</span>
                    <span class="text-forest font-semibold">Kontak & Layanan</span>
                </div>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-forest/10 text-forest text-xs font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-forest"></span>
                    Informasi & Komunikasi Resmi
                </div>

                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl text-stone-900 leading-tight font-bold mb-4 max-w-2xl">
                    {{ $page?->title ?? 'Kontak' }}
                </h1>

                <p class="font-sans text-stone-600 text-base sm:text-lg max-w-2xl leading-relaxed">
                    {{ $page?->meta_description ?? 'Kami menyambut baik segala pertanyaan, saran, aspirasi, dan komunikasi dari calon siswa, orang tua/wali murid, alumni, instansi mitra, serta masyarakat umum.' }}
                </p>

                @if($page)
                    <div class="flex items-center gap-3 mt-4 text-xs text-stone-400">
                        <span>Diperbarui: {{ $page->updated_at->translatedFormat('d F Y') }}</span>
                        <span>&bull;</span>
                        <span>{{ number_format($page->views_count) }} kali dilihat</span>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
                <div class="bg-white p-6 sm:p-7 rounded-2xl border border-stone-200/80 shadow-2xs hover:border-forest/40 transition-colors flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-forest/10 text-forest flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-stone-900 mb-2">Alamat Kampus</h3>
                        <p class="text-sm text-stone-600 leading-relaxed mb-5">
                            Jl. Raya Malingping - Binuangeun KM. 2, Desa Pagelaran, Kecamatan Malingping, Kabupaten Lebak, Provinsi Banten 42392.
                        </p>
                    </div>
                    <a href="https://maps.google.com/?q=SMAN+1+Malingping" target="_blank" rel="noopener noreferrer" class="text-xs sm:text-sm font-bold text-forest hover:text-stone-900 inline-flex items-center gap-1.5 transition-colors">
                        <span>Petunjuk Arah Google Maps</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <div class="bg-white p-6 sm:p-7 rounded-2xl border border-stone-200/80 shadow-2xs hover:border-forest/40 transition-colors flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-forest/10 text-forest flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-stone-900 mb-2">Surel Resmi</h3>
                        <p class="text-sm text-stone-600 leading-relaxed mb-1">
                            info@sman1malingping.sch.id
                        </p>
                        <p class="text-xs text-stone-400 leading-relaxed mb-5">
                            Untuk korespondensi kedinasan, administrasi kesiswaan, kemitraan, dan permohonan informasi resmi sekolah.
                        </p>
                    </div>
                    <a href="mailto:info@sman1malingping.sch.id" class="text-xs sm:text-sm font-bold text-forest hover:text-stone-900 inline-flex items-center gap-1.5 transition-colors">
                        <span>Kirim Pesan Surel</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <div class="bg-white p-6 sm:p-7 rounded-2xl border border-stone-200/80 shadow-2xs hover:border-forest/40 transition-colors flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-forest/10 text-forest flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-stone-900 mb-2">Jam Pelayanan</h3>
                        <p class="text-sm font-semibold text-stone-800 mb-1">
                            Senin – Jumat: 07.15 – 16.00 WIB
                        </p>
                        <p class="text-xs text-stone-400 leading-relaxed mb-5">
                            Pelayanan administrasi tata usaha dan kesiswaan tutup pada hari Sabtu, Minggu, serta hari libur nasional.
                        </p>
                    </div>
                    <div class="text-xs font-semibold text-stone-500 inline-flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span>Pelayanan Aktif Hari Kerja</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12 items-stretch">
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-stone-200/80 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3.5 mb-5">
                            <div class="w-11 h-11 rounded-xl bg-forest/10 text-forest flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h2 class="font-serif text-xl sm:text-2xl font-bold text-stone-900 leading-tight">Panduan Kunjungan Tamu</h2>
                                <p class="text-xs text-stone-500 mt-0.5">Tata tertib kehadiran di lingkungan kampus sekolah</p>
                            </div>
                        </div>

                        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed mb-5">
                            Bagi orang tua murid, alumni, instansi dinas, dan masyarakat umum yang berkunjung langsung ke kampus SMA Negeri 1 Malingping:
                        </p>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-start gap-3 p-3.5 rounded-xl bg-stone-50 border border-stone-100">
                                <span class="w-6 h-6 rounded-lg bg-forest/10 text-forest text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                                <div class="text-xs sm:text-sm text-stone-700 leading-relaxed">
                                    <strong class="text-stone-900 block font-semibold mb-0.5">Pos Keamanan Gerbang Utama</strong>
                                    Melapor kepada petugas pos keamanan di gerbang utama sekolah setibanya di kampus.
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3.5 rounded-xl bg-stone-50 border border-stone-100">
                                <span class="w-6 h-6 rounded-lg bg-forest/10 text-forest text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                                <div class="text-xs sm:text-sm text-stone-700 leading-relaxed">
                                    <strong class="text-stone-900 block font-semibold mb-0.5">Etika Berbusana Sopan</strong>
                                    Mengenakan pakaian rapi, sopan, dan bersepatu saat berada di lingkungan institusi pendidikan.
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3.5 rounded-xl bg-stone-50 border border-stone-100">
                                <span class="w-6 h-6 rounded-lg bg-forest/10 text-forest text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                                <div class="text-xs sm:text-sm text-stone-700 leading-relaxed">
                                    <strong class="text-stone-900 block font-semibold mb-0.5">Registrasi Tamu</strong>
                                    Mengisi buku tamu registrasi di loket tata usaha / lobi administrasi sekolah.
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3.5 rounded-xl bg-stone-50 border border-stone-100">
                                <span class="w-6 h-6 rounded-lg bg-forest/10 text-forest text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">4</span>
                                <div class="text-xs sm:text-sm text-stone-700 leading-relaxed">
                                    <strong class="text-stone-900 block font-semibold mb-0.5">Ruang Tunggu Pelayanan</strong>
                                    Menunggu dengan tertib di ruang tunggu pelayanan kesiswaan atau tata usaha hingga staf bertugas melayani.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-emerald-50/70 border border-emerald-100 flex items-start gap-3 text-xs text-emerald-900">
                        <svg class="w-4 h-4 text-emerald-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="leading-relaxed">
                            <strong>Lokasi Strategis:</strong> Kampus berada tepat di jalan raya provinsi Malingping – Binuangeun KM. 2, Desa Pagelaran, Kecamatan Malingping.
                        </p>
                    </div>
                </div>

                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-stone-200/80 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3.5 mb-5">
                            <div class="w-11 h-11 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                            <div>
                                <h2 class="font-serif text-xl sm:text-2xl font-bold text-stone-900 leading-tight">Informasi Terkait</h2>
                                <p class="text-xs text-stone-500 mt-0.5">Dokumen, tata kelola, dan kebijakan resmi sekolah</p>
                            </div>
                        </div>

                        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed mb-5">
                            Akses cepat menuju dokumen profil institusi, regulasi, dan pedoman resmi SMA Negeri 1 Malingping:
                        </p>

                        <div class="space-y-3 mb-6">
                            <a href="{{ route('profil-sekolah') }}" class="group flex items-center justify-between p-3.5 rounded-xl bg-stone-50 border border-stone-200/80 hover:bg-forest/5 hover:border-forest/40 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-white border border-stone-200 flex items-center justify-center text-forest group-hover:border-forest/40 transition-colors flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </span>
                                    <div>
                                        <h4 class="font-serif text-sm font-bold text-stone-900 group-hover:text-forest transition-colors">Profil Sekolah</h4>
                                        <p class="text-xs text-stone-500">Sejarah, visi misi, data pokok NPSN, dan fasilitas</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-stone-400 group-hover:text-forest group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            <a href="{{ route('terms') }}" class="group flex items-center justify-between p-3.5 rounded-xl bg-stone-50 border border-stone-200/80 hover:bg-forest/5 hover:border-forest/40 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-white border border-stone-200 flex items-center justify-center text-forest group-hover:border-forest/40 transition-colors flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </span>
                                    <div>
                                        <h4 class="font-serif text-sm font-bold text-stone-900 group-hover:text-forest transition-colors">Syarat & Ketentuan</h4>
                                        <p class="text-xs text-stone-500">Etika kepenulisan warta dan validasi akun warga</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-stone-400 group-hover:text-forest group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            <a href="{{ route('privacy') }}" class="group flex items-center justify-between p-3.5 rounded-xl bg-stone-50 border border-stone-200/80 hover:bg-forest/5 hover:border-forest/40 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-white border border-stone-200 flex items-center justify-center text-forest group-hover:border-forest/40 transition-colors flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </span>
                                    <div>
                                        <h4 class="font-serif text-sm font-bold text-stone-900 group-hover:text-forest transition-colors">Kebijakan Privasi</h4>
                                        <p class="text-xs text-stone-500">Komitmen perlindungan dan kerahasiaan data pribadi</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-stone-400 group-hover:text-forest group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            <a href="{{ route('pedoman-komunitas') }}" class="group flex items-center justify-between p-3.5 rounded-xl bg-stone-50 border border-stone-200/80 hover:bg-forest/5 hover:border-forest/40 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-white border border-stone-200 flex items-center justify-center text-forest group-hover:border-forest/40 transition-colors flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </span>
                                    <div>
                                        <h4 class="font-serif text-sm font-bold text-stone-900 group-hover:text-forest transition-colors">Pedoman Komunitas</h4>
                                        <p class="text-xs text-stone-500">Nilai dasar interaksi sehat dan literasi santun warga</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-stone-400 group-hover:text-forest group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-stone-50 border border-stone-200/80 flex items-start gap-3 text-xs text-stone-600">
                        <svg class="w-4 h-4 text-forest flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="leading-relaxed">
                            Pertanyaan dan komunikasi resmi dapat dikirim melalui surel <strong>info@sman1malingping.sch.id</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-stone-200 flex flex-wrap items-center justify-between gap-4 text-xs font-sans text-stone-500">
                <p>&copy; {{ date('Y') }} SMAN 1 Malingping &bull; Layanan Informasi Publik Resmi</p>
                <a href="{{ route('home') }}" class="font-semibold text-forest hover:text-stone-900 transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

        </div>
    </main>
</x-layouts.app>
