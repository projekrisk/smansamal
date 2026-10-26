@push('styles')
<style>
    html {
        scroll-behavior: smooth;
    }
    .guide-step-card {
        scroll-margin-top: 5.5rem;
    }
    @media (min-width: 768px) {
        .guide-step-card {
            scroll-margin-top: 7rem;
        }
    }
</style>
@endpush

<x-layouts.app
    title="Panduan Penggunaan Suara Warga - SMAN 1 Malingping"
    description="Panduan lengkap bagi siswa, guru, dan alumni dalam menulis karya, mengunggah foto, memilih tag tugas, dan berinteraksi di Suara Warga SMAN 1 Malingping."
    type="article">

    <main class="flex-grow pt-28 sm:pt-32 pb-20 px-4 sm:px-6 font-sans">
        <div class="w-full max-w-6xl mx-auto">

            <div class="flex flex-col items-center text-center mb-8 sm:mb-12">
                <div class="flex items-center gap-2 sm:gap-3 mb-4 text-xs sm:text-sm">
                    <a href="{{ route('home') }}" class="font-sans text-stone-500 hover:text-stone-900 transition-colors">Beranda</a>
                    <span class="text-stone-400">/</span>
                    <a href="{{ route('suara-warga.index') }}" class="font-sans text-stone-500 hover:text-stone-900 transition-colors">Suara Warga</a>
                    <span class="text-stone-400">/</span>
                    <span class="font-sans text-[11px] font-bold text-terracotta uppercase tracking-widest">Buku Panduan</span>
                </div>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-forest/10 text-forest text-xs font-bold mb-4 uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>Petunjuk Teknis Resmi</span>
                </div>

                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl text-stone-900 leading-tight md:leading-snug mb-4 max-w-3xl">
                    Panduan Penggunaan Kanal Suara Warga
                </h1>

                <p class="font-sans text-stone-600 text-sm sm:text-base md:text-lg max-w-2xl leading-relaxed">
                    Pelajari langkah demi langkah menulis karya, mengunggah media, mengelompokkan tag tugas guru, serta mengelola diskusi komentar di portal literasi SMAN 1 Malingping.
                </p>
            </div>

            <div
                x-data="{ mobileMenuOpen: false }"
                class="lg:hidden sticky top-16 sm:top-20 z-40 -mx-4 sm:-mx-6 mb-8 px-4 sm:px-6 py-2.5 bg-white/95 backdrop-blur-md border-y border-stone-200/90 shadow-2xs font-sans"
            >
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-1.5 text-xs font-bold text-stone-700 flex-shrink-0">
                        <svg class="w-4 h-4 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        <span>Lompat Cepat:</span>
                    </div>

                    <div class="flex-1 overflow-x-auto no-scrollbar flex items-center gap-1.5 py-0.5 px-1">
                        <a href="#langkah-1" class="px-2.5 py-1 rounded-full bg-stone-100 hover:bg-forest hover:text-white text-stone-700 text-xs font-semibold whitespace-nowrap transition-colors flex-shrink-0">
                            1. Buat Akun
                        </a>
                        <a href="#langkah-2" class="px-2.5 py-1 rounded-full bg-stone-100 hover:bg-forest hover:text-white text-stone-700 text-xs font-semibold whitespace-nowrap transition-colors flex-shrink-0">
                            2. Tulis Naskah
                        </a>
                        <a href="#langkah-3" class="px-2.5 py-1 rounded-full bg-stone-100 hover:bg-forest hover:text-white text-stone-700 text-xs font-semibold whitespace-nowrap transition-colors flex-shrink-0">
                            3. Foto & Banner
                        </a>
                        <a href="#langkah-4" class="px-2.5 py-1 rounded-full bg-stone-100 hover:bg-forest hover:text-white text-stone-700 text-xs font-semibold whitespace-nowrap transition-colors flex-shrink-0">
                            4. Kategori & Tag
                        </a>
                        <a href="#langkah-5" class="px-2.5 py-1 rounded-full bg-stone-100 hover:bg-forest hover:text-white text-stone-700 text-xs font-semibold whitespace-nowrap transition-colors flex-shrink-0">
                            5. Publikasi
                        </a>
                        <a href="#langkah-6" class="px-2.5 py-1 rounded-full bg-stone-100 hover:bg-forest hover:text-white text-stone-700 text-xs font-semibold whitespace-nowrap transition-colors flex-shrink-0">
                            6. Moderasi
                        </a>
                    </div>

                    <button
                        type="button"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-1.5 rounded-lg text-stone-500 hover:text-stone-900 hover:bg-stone-100 flex-shrink-0 transition-colors"
                        title="Daftar Lengkap"
                        aria-label="Daftar Isi Lengkap"
                    >
                        <svg class="w-4 h-4 transition-transform duration-200" :class="mobileMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                </div>

                <div
                    x-show="mobileMenuOpen"
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    @click.outside="mobileMenuOpen = false"
                    class="mt-2.5 pt-2.5 border-t border-stone-200 grid grid-cols-1 gap-1.5 text-xs"
                >
                    <a href="#langkah-1" @click="mobileMenuOpen = false" class="p-2 rounded-lg bg-stone-50 hover:bg-forest/10 hover:text-forest flex items-center justify-between font-medium">
                        <span>Langkah 1: Membuat Akun & Verifikasi</span>
                        <span class="text-stone-400">→</span>
                    </a>
                    <a href="#langkah-2" @click="mobileMenuOpen = false" class="p-2 rounded-lg bg-stone-50 hover:bg-forest/10 hover:text-forest flex items-center justify-between font-medium">
                        <span>Langkah 2: Menulis Naskah Artikel</span>
                        <span class="text-stone-400">→</span>
                    </a>
                    <a href="#langkah-3" @click="mobileMenuOpen = false" class="p-2 rounded-lg bg-stone-50 hover:bg-forest/10 hover:text-forest flex items-center justify-between font-medium">
                        <span>Langkah 3: Unggah Gambar & Banner</span>
                        <span class="text-stone-400">→</span>
                    </a>
                    <a href="#langkah-4" @click="mobileMenuOpen = false" class="p-2 rounded-lg bg-stone-50 hover:bg-forest/10 hover:text-forest flex items-center justify-between font-medium">
                        <span>Langkah 4: Kategori & Tag Tugas Guru</span>
                        <span class="text-stone-400">→</span>
                    </a>
                    <a href="#langkah-5" @click="mobileMenuOpen = false" class="p-2 rounded-lg bg-stone-50 hover:bg-forest/10 hover:text-forest flex items-center justify-between font-medium">
                        <span>Langkah 5: Menyimpan Draft vs Publikasi</span>
                        <span class="text-stone-400">→</span>
                    </a>
                    <a href="#langkah-6" @click="mobileMenuOpen = false" class="p-2 rounded-lg bg-stone-50 hover:bg-forest/10 hover:text-forest flex items-center justify-between font-medium">
                        <span>Langkah 6: Mengelola Diskusi Komentar</span>
                        <span class="text-stone-400">→</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <div class="lg:col-span-8 space-y-10 sm:space-y-12">

                    <section id="langkah-1" class="guide-step-card p-6 sm:p-8 rounded-3xl bg-white border border-stone-200/90 shadow-xs">
                        <div class="flex items-center gap-3.5 mb-5">
                            <span class="w-10 h-10 rounded-2xl bg-forest text-white font-bold flex items-center justify-center text-sm shadow-2xs flex-shrink-0">01</span>
                            <div>
                                <span class="text-[11px] uppercase font-bold text-forest tracking-wider block">Langkah Awal</span>
                                <h2 class="font-serif text-xl sm:text-2xl font-bold text-stone-900 leading-tight">Membuat Akun & Verifikasi Identitas</h2>
                            </div>
                        </div>
                        <div class="text-sm sm:text-base text-stone-700 leading-relaxed space-y-3.5">
                            <p>
                                Untuk dapat menulis karya di <em>Suara Warga</em>, Anda harus terdaftar sebagai bagian dari civitas akademika SMAN 1 Malingping:
                            </p>
                            <ul class="list-disc pl-5 space-y-2 text-stone-600 text-xs sm:text-sm">
                                <li><strong>Siswa Aktif:</strong> Masukkan NISN valid dan pilih kelas Anda saat pendaftaran. Akun akan dicek oleh wali kelas atau bagian kesiswaan.</li>
                                <li><strong>Dewan Guru:</strong> Lengkapi NIP dan mata pelajaran pengampu agar mendapatkan lencana resmi pendidik.</li>
                                <li><strong>Alumni:</strong> Cantumkan tahun kelulusan Anda dari SMAN 1 Malingping untuk bergabung dalam jejaring literasi alumni.</li>
                                <li><strong>Verifikasi Email:</strong> Buka tautan verifikasi yang dikirimkan ke kotak masuk surel Anda untuk mengaktifkan akun.</li>
                            </ul>
                        </div>
                    </section>

                    <section id="langkah-2" class="guide-step-card p-6 sm:p-8 rounded-3xl bg-white border border-stone-200/90 shadow-xs">
                        <div class="flex items-center gap-3.5 mb-5">
                            <span class="w-10 h-10 rounded-2xl bg-forest text-white font-bold flex items-center justify-center text-sm shadow-2xs flex-shrink-0">02</span>
                            <div>
                                <span class="text-[11px] uppercase font-bold text-forest tracking-wider block">Kepenulisan</span>
                                <h2 class="font-serif text-xl sm:text-2xl font-bold text-stone-900 leading-tight">Menulis Naskah Artikel yang Berkualitas</h2>
                            </div>
                        </div>
                        <div class="text-sm sm:text-base text-stone-700 leading-relaxed space-y-3.5">
                            <p>
                                Masuk ke Dasbor Warga lalu klik menu <strong>"Tulis Artikel Baru"</strong> (<code class="text-xs bg-stone-100 px-2 py-0.5 rounded text-stone-800">/warga/articles/create</code>).
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 my-4 text-xs">
                                <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200">
                                    <h4 class="font-bold text-stone-900 mb-1">1. Judul Artikel</h4>
                                    <p class="text-stone-600">Buat judul yang ringkas, menarik, serta mencerminkan gagasan utama naskah tulisan.</p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200">
                                    <h4 class="font-bold text-stone-900 mb-1">2. Kutipan (Excerpt)</h4>
                                    <p class="text-stone-600">Tuliskan 1-2 kalimat rangkuman isi artikel untuk tampil di kartu preview feed berita.</p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200">
                                    <h4 class="font-bold text-stone-900 mb-1">3. Isi Tulisan (Rich Text)</h4>
                                    <p class="text-stone-600">Gunakan heading, penomoran, kutipan blockquote, dan paragraf terstruktur.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="langkah-3" class="guide-step-card p-6 sm:p-8 rounded-3xl bg-white border border-stone-200/90 shadow-xs">
                        <div class="flex items-center gap-3.5 mb-5">
                            <span class="w-10 h-10 rounded-2xl bg-forest text-white font-bold flex items-center justify-center text-sm shadow-2xs flex-shrink-0">03</span>
                            <div>
                                <span class="text-[11px] uppercase font-bold text-forest tracking-wider block">Visual & Media</span>
                                <h2 class="font-serif text-xl sm:text-2xl font-bold text-stone-900 leading-tight">Unggah Gambar, Banner & Takarir (Caption)</h2>
                            </div>
                        </div>
                        <div class="text-sm sm:text-base text-stone-700 leading-relaxed space-y-3.5">
                            <p>
                                Foto ilustrasi yang menarik meningkatkan daya tarik pembaca hingga 300%. Perhatikan panduan berikut:
                            </p>
                            <ul class="list-disc pl-5 space-y-2 text-stone-600 text-xs sm:text-sm">
                                <li><strong>Ukuran & Format:</strong> Disarankan menggunakan format <code>.WebP</code>, <code>.JPG</code>, atau <code>.PNG</code> dengan ukuran maksimal 2MB dan rasio lanskap 16:9.</li>
                                <li><strong>Mode Banner Gambar:</strong> Anda dapat memilih tampilan gambar penuh (full-width banner) atau gambar standar di awal artikel.</li>
                                <li><strong>Takarir Gambar (Caption):</strong> Selalu tuliskan takarir singkat untuk menerangkan objek foto serta mencantumkan atribusi fotografer atau sumber resmi (contoh: <em>"Dokumentasi Kegiatan P5 Kelas XII / Foto: OSIS SMAN 1 Malingping"</em>).</li>
                            </ul>
                        </div>
                    </section>

                    <section id="langkah-4" class="guide-step-card p-6 sm:p-8 rounded-3xl bg-white border border-stone-200/90 shadow-xs">
                        <div class="flex items-center gap-3.5 mb-5">
                            <span class="w-10 h-10 rounded-2xl bg-terracotta text-white font-bold flex items-center justify-center text-sm shadow-2xs flex-shrink-0">04</span>
                            <div>
                                <span class="text-[11px] uppercase font-bold text-terracotta tracking-wider block">Klasifikasi & Penugasan Guru</span>
                                <h2 class="font-serif text-xl sm:text-2xl font-bold text-stone-900 leading-tight">Memilih Kategori dan Memberikan Tag (#Tag)</h2>
                            </div>
                        </div>
                        <div class="text-sm sm:text-base text-stone-700 leading-relaxed space-y-4">
                            <p>
                                Kategori dan tag membantu pembaca menemukan karya Anda, serta mempermudah guru memeriksa tugas karya siswa:
                            </p>
                            <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200 space-y-2 text-xs sm:text-sm">
                                <h4 class="font-bold text-stone-900">📌 Kategori Rubrik:</h4>
                                <p class="text-stone-600">Pilih kategori yang sesuai, misalnya <strong>Opini Siswa</strong>, <strong>Karya Sastra & Puisi</strong>, <strong>Gagasan Guru</strong>, atau <strong>Inspirasi Alumni</strong>.</p>
                            </div>

                            <div class="p-4 rounded-2xl bg-terracotta/5 border border-terracotta/20 space-y-2 text-xs sm:text-sm">
                                <h4 class="font-bold text-terracotta">🏷️ Tag Khusus Tugas Guru & Label Karya:</h4>
                                <p class="text-stone-700 leading-relaxed">
                                    Guru yang memberikan tugas penulisan dapat menginstruksikan siswa menambahkan tag tertentu, misalnya: <code>#TugasBindoPakBudi</code>, <code>#ResensiBukuXII</code>, atau <code>#ProjekP5Kewirausahaan</code>.
                                </p>
                                <p class="text-xs text-stone-500 italic">
                                    *Tips: Di halaman Suara Warga, guru dan siswa dapat mengklik ikon pencarian dan mencari berdasarkan kata kunci atau tag untuk melihat seluruh tugas kelas yang terkumpul dalam satu halaman!
                                </p>
                            </div>
                        </div>
                    </section>

                    <section id="langkah-5" class="guide-step-card p-6 sm:p-8 rounded-3xl bg-white border border-stone-200/90 shadow-xs">
                        <div class="flex items-center gap-3.5 mb-5">
                            <span class="w-10 h-10 rounded-2xl bg-forest text-white font-bold flex items-center justify-center text-sm shadow-2xs flex-shrink-0">05</span>
                            <div>
                                <span class="text-[11px] uppercase font-bold text-forest tracking-wider block">Penerbitan</span>
                                <h2 class="font-serif text-xl sm:text-2xl font-bold text-stone-900 leading-tight">Menyimpan Draft vs Mengajukan Review</h2>
                            </div>
                        </div>
                        <div class="text-sm sm:text-base text-stone-700 leading-relaxed space-y-3.5">
                            <p>
                                Saat menulis, Anda memiliki dua pilihan penyimpanan:
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs my-3">
                                <div class="p-4 rounded-xl bg-stone-50 border border-stone-200">
                                    <span class="bg-stone-200 text-stone-800 font-bold px-2 py-0.5 rounded text-[10px] uppercase">Simpan Draft</span>
                                    <p class="text-stone-600 mt-2 leading-relaxed">
                                        Naskah hanya tersimpan di akun Anda dan belum terlihat oleh umum atau tim kurator. Anda dapat melanjutkan penulisan kapan saja.
                                    </p>
                                </div>
                                <div class="p-4 rounded-xl bg-forest/5 border border-forest/20">
                                    <span class="bg-forest text-white font-bold px-2 py-0.5 rounded text-[10px] uppercase">Ajukan Publikasi (Review)</span>
                                    <p class="text-stone-700 mt-2 leading-relaxed">
                                        Naskah dikirim ke tim redaksi sekolah untuk diverifikasi kesesuaiannya dengan <a href="{{ route('pedoman-komunitas') }}" class="text-forest underline font-bold">Pedoman Komunitas</a>. Setelah disetujui, artikel otomatis tayang di Suara Warga.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="langkah-6" class="guide-step-card p-6 sm:p-8 rounded-3xl bg-white border border-stone-200/90 shadow-xs">
                        <div class="flex items-center gap-3.5 mb-5">
                            <span class="w-10 h-10 rounded-2xl bg-forest text-white font-bold flex items-center justify-center text-sm shadow-2xs flex-shrink-0">06</span>
                            <div>
                                <span class="text-[11px] uppercase font-bold text-forest tracking-wider block">Diskusi & Interaksi</span>
                                <h2 class="font-serif text-xl sm:text-2xl font-bold text-stone-900 leading-tight">Mengelola dan Memoderasi Komentar</h2>
                            </div>
                        </div>
                        <div class="text-sm sm:text-base text-stone-700 leading-relaxed space-y-3.5">
                            <p>
                                Sebagai penulis, Anda memiliki otoritas untuk menjaga suasana ruang diskusi di bawah tulisan Anda:
                            </p>
                            <ul class="list-disc pl-5 space-y-2 text-stone-600 text-xs sm:text-sm">
                                <li><strong>Notifikasi Real-time:</strong> Setiap kali ada pembaca yang memberikan tanggapan atau membalas komentar, lonceng notifikasi di dasbor Anda akan berbunyi dan memberi tautan langsung ke komentar terkait.</li>
                                <li><strong>Persetujuan Komentar Tamu:</strong> Komentar dari akun terdaftar akan langsung tayang, sedangkan tanggapan dari tamu publik akan menunggu verifikasi Anda di menu <strong>"Komentar"</strong> (<code class="text-xs bg-stone-100 px-2 py-0.5 rounded text-stone-800">/warga/comments</code>).</li>
                                <li><strong>Membalas Tanggapan:</strong> Penulis dapat membalas tanggapan secara bertingkat (threaded replies) untuk memperkaya diskusi ilmiah.</li>
                                <li><strong>Tandai Spam / Hapus:</strong> Jika menemukan komentar kasar atau promosi iklan yang melanggar norma, Anda dapat menandainya sebagai spam atau menghapusnya langsung.</li>
                            </ul>
                        </div>
                    </section>

                    <div class="p-6 sm:p-8 rounded-3xl bg-stone-900 text-white text-center space-y-4">
                        <h3 class="font-serif text-xl sm:text-2xl md:text-3xl font-bold">Siap Berbagi Gagasan untuk SMAN 1 Malingping?</h3>
                        <p class="text-stone-300 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
                            Setiap pemikiran Anda berharga. Tuangkan ide, karya sastra, opini, maupun resensi buku Anda sekarang di Suara Warga.
                        </p>
                        <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                            <a href="{{ route('warga.articles.create') }}" class="px-6 py-2.5 rounded-full bg-forest text-white hover:bg-forest/90 font-bold text-xs uppercase tracking-wider transition-colors shadow-xs">
                                Mulai Tulis Artikel
                            </a>
                            <a href="{{ route('pedoman-komunitas') }}" class="px-6 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold text-xs uppercase tracking-wider transition-colors">
                                Baca Pedoman Komunitas
                            </a>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-stone-200/70 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-sans text-stone-500">
                        <p>&copy; {{ date('Y') }} SMAN 1 Malingping &bull; Panduan Resmi Suara Warga</p>
                        <a href="{{ route('home') }}" class="font-semibold text-forest hover:text-terracotta transition-colors flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Beranda
                        </a>
                    </div>

                </div>

                <aside class="hidden lg:block lg:col-span-4 sticky top-24 self-start space-y-5">

                    <div class="p-6 rounded-3xl bg-white border border-stone-200/90 shadow-xs">
                        <div class="flex items-center gap-2.5 mb-4 pb-3 border-b border-stone-100">
                            <div class="w-8 h-8 rounded-xl bg-forest/10 text-forest flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            </div>
                            <div>
                                <h3 class="font-serif text-base font-bold text-stone-900 leading-tight">Daftar Isi Panduan</h3>
                                <p class="text-[11px] text-stone-400 font-sans">Navigasi cepat 6 bab teknis</p>
                            </div>
                        </div>

                        <nav class="space-y-1.5 text-xs font-sans">
                            <a href="#langkah-1" class="group flex items-start gap-3 p-2.5 rounded-xl hover:bg-forest/5 text-stone-700 hover:text-forest transition-colors">
                                <span class="w-5 h-5 rounded-full bg-forest/10 group-hover:bg-forest group-hover:text-white text-forest flex items-center justify-center text-[10px] font-bold flex-shrink-0 transition-colors mt-0.5">1</span>
                                <div>
                                    <span class="font-bold block">Membuat Akun & Login</span>
                                    <span class="text-[11px] text-stone-400 font-normal">Verifikasi identitas warga sekolah</span>
                                </div>
                            </a>

                            <a href="#langkah-2" class="group flex items-start gap-3 p-2.5 rounded-xl hover:bg-forest/5 text-stone-700 hover:text-forest transition-colors">
                                <span class="w-5 h-5 rounded-full bg-forest/10 group-hover:bg-forest group-hover:text-white text-forest flex items-center justify-center text-[10px] font-bold flex-shrink-0 transition-colors mt-0.5">2</span>
                                <div>
                                    <span class="font-bold block">Menulis Artikel Baru</span>
                                    <span class="text-[11px] text-stone-400 font-normal">Judul, kutipan, & isi tulisan</span>
                                </div>
                            </a>

                            <a href="#langkah-3" class="group flex items-start gap-3 p-2.5 rounded-xl hover:bg-forest/5 text-stone-700 hover:text-forest transition-colors">
                                <span class="w-5 h-5 rounded-full bg-forest/10 group-hover:bg-forest group-hover:text-white text-forest flex items-center justify-center text-[10px] font-bold flex-shrink-0 transition-colors mt-0.5">3</span>
                                <div>
                                    <span class="font-bold block">Upload & Optimasi Gambar</span>
                                    <span class="text-[11px] text-stone-400 font-normal">Format cover 16:9 & takarir</span>
                                </div>
                            </a>

                            <a href="#langkah-4" class="group flex items-start gap-3 p-2.5 rounded-xl hover:bg-forest/5 text-stone-700 hover:text-forest transition-colors">
                                <span class="w-5 h-5 rounded-full bg-terracotta/10 group-hover:bg-terracotta group-hover:text-white text-terracotta flex items-center justify-center text-[10px] font-bold flex-shrink-0 transition-colors mt-0.5">4</span>
                                <div>
                                    <span class="font-bold block">Kategori & Tag (#Tag)</span>
                                    <span class="text-[11px] text-stone-400 font-normal">Rubrik & tag tugas khusus guru</span>
                                </div>
                            </a>

                            <a href="#langkah-5" class="group flex items-start gap-3 p-2.5 rounded-xl hover:bg-forest/5 text-stone-700 hover:text-forest transition-colors">
                                <span class="w-5 h-5 rounded-full bg-forest/10 group-hover:bg-forest group-hover:text-white text-forest flex items-center justify-center text-[10px] font-bold flex-shrink-0 transition-colors mt-0.5">5</span>
                                <div>
                                    <span class="font-bold block">Draft vs Publikasi</span>
                                    <span class="text-[11px] text-stone-400 font-normal">Penyimpanan draf & proses kurasi</span>
                                </div>
                            </a>

                            <a href="#langkah-6" class="group flex items-start gap-3 p-2.5 rounded-xl hover:bg-forest/5 text-stone-700 hover:text-forest transition-colors">
                                <span class="w-5 h-5 rounded-full bg-forest/10 group-hover:bg-forest group-hover:text-white text-forest flex items-center justify-center text-[10px] font-bold flex-shrink-0 transition-colors mt-0.5">6</span>
                                <div>
                                    <span class="font-bold block">Moderasi Komentar</span>
                                    <span class="text-[11px] text-stone-400 font-normal">Kelola diskusi, balasan, & spam</span>
                                </div>
                            </a>
                        </nav>
                    </div>

                    <div class="p-5 rounded-3xl bg-forest/5 border border-forest/20 text-xs font-sans space-y-3">
                        <span class="font-bold text-forest block uppercase tracking-wider text-[10px]">Aksi Pintas Warga</span>
                        <p class="text-stone-600 leading-relaxed">
                            Sudah memahami seluruh alur penulisan? Mulai publikasikan karya dan pemikiran Anda hari ini.
                        </p>
                        <div class="pt-1 space-y-2">
                            <a href="{{ route('warga.articles.create') }}" class="w-full py-2 px-3 rounded-xl bg-forest hover:bg-forest/90 text-white font-bold text-center block transition-colors shadow-2xs">
                                Tulis Artikel Baru
                            </a>
                            <a href="{{ route('pedoman-komunitas') }}" class="w-full py-2 px-3 rounded-xl bg-white hover:bg-stone-50 border border-stone-200 text-stone-700 font-bold text-center block transition-colors">
                                Pedoman Komunitas
                            </a>
                        </div>
                    </div>

                </aside>

            </div>

        </div>
    </main>
</x-layouts.app>
