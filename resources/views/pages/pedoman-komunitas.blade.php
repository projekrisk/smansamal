@push('styles')
<style>
    .guideline-prose p,
    .guideline-prose li {
        font-size: 18px !important;
        line-height: 1.85 !important;
    }
</style>
@endpush

<x-layouts.app
    title="Pedoman Komunitas - SMAN 1 Malingping"
    description="Standar etika literasi, aturan penulisan artikel, pedoman berkomentar, dan batasan konten demi ekosistem digital SMAN 1 Malingping yang bermartabat."
    type="article">

    <main class="flex-grow pt-32 pb-20 px-6 font-sans">
        <article class="w-full max-w-[820px] mx-auto">

            <div class="flex flex-col items-center text-center mb-8">
                <div class="flex items-center gap-3 mb-5">
                    <a href="{{ route('home') }}" class="font-sans text-sm text-stone-500 hover:text-stone-900 transition-colors">Beranda</a>
                    <span class="text-stone-400 text-xs">/</span>
                    <a href="{{ route('suara-warga.index') }}" class="font-sans text-sm text-stone-500 hover:text-stone-900 transition-colors">Suara Warga</a>
                    <span class="text-stone-400 text-xs">/</span>
                    <span class="font-sans text-[11px] font-bold text-forest uppercase tracking-widest">Pedoman Komunitas</span>
                </div>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-forest/10 text-forest text-xs font-bold mb-4 uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Standar Etika & Nilai Literasi Sekolah</span>
                </div>

                <h1 class="font-serif text-4xl md:text-5xl text-stone-900 leading-tight md:leading-snug mb-5 max-w-3xl">
                    Pedoman Komunitas & Etika Publikasi
                </h1>

                <p class="font-sans text-stone-600 text-[18px] max-w-2xl leading-relaxed">
                    Menjaga ruang publikasi SMAN 1 Malingping tetap kritis, inspiratif, santun, dan aman bagi seluruh siswa, guru, alumni, serta masyarakat luas.
                </p>
            </div>

            <div class="w-full h-px bg-stone-200/80 mb-8"></div>

            <div class="my-8 p-6 md:p-8 rounded-3xl bg-forest/5 border border-forest/20 text-stone-800">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-forest text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <h3 class="font-serif text-xl font-bold text-stone-900 mb-2">Prinsip Pokok Penulisan Warga Sekolah</h3>
                        <p class="text-[17px] leading-relaxed text-stone-700">
                            Setiap kata yang dipublikasikan adalah cerminan dari karakter dan martabat civitas akademika SMAN 1 Malingping. Kami merayakan kebebasan berpikir dan gagasan kritis yang disampaikan dengan <strong>keberadaban, data yang akurat, serta rasa tanggung jawab sosial.</strong>
                        </p>
                    </div>
                </div>
            </div>

            <div class="prose guideline-prose font-sans text-stone-800 text-[18px] max-w-none">

                <h2>1. Nilai Dasar Komunitas</h2>
                <p>
                    Portal SMAN 1 Malingping, khususnya rubrik <strong>Suara Warga</strong>, <strong>Jurnal Sekolah</strong>, dan kolom <strong>Diskusi Komentar</strong> dibangun atas landasan:
                </p>
                <ul>
                    <li><strong>Integritas Akademik:</strong> Menjunjung tinggi kejujuran intelektual, orisinalitas karya, dan menolak segala bentuk penjiplakan.</li>
                    <li><strong>Kearifan Berbahasa:</strong> Menggunakan bahasa Indonesia yang baik, efektif, santun, serta menghargai martabat manusia.</li>
                    <li><strong>Tenggang Rasa & Keberagaman:</strong> Menghormati perbedaan pendapat, sudut pandang budaya, suku, dan agama.</li>
                    <li><strong>Fokus Solutif & Mendidik:</strong> Tulisan diarahkan untuk mengedukasi, menginspirasi, atau memberikan kritik konstruktif untuk kemajuan bersama.</li>
                </ul>

                <h2>2. Konten yang Dilarang Keras (Toleransi Nol)</h2>
                <p>
                    Segala bentuk artikel, takarir (caption), nama pena, gambar ilustrasi, atau komentar yang memuat unsur berikut <strong>dilarang keras dan akan langsung ditindak</strong>:
                </p>

                <div class="not-prose grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
                    <div class="p-4 rounded-2xl bg-rose-50/60 border border-rose-200">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="text-rose-600 text-lg">🚫</span>
                            <h4 class="font-serif font-bold text-stone-900 text-base">Ujaran Kebencian & SARA</h4>
                        </div>
                        <p class="text-sm text-stone-600 leading-relaxed">
                            Penghinaan, provokasi, atau diskriminasi terhadap suku, agama, ras, gender, kondisi fisik, maupun antargolongan.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-rose-50/60 border border-rose-200">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="text-rose-600 text-lg">⚠️</span>
                            <h4 class="font-serif font-bold text-stone-900 text-base">Perundungan & Pencemaran Nama Baik</h4>
                        </div>
                        <p class="text-sm text-stone-600 leading-relaxed">
                            Serangan personal, perundungan siber (*cyberbullying*), doxxing (menyebar data pribadi tanpa izin), dan fitnah.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-rose-50/60 border border-rose-200">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="text-rose-600 text-lg">❌</span>
                            <h4 class="font-serif font-bold text-stone-900 text-base">Konten Tidak Pantas & Asusila</h4>
                        </div>
                        <p class="text-sm text-stone-600 leading-relaxed">
                            Materi pornografi, kekerasan eksplisit, konten yang merendahkan nilai moral dan norma lingkungan pendidikan.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-rose-50/60 border border-rose-200">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="text-rose-600 text-lg">🛑</span>
                            <h4 class="font-serif font-bold text-stone-900 text-base">Hoaks & Plagiarisme</h4>
                        </div>
                        <p class="text-sm text-stone-600 leading-relaxed">
                            Menyebarkan informasi bohong, mencatut karya orang lain tanpa atribusi sumber resmi, atau pelanggaran hak cipta.
                        </p>
                    </div>
                </div>

                <h2>3. Etika Ruang Diskusi & Komentar</h2>
                <p>
                    Kolom diskusi di bawah setiap artikel disediakan sebagai ruang temu pemikiran yang dinamis. Pengguna diharapkan:
                </p>
                <ul>
                    <li>Mengkritisi pokok gagasan atau argumen artikel, <strong>bukan menyerang pribadi penulis</strong>.</li>
                    <li>Menghindari penggunaan kata-kata kasar, makian, huruf kapital berlebih (*shouting*), atau spam tautan promosi.</li>
                    <li>Memberikan tanggapan yang relevan dengan topik bahasan artikel.</li>
                </ul>

                <h2>4. Sistem Pelaporan Konten</h2>
                <p>
                    Setiap pembaca dan warga sekolah dapat berpartisipasi menjaga kualitas konten melalui fitur <strong>Laporkan Artikel</strong> (dapat diakses melalui tombol menu titik tiga <span class="px-2 py-0.5 rounded bg-stone-100 border text-xs font-mono">&bull;&bull;&bull;</span> pada setiap halaman artikel). Laporan yang masuk akan ditinjau secara rahasia dan independen oleh tim moderator sekolah.
                </p>

                <h2>5. Tindakan & Konsekuensi Pelanggaran</h2>
                <p>
                    Berdasarkan tingkat keparahan pelanggaran, pihak sekolah dan tim pengelola berhak mengambil tindakan berupa:
                </p>
                <ol>
                    <li><strong>Pemberitahuan & Permintaan Revisi:</strong> Penulis diminta memperbaiki bagian yang tidak sesuai.</li>
                    <li><strong>Penarikan Artikel (*Take-down*):</strong> Mengubah status artikel dari *published* menjadi *draft* sehingga tidak lagi tayang publik.</li>
                    <li><strong>Penghapusan Konten:</strong> Konten atau komentar melanggar dihapus secara permanen dari basis data.</li>
                    <li><strong>Penonaktifan Akun (*Suspension*):</strong> Penonaktifan sementara atau pembekuan akun warga secara permanen jika melakukan pelanggaran berat berulang.</li>
                </ol>

                <h2>6. Bantuan & Panduan Teknis</h2>
                <p>
                    Untuk panduan langkah demi langkah cara membuat artikel yang baik, mengunggah media gambar, dan mengatur tag karya tugas guru, silakan membaca dokumen:
                </p>
                <div class="not-prose my-6">
                    <a href="{{ route('panduan-suara-warga') }}" class="flex items-center justify-between p-4 rounded-2xl bg-stone-100/80 hover:bg-forest hover:text-white transition-all duration-300 group border border-stone-200">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📖</span>
                            <div>
                                <h4 class="font-serif font-bold text-base text-stone-900 group-hover:text-white transition-colors">Buka Panduan Lengkap Suara Warga</h4>
                                <p class="text-xs text-stone-500 group-hover:text-stone-200 transition-colors">Tutorial penulisan, upload gambar, pemilihan tag tugas, dan moderasi komentar.</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-stone-400 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <div class="mt-14 pt-6 border-t border-stone-200/70 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-sans text-stone-500">
                <p>&copy; {{ date('Y') }} SMAN 1 Malingping &bull; Pedoman Komunitas Resmi</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('panduan-suara-warga') }}" class="font-semibold text-stone-700 hover:text-forest transition-colors">Panduan Penulisan &rarr;</a>
                    <a href="{{ route('home') }}" class="font-semibold text-forest hover:text-terracotta transition-colors flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

        </article>
    </main>
</x-layouts.app>
