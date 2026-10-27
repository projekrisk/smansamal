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
    title="Kebijakan Privasi - SMAN 1 Malingping"
    description="Kebijakan perlindungan data pribadi dan verifikasi identitas warga sekolah pada portal resmi SMAN 1 Malingping."
    type="article">

    <main class="flex-grow pt-32 pb-20 px-6">

        <article class="w-full max-w-[760px] mx-auto">

            <div class="flex flex-col items-center text-center mb-8">
                <div class="flex items-center gap-3 mb-5">
                    <a href="{{ route('home') }}" class="font-sans text-sm text-stone-500 hover:text-stone-900 transition-colors">Beranda</a>
                    <span class="text-stone-400 text-xs">/</span>
                    <span class="font-sans text-[11px] font-bold text-forest uppercase tracking-widest">Privasi & Keamanan</span>
                </div>

                <h1 class="font-serif text-4xl md:text-5xl text-stone-900 leading-tight md:leading-snug mb-5 max-w-3xl">
                    Kebijakan Privasi
                </h1>

                <p class="font-sans text-stone-600 text-[18px] max-w-2xl leading-relaxed">
                    Komitmen resmi SMA Negeri 1 Malingping dalam menjaga kerahasiaan, keamanan, dan keabsahan data seluruh warga sekolah.
                </p>
            </div>

            <div class="w-full h-px bg-stone-200/80 mb-8"></div>

            <div class="my-8 p-6 md:p-7 rounded-2xl bg-stone-100/90 border-l-4 border-l-forest border-y border-r border-stone-200/80">
                <div class="flex items-start gap-4">
                    <div class="flex-1">
                        <h3 class="font-serif text-lg md:text-xl font-bold text-stone-900 mb-2 leading-snug">
                            Validasi Data Siswa & Alumni
                        </h3>
                        <p class="font-sans text-[18px] text-stone-700 leading-relaxed">
                            Kami menegaskan bahwa setiap data identitas yang dimasukkan saat registrasi akun, khususnya <strong>NISN dan kelas bagi Siswa</strong>, serta <strong>tahun kelulusan dan rekam jejak bagi Alumni</strong>, <strong>akan dilakukan pengecekan atau validasi berkala oleh pihak sekolah</strong> terhadap buku induk dan arsip resmi sekolah. Validasi ini diterapkan semata-mata demi memastikan keaslian akun serta menjamin perlindungan privasi dan keamanan seluruh civitas akademika SMAN 1 Malingping.
                        </p>
                    </div>
                </div>
            </div>

            <div class="prose legal-prose font-sans text-stone-800 text-[18px] max-w-none">
                <h2>1. Pengumpulan Data Pribadi</h2>
                <p>
                    Dalam rangka menyediakan layanan portal sekolah yang aman dan terverifikasi, kami mengumpulkan sejumlah informasi identitas yang diserahkan secara sukarela saat pendaftaran atau pembaruan profil:
                </p>
                <ul>
                    <li><strong>Data Umum:</strong> Nama lengkap, alamat email aktif, kata sandi yang telah dienkripsi secara aman, foto avatar, dan bio profil.</li>
                    <li><strong>Data Siswa:</strong> Nomor Induk Siswa Nasional (NISN) dan tingkatan kelas.</li>
                    <li><strong>Data Alumni:</strong> Tahun kelulusan resmi dan status pekerjaan atau perguruan tinggi saat ini.</li>
                    <li><strong>Data Guru / Staf:</strong> NIP (opsional) dan bidang mata pelajaran yang diampu.</li>
                </ul>

                <h2>2. Mekanisme Pengecekan & Penggunaan Data</h2>
                <p>
                    Informasi yang dikumpulkan digunakan semata-mata untuk tujuan institusional:
                </p>
                <ul>
                    <li><strong>Verifikasi Keabsahan:</strong> Melakukan pengecekan silang terhadap arsip buku induk sekolah guna memastikan akun benar-benar dimiliki oleh siswa aktif atau alumni resmi SMAN 1 Malingping.</li>
                    <li><strong>Penyajian Atribusi Karya:</strong> Menyematkan identitas penulis yang kredibel pada artikel warta atau tulisan opini yang dipublikasikan.</li>
                    <li><strong>Keamanan Sistem:</strong> Mencegah tindak penyalahgunaan identitas, spam komentar, atau impersonasi akun.</li>
                </ul>

                <h2>3. Keamanan & Enkripsi Data</h2>
                <p>
                    Keamanan informasi Anda adalah prioritas utama kami. Seluruh kata sandi pengguna dienkripsi menggunakan algoritma cryptographic hashing modern yang tidak dapat dibaca oleh staf sekolah maupun pihak ketiga. Akses terhadap basis data dibatasi hanya untuk personel berwenang dengan hak akses administratif resmi.
                </p>

                <h2>4. Tidak Ada Penjualan Data ke Pihak Ketiga</h2>
                <p>
                    SMAN 1 Malingping <strong>tidak pernah menjual, menyewakan, atau memperjualbelikan</strong> informasi pribadi warga sekolah kepada pihak komersial manapun. Data hanya dapat diungkapkan apabila secara tegas diwajibkan oleh ketentuan perundang-undangan Republik Indonesia.
                </p>

                <h2>5. Hak Akses & Pembaruan Profil</h2>
                <p>
                    Setiap pengguna yang telah masuk berhak memperbarui data profil mereka sewaktu-waktu melalui halaman dashboard profil atau mengajukan permohonan penutupan akun kepada tim pengelola portal sekolah melalui surel <strong>info@sman1malingping.sch.id</strong>.
                </p>
            </div>

        </article>
    </main>
</x-layouts.app>
