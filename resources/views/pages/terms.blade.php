@push('styles')
<style>
    .legal-prose p,
    .legal-prose li {
        font-size: 18px !important;
        line-height: 1.85 !important;
    }
</style>
@endpush

<x-layouts.app
    title="Syarat & Ketentuan - SMAN 1 Malingping"
    description="Ketentuan umum, etika kepenulisan, dan mekanisme verifikasi data identitas bagi seluruh pengguna portal SMAN 1 Malingping."
    type="article">

    <main class="flex-grow pt-32 pb-20 px-6">

        <article class="w-full max-w-[760px] mx-auto">

            <div class="flex flex-col items-center text-center mb-8">
                <div class="flex items-center gap-3 mb-5">
                    <a href="{{ route('home') }}" class="font-sans text-sm text-stone-500 hover:text-stone-900 transition-colors">Beranda</a>
                    <span class="text-stone-400 text-xs">/</span>
                    <span class="font-sans text-[11px] font-bold text-terracotta uppercase tracking-widest">Pedoman Resmi</span>
                </div>

                <h1 class="font-serif text-4xl md:text-5xl text-stone-900 leading-tight md:leading-snug mb-5 max-w-3xl">
                    Syarat & Ketentuan Penggunaan
                </h1>

                <p class="font-sans text-stone-600 text-[18px] max-w-2xl leading-relaxed">
                    Ketentuan umum, etika kepenulisan warta, dan mekanisme verifikasi data identitas bagi seluruh warga sekolah SMAN 1 Malingping.
                </p>
            </div>

            <div class="w-full h-px bg-stone-200/80 mb-8"></div>

            <div class="my-8 p-6 md:p-7 rounded-2xl bg-stone-100/90 border-l-4 border-l-forest border-y border-r border-stone-200/80">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-serif text-lg md:text-xl font-bold text-stone-900 mb-2 leading-snug">
                            Penting: Validasi & Verifikasi Data Siswa dan Alumni
                        </h3>
                        <p class="font-sans text-[18px] text-stone-700 leading-relaxed">
                            Seluruh data pendaftaran akun dengan peran <strong>Siswa</strong> (seperti NISN dan Tingkat Kelas) serta <strong>Alumni</strong> (seperti Tahun Kelulusan dan riwayat kesiswaan) <strong>wajib melalui proses pengecekan dan validasi resmi oleh pihak sekolah</strong> terhadap buku induk dan arsip kesiswaan. Langkah ini diterapkan demi menjaga integritas data, mencegah penggunaan identitas fiktif, serta memastikan komunitas portal sekolah tetap tertib dan aman.
                        </p>
                    </div>
                </div>
            </div>

            <div class="prose legal-prose font-sans text-stone-800 text-[18px] max-w-none">
                <h2>1. Ketentuan Umum Penggunaan</h2>
                <p>
                    Portal resmi SMA Negeri 1 Malingping disediakan sebagai sarana informasi publik, warta kegiatan sekolah, serta wadah publikasi karya literasi dan opini bagi civitas akademika (siswa, dewan guru, dan alumni). Dengan mengakses atau membuat akun di portal ini, Anda menyatakan tunduk dan setuju pada seluruh syarat dan ketentuan yang ditetapkan.
                </p>

                <h2>2. Akun Warga & Pengecekan Data Identitas</h2>
                <p>
                    Untuk menerbitkan karya tulis di kanal <em>Suara Warga</em> atau membagikan kisah pada section <em>Kata Alumni</em>, pengguna diwajibkan mendaftar akun dengan ketentuan:
                </p>
                <ul>
                    <li><strong>Identitas Siswa:</strong> Pengguna wajib mencantumkan Nomor Induk Siswa Nasional (NISN) yang valid serta tingkat kelas yang sedang ditempuh. Data ini akan divalidasi dengan database kesiswaan sekolah.</li>
                    <li><strong>Identitas Alumni:</strong> Pengguna wajib menyertakan tahun kelulusan resmi dari SMAN 1 Malingping. Tim tata usaha akan mencocokkan data dengan buku kelulusan sekolah.</li>
                    <li><strong>Identitas Guru:</strong> Pendidik dapat menyertakan NIP dan mata pelajaran pengampu untuk memverifikasi peran edukator.</li>
                    <li>Pengguna bertanggung jawab penuh dalam menjaga kerahasiaan kata sandi dan keamanan akun masing-masing.</li>
                </ul>

                <h2>3. Hak Cipta & Orisinalitas Tulisan</h2>
                <p>
                    Seluruh naskah opini, esai, ulasan sastra, dan testimoni yang diunggah oleh warga sekolah harus memenuhi standar integritas akademik:
                </p>
                <ul>
                    <li>Karya harus orisinal, bukan hasil jiplakan (plagiarisme), dan belum pernah dialihkan hak ciptanya ke pihak lain.</li>
                    <li>Konten tidak boleh memuat ujaran kebencian, fitnah, diskriminasi SARA, pornografi, maupun unsur yang bertentangan dengan hukum Negara Kesatuan Republik Indonesia.</li>
                    <li>Penulis memberikan hak kepada SMAN 1 Malingping untuk menampilkan, mengarsipkan, dan membagikan tulisan melalui kanal media resmi institusi.</li>
                </ul>

                <h2>4. Moderasi Konten & Penonaktifan Akun</h2>
                <p>
                    Pihak pengelola berhak melakukan kurasi, menyunting tata letak, meminta revisi, atau membatalkan penayangan artikel apabila ditemukan ketidaksesuaian pedoman. Apabila ditemukan akun yang menggunakan identitas palsu atau memanipulasi data NISN/kelulusan, pihak sekolah berhak menonaktifkan akun tersebut secara permanen.
                </p>

                <h2>5. Layanan Bantuan & Pengaduan</h2>
                <p>
                    Apabila Anda mengalami kendala verifikasi data akun atau ingin mengajukan klarifikasi mengenai konten, silakan menghubungi tim pengelola portal melalui surel resmi <strong>info@sman1malingping.sch.id</strong> atau datang langsung ke ruang administrasi SMAN 1 Malingping.
                </p>
            </div>

            <div class="mt-14 pt-6 border-t border-stone-200/70 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-sans text-stone-500">
                <p>&copy; {{ date('Y') }} SMAN 1 Malingping &bull; Dokumen Resmi Tata Kelola Portal</p>
                <a href="{{ route('home') }}" class="font-semibold text-forest hover:text-terracotta transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                </a>
            </div>

        </article>
    </main>
</x-layouts.app>
