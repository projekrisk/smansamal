@push('styles')
<style>
    html {
        scroll-behavior: smooth;
    }
    .sop-item {
        scroll-margin-top: 6rem;
    }
    @media (min-width: 768px) {
        .sop-item {
            scroll-margin-top: 7rem;
        }
    }
</style>
@endpush

<x-layouts.app
    title="Standar Operasional Pelayanan (SOP) - SMAN 1 Malingping"
    description="Standar Operasional Pelayanan (SOP) resmi SMA Negeri 1 Malingping: legalisir ijazah, permohonan janji temu, surat keterangan siswa aktif, mutasi, dan layanan kesiswaan."
    type="website">

    <main class="flex-grow pt-28 sm:pt-32 pb-20 px-4 sm:px-6 font-sans">
        <div class="w-full max-w-4xl mx-auto">

            <div class="flex flex-col items-center text-center mb-8 sm:mb-12">
                <nav class="flex items-center gap-2 mb-3 text-xs sm:text-sm text-stone-500 font-sans" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-stone-900 transition-colors">Beranda</a>
                    <span class="text-stone-300">/</span>
                    <a href="{{ route('profil-sekolah') }}" class="hover:text-stone-900 transition-colors">Profil Sekolah</a>
                    <span class="text-stone-300">/</span>
                    <span class="text-forest font-semibold">SOP Pelayanan</span>
                </nav>

                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-forest/10 text-forest text-xs font-semibold mb-3 tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-forest"></span>
                    <span>Standar Pelayanan Publik</span>
                </div>

                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl text-stone-900 font-bold leading-tight md:leading-snug mb-3 max-w-3xl">
                    Standar Operasional Pelayanan (SOP)
                </h1>

                <p class="font-sans text-stone-600 text-[14px] sm:text-base md:text-lg max-w-2xl leading-relaxed mb-6">
                    Pedoman resmi prosedur, berkas persyaratan, estimasi waktu, dan tautan formulir layanan administrasi sekolah bagi siswa, alumni, orang tua, serta masyarakat.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-800 font-medium border border-emerald-100">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        100% Bebas Biaya (Rp 0)
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-stone-100 text-stone-700 font-medium border border-stone-200/80">
                        <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Senin – Jumat 07.15 – 16.00 WIB
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-stone-100 text-stone-700 font-medium border border-stone-200/80">
                        <svg class="w-3.5 h-3.5 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Tautan Formulir Tab Baru
                    </span>
                </div>
            </div>

            <div id="sop-accordion-container" class="space-y-3.5 sm:space-y-4">

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group sop-item transition-all duration-300" id="legalisir-ijazah">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold sop-toggle focus:outline-none text-left gap-4" type="button">
                        <div class="flex-1">
                            <h2 class="font-serif text-base sm:text-lg md:text-xl font-bold text-stone-900 leading-snug group-hover:text-forest transition-colors">
                                Legalisir Ijazah & Rapor
                            </h2>
                            <p class="text-[13px] text-stone-500 font-sans font-normal mt-0.5">
                                Pengesahan salinan ijazah, SKL, dan rapor untuk studi lanjut atau kerja
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-hover:bg-forest/10 flex items-center justify-center flex-shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-terracotta sop-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    </button>
                    <div class="sop-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <div class="pt-4 mt-4 border-t border-stone-100 font-sans text-[14px] sm:text-[15px] text-stone-700 space-y-4">
                                <p class="leading-relaxed text-stone-600">
                                    Standar pelayanan pengesahan fotokopi ijazah, rapor, maupun SKL bagi alumni dan peserta didik yang membutuhkan legalisasi resmi untuk keperluan melanjutkan studi ke perguruan tinggi, kedinasan, atau melamar pekerjaan.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-stone-50 rounded-xl border border-stone-100 text-xs sm:text-sm">
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Waktu Pelayanan</span>
                                        <strong class="text-stone-800 text-[14px]">1 – 2 Hari Kerja</strong>
                                        <p class="text-[12px] text-stone-500">(Bisa 30 menit jika pimpinan di tempat)</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Tarif / Biaya</span>
                                        <strong class="text-emerald-700 font-bold text-[14px]">Gratis (Rp 0)</strong>
                                        <p class="text-[12px] text-stone-500">Maks. 5 rangkap per pengajuan</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Loket Pelayanan</span>
                                        <strong class="text-stone-800 text-[14px]">Ruang Tata Usaha (TU)</strong>
                                        <p class="text-[12px] text-stone-500">Subbag Kearsipan & Buku Induk</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-bold text-stone-900 mb-2 flex items-center gap-1.5 text-[14px] sm:text-[15px]">
                                        <svg class="w-4 h-4 text-forest flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Persyaratan Berkas:
                                    </h3>
                                    <ul class="space-y-1.5 pl-5 list-disc text-stone-600 leading-relaxed text-[14px] sm:text-[15px]">
                                        <li>Membawa <strong>Ijazah / SKL / Rapor ASLI</strong> untuk verifikasi terhadap Buku Induk Register sekolah.</li>
                                        <li>Menyerahkan fotokopi ijazah/rapor yang akan dilegalisir (maksimal 5 lembar per permohonan).</li>
                                        <li>Menunjukkan kartu identitas diri (KTP/SIM/Kartu Pelajar).</li>
                                        <li>Bila diwakilkan oleh orang tua/keluarga, lampirkan surat kuasa sederhana dan fotokopi KTP kedua belah pihak.</li>
                                    </ul>
                                </div>

                                <div>
                                    <h3 class="font-bold text-stone-900 mb-2 flex items-center gap-1.5 text-[14px] sm:text-[15px]">
                                        <svg class="w-4 h-4 text-forest flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        Alur & Prosedur:
                                    </h3>
                                    <ol class="space-y-1.5 pl-5 list-decimal text-stone-600 leading-relaxed text-[14px] sm:text-[15px]">
                                        <li>Pemohon menyerahkan berkas asli dan salinan ke loket pelayanan Tata Usaha.</li>
                                        <li>Petugas mencocokkan nomor seri ijazah, nama siswa, dan kelulusan dengan Buku Induk.</li>
                                        <li>Dokumen diajukan untuk penandatanganan pengesahan oleh Kepala Sekolah atau pejabat berwenang.</li>
                                        <li>Petugas membubuhkan stempel dinas basah pada lembar fotokopi yang telah disahkan.</li>
                                        <li>Pemohon menandatangani buku ekspedisi tanda terima dan menerima dokumen legalisir.</li>
                                    </ol>
                                </div>

<!--                                <div class="pt-2 flex flex-wrap items-center gap-2.5">
                                    <a
                                        href="https://wa.me/6281234567890?text=Halo%20Admin%20TU%20SMAN%201%20Malingping,%20saya%20ingin%20konsultasi%20mengenai%20pelayanan%20Legalisir%20Ijazah"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-forest text-white text-[13px] sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs group/btn"
                                    >
                                        <span>Hubungi Loket Legalisir (WhatsApp)</span>
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <a
                                        href="https://referensi.data.kemdikbud.go.id/"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-stone-200 text-stone-700 bg-white hover:bg-stone-50 hover:border-stone-400 text-[13px] sm:text-sm font-semibold transition-colors shadow-2xs"
                                    >
                                        <span>Cek Data Referensi Kemendikbud</span>
                                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                                -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group sop-item transition-all duration-300" id="janji-temu">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold sop-toggle focus:outline-none text-left gap-4" type="button">
                        <div class="flex-1">
                            <h2 class="font-serif text-base sm:text-lg md:text-xl font-bold text-stone-900 leading-snug group-hover:text-forest transition-colors">
                                Janji Temu & Kunjungan Tamu
                            </h2>
                            <p class="text-[13px] text-stone-500 font-sans font-normal mt-0.5">
                                Pertemuan dinas, audiensi pimpinan sekolah, dan kunjungan orang tua
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-hover:bg-forest/10 flex items-center justify-center flex-shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-terracotta sop-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    </button>
                    <div class="sop-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <div class="pt-4 mt-4 border-t border-stone-100 font-sans text-[14px] sm:text-[15px] text-stone-700 space-y-4">
                                <p class="leading-relaxed text-stone-600">
                                    Tata cara penerimaan tamu kedinasan, orang tua/wali murid, organisasi alumni, serta perwakilan instansi mitra guna menjamin keamanan, kenyamanan proses belajar mengajar, serta kepastian jadwal pimpinan sekolah.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-stone-50 rounded-xl border border-stone-100 text-xs sm:text-sm">
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Konfirmasi Janji Temu</span>
                                        <strong class="text-stone-800 text-[14px]">Minimal H-1 Kerja</strong>
                                        <p class="text-[12px] text-stone-500">Mencegah bentrok agenda</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Busana & Etika</span>
                                        <strong class="text-stone-800 font-bold text-[14px]">Rapi & Sopan</strong>
                                        <p class="text-[12px] text-stone-500">Kawasan institusi pendidikan</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Unit Penerima</span>
                                        <strong class="text-stone-800 text-[14px]">Humas & Pos Satpam</strong>
                                        <p class="text-[12px] text-stone-500">Ruang Pertemuan Resmi</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-bold text-stone-900 mb-2 flex items-center gap-1.5 text-[14px] sm:text-[15px]">
                                        <svg class="w-4 h-4 text-forest flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Ketentuan Kunjungan:
                                    </h3>
                                    <ul class="space-y-1.5 pl-5 list-disc text-stone-600 leading-relaxed text-[14px] sm:text-[15px]">
                                        <li>Membawa <strong>Kartu Identitas (KTP/SIM/ID Pegawai)</strong> untuk ditukar dengan tanda pengenal tamu di pos keamanan.</li>
                                        <li>Membawa <strong>Surat Tugas / Surat Pengantar</strong> bagi perwakilan instansi atau lembaga eksternal.</li>
                                        <li>Menyampaikan maksud dan tujuan pertemuan kepada petugas piket / sekretariat Humas.</li>
                                        <li>Tidak diperkenankan menemui guru di dalam kelas saat kegiatan belajar berlangsung tanpa izin kurikulum.</li>
                                    </ul>
                                </div>

<!-- 
                                <div class="pt-2 flex flex-wrap items-center gap-2.5">
                                    <a
                                        href="https://wa.me/6281234567890?text=Halo%20Humas%20SMAN%201%20Malingping,%20saya%20ingin%20mengajukan%20permohonan%20janji%20temu%20dengan%20Kepala%20Sekolah%20atau%20Guru"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-forest text-white text-[13px] sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs group/btn"
                                    >
                                        <span>Konfirmasi Janji Temu via Humas (WhatsApp)</span>
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <a
                                        href="https://maps.google.com/?q=SMAN+1+Malingping"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-stone-200 text-stone-700 bg-white hover:bg-stone-50 hover:border-stone-400 text-[13px] sm:text-sm font-semibold transition-colors shadow-2xs"
                                    >
                                        <span>Petunjuk Arah Kampus (Google Maps)</span>
                                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
-->                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group sop-item transition-all duration-300" id="surat-siswa-aktif">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold sop-toggle focus:outline-none text-left gap-4" type="button">
                        <div class="flex-1">
                            <h2 class="font-serif text-base sm:text-lg md:text-xl font-bold text-stone-900 leading-snug group-hover:text-forest transition-colors">
                                Surat Keterangan Siswa Aktif
                            </h2>
                            <p class="text-[13px] text-stone-500 font-sans font-normal mt-0.5">
                                Kelengkapan tunjangan gaji orang tua, beasiswa, dan keperluan administrasi
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-hover:bg-forest/10 flex items-center justify-center flex-shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-terracotta sop-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    </button>
                    <div class="sop-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <div class="pt-4 mt-4 border-t border-stone-100 font-sans text-[14px] sm:text-[15px] text-stone-700 space-y-4">
                                <p class="leading-relaxed text-stone-600">
                                    Prosedur penerbitan surat resmi yang menerangkan bahwa peserta didik berstatus aktif di SMAN 1 Malingping untuk kelengkapan tunjangan gaji orang tua (PNS/TNI/Polri/BUMN/Swasta), pembuatan visa/paspor, beasiswa, atau BPJS.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-stone-50 rounded-xl border border-stone-100 text-xs sm:text-sm">
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Waktu Penyelesaian</span>
                                        <strong class="text-stone-800 text-[14px]">1 Hari Kerja</strong>
                                        <p class="text-[12px] text-stone-500">Maks. 2 hari bila antrean padat</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Biaya</span>
                                        <strong class="text-emerald-700 font-bold text-[14px]">Gratis (Rp 0)</strong>
                                        <p class="text-[12px] text-stone-500">Nomor registrasi resmi</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Validasi Data</span>
                                        <strong class="text-stone-800 text-[14px]">Sinkron Dapodik</strong>
                                        <p class="text-[12px] text-stone-500">Status siswa aktif</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-bold text-stone-900 mb-2 flex items-center gap-1.5 text-[14px] sm:text-[15px]">
                                        <svg class="w-4 h-4 text-forest flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Persyaratan Permohonan:
                                    </h3>
                                    <ul class="space-y-1.5 pl-5 list-disc text-stone-600 leading-relaxed text-[14px] sm:text-[15px]">
                                        <li>Menunjukkan <strong>Kartu Pelajar</strong> atau mencantumkan NIS / NISN.</li>
                                        <li>Fotokopi <strong>Kartu Keluarga (KK)</strong> orang tua / wali.</li>
                                        <li>Menyebutkan tujuan permohonan surat (misal: formulir KP4 tunjangan anak PNS, beasiswa, perbankan, dll).</li>
                                    </ul>
                                </div>

<!--
                                <div class="pt-2 flex flex-wrap items-center gap-2.5">
                                    <a
                                        href="https://wa.me/6281234567890?text=Halo%20Admin%20TU%20SMAN%201%20Malingping,%20saya%20ingin%20mengajukan%20Surat%20Keterangan%20Siswa%20Aktif"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-forest text-white text-[13px] sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs group/btn"
                                    >
                                        <span>Ajukan Surat Siswa Aktif (WhatsApp TU)</span>
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <a
                                        href="https://nisn.data.kemdikbud.go.id/"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-stone-200 text-stone-700 bg-white hover:bg-stone-50 hover:border-stone-400 text-[13px] sm:text-sm font-semibold transition-colors shadow-2xs"
                                    >
                                        <span>Cek Data NISN Kemendikbud</span>
                                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
-->                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group sop-item transition-all duration-300" id="pengambilan-ijazah">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold sop-toggle focus:outline-none text-left gap-4" type="button">
                        <div class="flex-1">
                            <h2 class="font-serif text-base sm:text-lg md:text-xl font-bold text-stone-900 leading-snug group-hover:text-forest transition-colors">
                                Pengambilan Ijazah Asli
                            </h2>
                            <p class="text-[13px] text-stone-500 font-sans font-normal mt-0.5">
                                Serah terima dokumen negara asli, transkrip nilai, dan cap 3 jari
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-hover:bg-forest/10 flex items-center justify-center flex-shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-terracotta sop-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    </button>
                    <div class="sop-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <div class="pt-4 mt-4 border-t border-stone-100 font-sans text-[14px] sm:text-[15px] text-stone-700 space-y-4">
                                <p class="leading-relaxed text-stone-600">
                                    Standar operasional pengambilan blangko ijazah asli negara dan buku rapor kelulusan. SMAN 1 Malingping berkomitmen <strong>tidak melakukan penahanan ijazah dengan alasan apapun</strong>.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-stone-50 rounded-xl border border-stone-100 text-xs sm:text-sm">
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Waktu Layanan</span>
                                        <strong class="text-stone-800 text-[14px]">15 – 30 Menit</strong>
                                        <p class="text-[12px] text-stone-500">Cap 3 jari langsung</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Biaya Penyerahan</span>
                                        <strong class="text-emerald-700 font-bold text-[14px]">Bebas Biaya (Rp 0)</strong>
                                        <p class="text-[12px] text-stone-500">Tanpa biaya tebusan</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Ketentuan</span>
                                        <strong class="text-stone-800 text-[14px]">Pemilik Langsung</strong>
                                        <p class="text-[12px] text-stone-500">Atau kuasa bermaterai</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-bold text-stone-900 mb-2 flex items-center gap-1.5 text-[14px] sm:text-[15px]">
                                        <svg class="w-4 h-4 text-forest flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Persyaratan & Dokumen:
                                    </h3>
                                    <ul class="space-y-1.5 pl-5 list-disc text-stone-600 leading-relaxed text-[14px] sm:text-[15px]">
                                        <li>Surat Keterangan <strong>Bebas Pustaka</strong> (tidak memiliki tunggakan buku perpustakaan).</li>
                                        <li>Wajib diambil langsung oleh siswa bersangkutan untuk pembubuhan cap 3 jari pada dokumen ijazah.</li>
                                        <li>Jika berhalangan mendesak, dapat diwakilkan orang tua kandung dengan melampirkan <strong>Surat Kuasa bermaterai Rp 10.000</strong>.</li>
                                    </ul>
                                </div>

<!--
                                <div class="pt-2 flex flex-wrap items-center gap-2.5">
                                    <a
                                        href="https://wa.me/6281234567890?text=Halo%20TU%20SMAN%201%20Malingping,%20saya%20ingin%20konfirmasi%20jadwal%20pengambilan%20ijazah%20asli"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-forest text-white text-[13px] sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs group/btn"
                                    >
                                        <span>Konfirmasi Pengambilan Ijazah (WhatsApp TU)</span>
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
-->                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group sop-item transition-all duration-300" id="mutasi-siswa">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold sop-toggle focus:outline-none text-left gap-4" type="button">
                        <div class="flex-1">
                            <h2 class="font-serif text-base sm:text-lg md:text-xl font-bold text-stone-900 leading-snug group-hover:text-forest transition-colors">
                                Mutasi Siswa (Masuk & Keluar)
                            </h2>
                            <p class="text-[13px] text-stone-500 font-sans font-normal mt-0.5">
                                Perpindahan peserta didik sesuai regulasi Dapodik dan dinas pendidikan
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-hover:bg-forest/10 flex items-center justify-center flex-shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-terracotta sop-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    </button>
                    <div class="sop-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <div class="pt-4 mt-4 border-t border-stone-100 font-sans text-[14px] sm:text-[15px] text-stone-700 space-y-4">
                                <p class="leading-relaxed text-stone-600">
                                    Prosedur resmi perpindahan peserta didik baik mutasi keluar menuju sekolah lain maupun mutasi masuk ke SMAN 1 Malingping sesuai regulasi Dinas Pendidikan Provinsi Banten dan ketersediaan kuota Dapodik.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-stone-50 rounded-xl border border-stone-100 text-xs sm:text-sm">
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Estimasi Waktu</span>
                                        <strong class="text-stone-800 text-[14px]">3 – 5 Hari Kerja</strong>
                                        <p class="text-[12px] text-stone-500">Termasuk rekomendasi Cabdin</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Biaya</span>
                                        <strong class="text-emerald-700 font-bold text-[14px]">Gratis (Rp 0)</strong>
                                        <p class="text-[12px] text-stone-500">Tanpa uang pangkal</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Kriteria Masuk</span>
                                        <strong class="text-stone-800 text-[14px]">Kuota Tersedia</strong>
                                        <p class="text-[12px] text-stone-500">Maks. 36 siswa per rombel</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                                    <div class="p-3.5 bg-stone-50 rounded-xl border border-stone-100">
                                        <h4 class="font-bold text-stone-900 mb-1.5 text-xs uppercase tracking-wider text-forest">A. Mutasi Keluar:</h4>
                                        <ul class="space-y-1 list-disc pl-4 text-[13px] sm:text-[14px] text-stone-600 leading-relaxed">
                                            <li>Surat permohonan orang tua/wali bermaterai Rp 10.000.</li>
                                            <li>Surat kesediaan menerima dari sekolah tujuan.</li>
                                            <li>Bebas tanggungan perpustakaan & administrasi.</li>
                                        </ul>
                                    </div>
                                    <div class="p-3.5 bg-stone-50 rounded-xl border border-stone-100">
                                        <h4 class="font-bold text-stone-900 mb-1.5 text-xs uppercase tracking-wider text-forest">B. Mutasi Masuk:</h4>
                                        <ul class="space-y-1 list-disc pl-4 text-[13px] sm:text-[14px] text-stone-600 leading-relaxed">
                                            <li>Surat keterangan pindah sekolah asal & dinas.</li>
                                            <li>Buku rapor lengkap dilegalisir.</li>
                                            <li>Fotokopi KK, Akta Kelahiran, & kuota Dapodik ada.</li>
                                        </ul>
                                    </div>
                                </div>

<!--
                                <div class="pt-2 flex flex-wrap items-center gap-2.5">
                                    <a
                                        href="https://wa.me/6281234567890?text=Halo%20Kesiswaan%20SMAN%201%20Malingping,%20saya%20ingin%20konsultasi%20mengenai%20layanan%20Mutasi%20Siswa"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-forest text-white text-[13px] sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs group/btn"
                                    >
                                        <span>Konsultasi Mutasi (WhatsApp Kesiswaan)</span>
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <a
                                        href="https://dapo.kemdikbud.go.id/"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-stone-200 text-stone-700 bg-white hover:bg-stone-50 hover:border-stone-400 text-[13px] sm:text-sm font-semibold transition-colors shadow-2xs"
                                    >
                                        <span>Cek Info Dapodik Kemendikbud</span>
                                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
-->                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group sop-item transition-all duration-300" id="ijazah-hilang-skpi">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold sop-toggle focus:outline-none text-left gap-4" type="button">
                        <div class="flex-1">
                            <h2 class="font-serif text-base sm:text-lg md:text-xl font-bold text-stone-900 leading-snug group-hover:text-forest transition-colors">
                                Penggantian Ijazah Hilang / Rusak (SKPI)
                            </h2>
                            <p class="text-[13px] text-stone-500 font-sans font-normal mt-0.5">
                                Penerbitan Surat Keterangan Pengganti Ijazah berkekuatan hukum tetap
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-hover:bg-forest/10 flex items-center justify-center flex-shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-terracotta sop-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    </button>
                    <div class="sop-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <div class="pt-4 mt-4 border-t border-stone-100 font-sans text-[14px] sm:text-[15px] text-stone-700 space-y-4">
                                <p class="leading-relaxed text-stone-600">
                                    Blangko ijazah negara yang hilang atau rusak tidak dapat dicetak ulang. Sekolah menerbitkan <strong>Surat Keterangan Pengganti Ijazah (SKPI)</strong> resmi sesuai Permendikbud yang berkekuatan hukum setara.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-stone-50 rounded-xl border border-stone-100 text-xs sm:text-sm">
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Waktu Pengurusan</span>
                                        <strong class="text-stone-800 text-[14px]">3 – 7 Hari Kerja</strong>
                                        <p class="text-[12px] text-stone-500">Termasuk pengesahan Cabdin</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Biaya Administrasi</span>
                                        <strong class="text-emerald-700 font-bold text-[14px]">Gratis (Rp 0)</strong>
                                        <p class="text-[12px] text-stone-500">Menyediakan materai sendiri</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Dasar Hukum</span>
                                        <strong class="text-stone-800 text-[14px]">Permendikbud</strong>
                                        <p class="text-[12px] text-stone-500">Diakui secara nasional</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-bold text-stone-900 mb-2 flex items-center gap-1.5 text-[14px] sm:text-[15px]">
                                        <svg class="w-4 h-4 text-forest flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Persyaratan Berkas:
                                    </h3>
                                    <ul class="space-y-1.5 pl-5 list-disc text-stone-600 leading-relaxed text-[14px] sm:text-[15px]">
                                        <li><strong>Surat Tanda Penerimaan Laporan Kehilangan</strong> asli dari Kantor Kepolisian setempat.</li>
                                        <li><strong>Surat Pernyataan Tanggung Jawab Mutlak (SPTJM)</strong> bermaterai Rp 10.000.</li>
                                        <li>Fotokopi Ijazah / Rapor lama yang hilang (jika masih tersimpan) atau fotokopi Akta Lahir & KK.</li>
                                        <li>Pas foto terbaru ukuran 3x4 sebanyak 3 lembar (pakaian kemeja rapi berkerah).</li>
                                    </ul>
                                </div>

<!--
                                <div class="pt-2 flex flex-wrap items-center gap-2.5">
                                    <a
                                        href="https://wa.me/6281234567890?text=Halo%20TU%20SMAN%201%20Malingping,%20saya%20ingin%20konsultasi%20pengurusan%20Surat%20Keterangan%20Pengganti%20Ijazah%20Hilang"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-forest text-white text-[13px] sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs group/btn"
                                    >
                                        <span>Konsultasi Pengurusan SKPI (WhatsApp TU)</span>
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <a
                                        href="https://jdih.kemdikbud.go.id/"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-stone-200 text-stone-700 bg-white hover:bg-stone-50 hover:border-stone-400 text-[13px] sm:text-sm font-semibold transition-colors shadow-2xs"
                                    >
                                        <span>Regulasi Ijazah JDIH Kemendikbud</span>
                                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
-->                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group sop-item transition-all duration-300" id="konseling-bk">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold sop-toggle focus:outline-none text-left gap-4" type="button">
                        <div class="flex-1">
                            <h2 class="font-serif text-base sm:text-lg md:text-xl font-bold text-stone-900 leading-snug group-hover:text-forest transition-colors">
                                Konseling BK & Wali Murid
                            </h2>
                            <p class="text-[13px] text-stone-500 font-sans font-normal mt-0.5">
                                Pendampingan minat bakat, SNBP/SNBT, karir, dan bimbingan kedisiplinan
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-hover:bg-forest/10 flex items-center justify-center flex-shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-terracotta sop-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    </button>
                    <div class="sop-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <div class="pt-4 mt-4 border-t border-stone-100 font-sans text-[14px] sm:text-[15px] text-stone-700 space-y-4">
                                <p class="leading-relaxed text-stone-600">
                                    Layanan bimbingan psikososial, pemilihan jurusan perguruan tinggi, serta fasilitasi komunikasi antara siswa, guru, dan orang tua/wali murid dengan prinsip kerahasiaan terjaga di ruang privat.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-stone-50 rounded-xl border border-stone-100 text-xs sm:text-sm">
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Durasi Sesi</span>
                                        <strong class="text-stone-800 text-[14px]">30 – 60 Menit</strong>
                                        <p class="text-[12px] text-stone-500">Sesuai kebutuhan kasus</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Biaya Konseling</span>
                                        <strong class="text-emerald-700 font-bold text-[14px]">Gratis (Rp 0)</strong>
                                        <p class="text-[12px] text-stone-500">Layanan siswa & wali murid</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Ruangan</span>
                                        <strong class="text-stone-800 text-[14px]">Ruang Khusus BK</strong>
                                        <p class="text-[12px] text-stone-500">Privat & menjaga privasi</p>
                                    </div>
                                </div>

                                <div class="pt-2 flex flex-wrap items-center gap-2.5">
                                <!--
                                    <a
                                        href="https://wa.me/6281234567890?text=Halo%20Tim%20BK%20SMAN%201%20Malingping,%20saya%20ingin%20konsultasi%20mengenai%20perkembangan%20putra%20putri%20saya"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-forest text-white text-[13px] sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs group/btn"
                                    >
                                        <span>Hubungi Konseling Guru BK (WhatsApp)</span>
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                -->    
                                    <a
                                        href="https://snpmb.bppp.kemdikbud.go.id/"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-stone-200 text-stone-700 bg-white hover:bg-stone-50 hover:border-stone-400 text-[13px] sm:text-sm font-semibold transition-colors shadow-2xs"
                                    >
                                        <span>Portal Masuk PTN (SNPMB)</span>
                                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group sop-item transition-all duration-300" id="sarpras-fasilitas">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold sop-toggle focus:outline-none text-left gap-4" type="button">
                        <div class="flex-1">
                            <h2 class="font-serif text-base sm:text-lg md:text-xl font-bold text-stone-900 leading-snug group-hover:text-forest transition-colors">
                                Peminjaman Ruang & Fasilitas
                            </h2>
                            <p class="text-[13px] text-stone-500 font-sans font-normal mt-0.5">
                                Pemanfaatan aula, laboratorium, dan lapangan sekolah untuk kegiatan
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-hover:bg-forest/10 flex items-center justify-center flex-shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-terracotta sop-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    </button>
                    <div class="sop-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <div class="pt-4 mt-4 border-t border-stone-100 font-sans text-[14px] sm:text-[15px] text-stone-700 space-y-4">
                                <p class="leading-relaxed text-stone-600">
                                    Mekanisme peminjaman fasilitas penunjang pendidikan dan kegiatan kesiswaan (Aula, Lapangan Olahraga, Laboratorium Komputer/Sains) untuk menjaga ketertiban, kebersihan, dan keselamatan inventaris sekolah.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-stone-50 rounded-xl border border-stone-100 text-xs sm:text-sm">
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Batas Pengajuan</span>
                                        <strong class="text-stone-800 text-[14px]">Minimal H-3 Acara</strong>
                                        <p class="text-[12px] text-stone-500">Pencegahan bentrok jadwal</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Tanggung Jawab</span>
                                        <strong class="text-stone-800 text-[14px]">Kebersihan & Aset</strong>
                                        <p class="text-[12px] text-stone-500">Kondisi kembali rapi</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Persetujuan</span>
                                        <strong class="text-stone-800 text-[14px]">Wakasek Sarpras</strong>
                                        <p class="text-[12px] text-stone-500">Izin pemakaian resmi</p>
                                    </div>
                                </div>

<!--
                                <div class="pt-2 flex flex-wrap items-center gap-2.5">
                                    <a
                                        href="https://wa.me/6281234567890?text=Halo%20Sarpras%20SMAN%201%20Malingping,%20saya%20ingin%20konfirmasi%20ketersediaan%20peminjaman%20ruang%20dan%20fasilitas"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-forest text-white text-[13px] sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs group/btn"
                                    >
                                        <span>Konfirmasi Ruangan (WhatsApp Sarpras)</span>
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
-->                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-2xl md:rounded-[1.5rem] border border-stone-200 shadow-sm group sop-item transition-all duration-300" id="layanan-pengaduan">
                    <button class="w-full font-serif text-base sm:text-lg text-stone-900 cursor-pointer flex justify-between items-center font-semibold sop-toggle focus:outline-none text-left gap-4" type="button">
                        <div class="flex-1">
                            <h2 class="font-serif text-base sm:text-lg md:text-xl font-bold text-stone-900 leading-snug group-hover:text-forest transition-colors">
                                Layanan Pengaduan & Aspirasi
                            </h2>
                            <p class="text-[13px] text-stone-500 font-sans font-normal mt-0.5">
                                Kanal laporan masyarakat, aspirasi pelayanan, dan integrasi SP4N-LAPOR!
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-hover:bg-forest/10 flex items-center justify-center flex-shrink-0 transition-colors">
                            <svg class="w-5 h-5 text-terracotta sop-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    </button>
                    <div class="sop-content grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr; opacity: 0;">
                        <div class="overflow-hidden">
                            <div class="pt-4 mt-4 border-t border-stone-100 font-sans text-[14px] sm:text-[15px] text-stone-700 space-y-4">
                                <p class="leading-relaxed text-stone-600">
                                    Mekanisme penyampaian masukan atau pengaduan atas pelayanan publik sekolah, pencegahan gratifikasi dan pungli, dengan jaminan perlindungan kerahasiaan identitas pelapor.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-stone-50 rounded-xl border border-stone-100 text-xs sm:text-sm">
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Respon Awal</span>
                                        <strong class="text-stone-800 text-[14px]">Maks. 2 x 24 Jam Kerja</strong>
                                        <p class="text-[12px] text-stone-500">Telaah materi laporan</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Privasi Pelapor</span>
                                        <strong class="text-rose-700 font-bold text-[14px]">Dijamin Rahasia</strong>
                                        <p class="text-[12px] text-stone-500">Perlindungan identitas</p>
                                    </div>
                                    <div>
                                        <span class="text-stone-400 block font-medium text-xs">Kanal Resmi</span>
                                        <strong class="text-stone-800 text-[14px]">SP4N-LAPOR! & WA</strong>
                                        <p class="text-[12px] text-stone-500">Tercatat dinas</p>
                                    </div>
                                </div>

 <!-- 
                                <div class="pt-2 flex flex-wrap items-center gap-2.5">
                                    <a
                                        href="https://www.lapor.go.id/"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-700 text-white text-[13px] sm:text-sm font-semibold hover:bg-stone-900 transition-colors shadow-2xs group/btn"
                                    >
                                        <span>Lapor via Portal Nasional SP4N-LAPOR!</span>
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <a
                                        href="https://wa.me/6281234567890?text=Halo%20Tim%20Pengaduan%20SMAN%201%20Malingping,%20saya%20ingin%20menyampaikan%20aspirasi%20atau%20pengaduan%20layanan"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-stone-200 text-stone-700 bg-white hover:bg-stone-50 hover:border-stone-400 text-[13px] sm:text-sm font-semibold transition-colors shadow-2xs"
                                    >
                                        <span>WhatsApp Pengaduan Sekolah</span>
                                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
-->                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-10 sm:mt-12 p-6 sm:p-8 rounded-2xl md:rounded-[1.5rem] bg-stone-100/90 border border-stone-200/90 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="max-w-xl">
                    <span class="inline-block text-[11px] font-bold font-sans uppercase tracking-widest text-forest bg-forest/10 px-3 py-1 rounded-full mb-2">Maklumat Pelayanan</span>
                    <h3 class="font-serif text-xl sm:text-2xl font-bold text-stone-900 mb-2">
                        Komitmen Integritas & Pelayanan Prima
                    </h3>
                    <p class="font-sans text-[14px] text-stone-600 leading-relaxed">
                        Seluruh staf dan dewan guru SMA Negeri 1 Malingping berkomitmen memberikan pelayanan ramah (Senyum, Salam, Sapa, Sopan, Santun), tepat waktu, serta <strong>menolak segala bentuk gratifikasi dan pungutan liar</strong>.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <a
                        href="{{ route('contact') }}"
                        class="px-5 py-2.5 rounded-full bg-forest text-white text-[13px] sm:text-sm font-semibold hover:bg-stone-900 transition-colors text-center shadow-sm"
                    >
                        Kontak Resmi
                    </a>
                </div>
            </div>

        </div>
    </main>

    <aside aria-label="Navigasi Daftar Isi SOP">
        <button
            type="button"
            id="toc-floating-btn"
            class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-40 inline-flex items-center gap-2 px-3.5 py-2.5 sm:px-4 sm:py-3 rounded-full bg-forest text-white text-xs sm:text-sm font-semibold shadow-xl shadow-forest/25 hover:bg-stone-900 transition-all duration-300 hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-2 border border-white/20 group cursor-pointer"
            aria-expanded="false"
            aria-controls="toc-modal"
            title="Buka Daftar Isi SOP"
        >
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-200 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h7"/>
            </svg>
            <span class="font-medium tracking-wide">Daftar Isi SOP</span>
        </button>
    </aside>

    <div
        id="toc-overlay"
        class="fixed inset-0 bg-stone-900/60 backdrop-blur-2xs z-50 transition-opacity duration-300 opacity-0 pointer-events-none"
        aria-hidden="true"
    ></div>

    <div
        id="toc-modal-wrapper"
        class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 pointer-events-none transition-all duration-300"
    >
        <div
            id="toc-modal"
            role="dialog"
            aria-modal="true"
            aria-labelledby="toc-modal-title"
            class="w-full sm:max-w-md bg-white rounded-t-[1.75rem] sm:rounded-3xl shadow-2xl border-t sm:border border-stone-200/90 overflow-hidden transition-all duration-300 opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95 pointer-events-none flex flex-col max-h-[82vh] sm:max-h-[78vh] font-sans"
        >
            <div class="pt-2.5 pb-1 flex justify-center sm:hidden bg-stone-50/90">
                <div class="w-10 h-1 bg-stone-300 rounded-full"></div>
            </div>

            <div class="px-4 py-3 sm:px-5 sm:py-3.5 border-b border-stone-100 flex items-center justify-between bg-stone-50/90 shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-forest/10 text-forest flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h7"/>
                        </svg>
                    </div>
                    <div>
                        <h3 id="toc-modal-title" class="font-serif text-sm sm:text-base font-bold text-stone-900 leading-tight">
                            Daftar Isi SOP
                        </h3>
                        <p class="text-[11px] sm:text-xs text-stone-500 font-sans mt-0.5">
                            Pilih SOP untuk langsung menuju layanan
                        </p>
                    </div>
                </div>
                <button
                    type="button"
                    id="toc-close-btn"
                    class="w-8 h-8 rounded-full bg-stone-200/70 hover:bg-stone-200 active:bg-stone-300 text-stone-600 hover:text-stone-900 flex items-center justify-center transition-colors focus:outline-none cursor-pointer shrink-0"
                    aria-label="Tutup daftar isi"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-2 sm:p-2.5 overflow-y-auto overscroll-contain space-y-0.5 sm:space-y-1">
                @php
                    $tocItems = [
                        ['id' => 'legalisir-ijazah', 'title' => 'Legalisir Ijazah & Rapor'],
                        ['id' => 'janji-temu', 'title' => 'Janji Temu & Kunjungan Tamu'],
                        ['id' => 'surat-siswa-aktif', 'title' => 'Surat Keterangan Siswa Aktif'],
                        ['id' => 'pengambilan-ijazah', 'title' => 'Pengambilan Ijazah Asli'],
                        ['id' => 'mutasi-siswa', 'title' => 'Mutasi Siswa (Masuk & Keluar)'],
                        ['id' => 'ijazah-hilang-skpi', 'title' => 'Penggantian Ijazah Hilang / Rusak (SKPI)'],
                        ['id' => 'konseling-bk', 'title' => 'Konseling BK & Wali Murid'],
                        ['id' => 'sarpras-fasilitas', 'title' => 'Peminjaman Ruang & Fasilitas'],
                        ['id' => 'layanan-pengaduan', 'title' => 'Layanan Pengaduan & Aspirasi'],
                    ];
                @endphp

                @foreach($tocItems as $item)
                    <button
                        type="button"
                        class="toc-nav-item w-full text-left px-3.5 py-2.5 rounded-xl text-stone-800 hover:text-forest hover:bg-forest/5 active:bg-forest/10 text-[13px] sm:text-[14px] font-medium transition-colors flex items-center justify-between gap-3 group cursor-pointer border border-transparent hover:border-forest/10"
                        data-target="{{ $item['id'] }}"
                    >
                        <span class="leading-snug group-hover:translate-x-0.5 transition-transform">{{ $item['title'] }}</span>
                        <svg class="w-4 h-4 text-stone-400 group-hover:text-forest transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                @endforeach
            </div>

            <div class="px-4 py-2 bg-stone-50/70 border-t border-stone-100 text-center sm:hidden text-[11px] text-stone-400">
                9 Standar Pelayanan Tersedia
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sopItems = document.querySelectorAll('.sop-item');
            const tocBtn = document.getElementById('toc-floating-btn');
            const tocModalWrapper = document.getElementById('toc-modal-wrapper');
            const tocModal = document.getElementById('toc-modal');
            const tocOverlay = document.getElementById('toc-overlay');
            const tocCloseBtn = document.getElementById('toc-close-btn');
            const tocNavItems = document.querySelectorAll('.toc-nav-item');

            function toggleItem(item, shouldOpen) {
                const content = item.querySelector('.sop-content');
                const icon = item.querySelector('.sop-icon');
                if (!content || !icon) return;

                const isOpen = content.style.gridTemplateRows === '1fr';
                const openState = typeof shouldOpen === 'boolean' ? shouldOpen : !isOpen;

                sopItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        const otherContent = otherItem.querySelector('.sop-content');
                        const otherIcon = otherItem.querySelector('.sop-icon');
                        if (otherContent) {
                            otherContent.style.gridTemplateRows = '0fr';
                            otherContent.style.opacity = '0';
                        }
                        if (otherIcon) {
                            otherIcon.classList.remove('rotate-45');
                        }
                    }
                });

                if (openState) {
                    content.style.gridTemplateRows = '1fr';
                    content.style.opacity = '1';
                    icon.classList.add('rotate-45');
                } else {
                    content.style.gridTemplateRows = '0fr';
                    content.style.opacity = '0';
                    icon.classList.remove('rotate-45');
                }
            }

            sopItems.forEach(item => {
                const toggle = item.querySelector('.sop-toggle');
                if (toggle) {
                    toggle.addEventListener('click', (e) => {
                        e.preventDefault();
                        const content = item.querySelector('.sop-content');
                        const isCurrentlyOpen = content && content.style.gridTemplateRows === '1fr';
                        toggleItem(item, !isCurrentlyOpen);
                    });
                }
            });

            function openToc() {
                if (!tocModal || !tocOverlay) return;
                tocOverlay.classList.remove('opacity-0', 'pointer-events-none');
                if (tocModalWrapper) tocModalWrapper.classList.remove('pointer-events-none');
                tocModal.classList.remove('opacity-0', 'translate-y-8', 'sm:scale-95', 'pointer-events-none');
                tocModal.classList.add('translate-y-0', 'sm:scale-100', 'pointer-events-auto');
                if (tocBtn) tocBtn.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }

            function closeToc() {
                if (!tocModal || !tocOverlay) return;
                tocOverlay.classList.add('opacity-0', 'pointer-events-none');
                if (tocModalWrapper) tocModalWrapper.classList.add('pointer-events-none');
                tocModal.classList.add('opacity-0', 'translate-y-8', 'sm:scale-95', 'pointer-events-none');
                tocModal.classList.remove('translate-y-0', 'sm:scale-100', 'pointer-events-auto');
                if (tocBtn) tocBtn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            if (tocBtn) {
                tocBtn.addEventListener('click', openToc);
            }
            if (tocCloseBtn) {
                tocCloseBtn.addEventListener('click', closeToc);
            }
            if (tocOverlay) {
                tocOverlay.addEventListener('click', closeToc);
            }
            if (tocModalWrapper) {
                tocModalWrapper.addEventListener('click', (e) => {
                    if (e.target === tocModalWrapper) {
                        closeToc();
                    }
                });
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && tocModal && !tocModal.classList.contains('pointer-events-none')) {
                    closeToc();
                }
            });

            tocNavItems.forEach(navItem => {
                navItem.addEventListener('click', () => {
                    const targetId = navItem.getAttribute('data-target');
                    const targetEl = document.getElementById(targetId);
                    closeToc();

                    if (targetEl && targetEl.classList.contains('sop-item')) {
                        toggleItem(targetEl, true);
                        setTimeout(() => {
                            targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            targetEl.classList.add('ring-2', 'ring-forest', 'ring-offset-2');
                            setTimeout(() => {
                                targetEl.classList.remove('ring-2', 'ring-forest', 'ring-offset-2');
                            }, 1500);
                        }, 200);
                    }
                });
            });

            if (window.location.hash) {
                const targetEl = document.querySelector(window.location.hash);
                if (targetEl && targetEl.classList.contains('sop-item')) {
                    toggleItem(targetEl, true);
                    setTimeout(() => {
                        targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 200);
                }
            }
        });
    </script>
    @endpush
</x-layouts.app>
