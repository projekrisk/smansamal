<x-layouts.admin title="Pengaturan Mode Pemeliharaan - SMAN 1 Malingping" headerTitle="Pengaturan Mode Pemeliharaan">

    <form id="maintenance-form" action="{{ route('admin.maintenance.update') }}" method="POST">
        @csrf

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div>
                <h1 class="font-serif text-2xl text-stone-900 font-bold">Mode Pemeliharaan (Maintenance)</h1>
                <p class="text-xs text-stone-500 mt-1 font-sans">Kelola status dan tampilan halaman pemeliharaan saat sistem sedang diperbarui.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.maintenance.preview') }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-stone-200 text-stone-700 font-sans text-sm font-semibold hover:bg-stone-50 hover:text-stone-900 transition-colors shadow-2xs">
                    <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Pratinjau Halaman</span>
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-forest text-white font-sans text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-sans text-sm flex items-center justify-between gap-3 shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if($settings['is_currently_active'])
            <div class="mb-6 p-5 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-900 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm">
                <div class="flex items-start md:items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-md">
                        <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                            <h2 class="font-bold text-base text-amber-950">STATUS: Mode Pemeliharaan Sedang AKTIF</h2>
                        </div>
                        <p class="text-xs text-amber-800 mt-0.5">
                            Pengunjung umum saat ini melihat halaman pemeliharaan. Anda dan pengelola lain yang sudah login tetap memiliki akses penuh ke portal sekolah.
                        </p>
                        @if($settings['env_maintenance_enabled'])
                            <p class="text-[11px] font-semibold text-amber-900 mt-1 bg-amber-200/60 inline-block px-2 py-0.5 rounded">
                                ℹ️ Mode ini juga sedang dipaksa aktif melalui file konfigurasi <code>.env</code> (<code>APP_MAINTENANCE=true</code>).
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between gap-3 shadow-2xs">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 flex-shrink-0"></span>
                    <div>
                        <span class="font-bold text-sm text-emerald-950">STATUS: Website Berjalan Normal (Publik)</span>
                        <p class="text-xs text-emerald-800">Semua halaman dapat diakses oleh publik dan pengunjung secara langsung.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl border border-stone-200 shadow-2xs overflow-hidden">
                    <div class="px-5 py-4 border-b border-stone-100 flex items-center justify-between bg-stone-50/70">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full {{ $settings['maintenance_enabled'] ? 'bg-amber-500' : 'bg-stone-300' }}"></span>
                            <h2 class="font-sans font-bold text-sm text-stone-900">Saklar Pemeliharaan (Database)</h2>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="maintenance_enabled" value="1" class="sr-only peer" {{ $settings['maintenance_enabled'] ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                            <span class="ml-2.5 text-sm font-bold text-stone-700">{{ $settings['maintenance_enabled'] ? 'Aktif' : 'Nonaktif' }}</span>
                        </label>
                    </div>

                    <div class="p-5 space-y-4">
                        <p class="text-xs text-stone-500 leading-relaxed">
                            Aktifkan opsi ini saat Anda hendak melakukan migrasi data, perbaikan tampilan, atau pemeliharaan server secara langsung dari Dasbor Admin tanpa menyentuh file server.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-stone-200 shadow-2xs overflow-hidden">
                    <div class="px-5 py-4 border-b border-stone-100 bg-stone-50/70">
                        <h2 class="font-sans font-bold text-sm text-stone-900">Teks & Informasi Halaman Pemeliharaan</h2>
                    </div>

                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block font-bold text-xs text-stone-700 uppercase tracking-wider mb-1.5">
                                Judul Halaman Pemeliharaan
                            </label>
                            <input type="text" name="maintenance_title" value="{{ old('maintenance_title', $settings['maintenance_title']) }}" placeholder="Contoh: Situs Sedang Dalam Pemeliharaan" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 bg-stone-50 focus:bg-white focus:outline-none focus:border-forest text-sm font-medium text-stone-800 transition-colors">
                            <span class="text-[11px] text-stone-400 mt-1 block">Judul utama yang tampil besar di layar pengunjung.</span>
                        </div>

                        <div>
                            <label class="block font-bold text-xs text-stone-700 uppercase tracking-wider mb-1.5">
                                Pesan / Penjelasan untuk Pengunjung
                            </label>
                            <textarea name="maintenance_message" rows="4" placeholder="Tuliskan alasan pemeliharaan dan himbauan untuk pengunjung..." class="w-full p-3.5 rounded-xl border border-stone-200 bg-stone-50 focus:bg-white focus:outline-none focus:border-forest text-sm text-stone-800 leading-relaxed transition-colors resize-y">{{ old('maintenance_message', $settings['maintenance_message']) }}</textarea>
                            <span class="text-[11px] text-stone-400 mt-1 block">Jelaskan secara ramah agar siswa, guru, dan masyarakat memahami proses pemeliharaan.</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block font-bold text-xs text-stone-700 uppercase tracking-wider mb-1.5">
                                    Perkiraan Waktu Selesai (Opsional)
                                </label>
                                <input type="text" name="maintenance_end_time" value="{{ old('maintenance_end_time', $settings['maintenance_end_time']) }}" placeholder="Contoh: 27 Oktober 2026, 15:00 WIB" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 bg-stone-50 focus:bg-white focus:outline-none focus:border-forest text-sm font-medium text-stone-800 transition-colors">
                                <span class="text-[11px] text-stone-400 mt-1 block">Akan ditampilkan pada lencana waktu di halaman pemeliharaan.</span>
                            </div>

                            <div>
                                <label class="block font-bold text-xs text-stone-700 uppercase tracking-wider mb-1.5">
                                    Kunci Akses Bypass Rahasia (Opsional)
                                </label>
                                <input type="text" name="maintenance_secret" value="{{ old('maintenance_secret', $settings['maintenance_secret']) }}" placeholder="Contoh: review-2026" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 bg-stone-50 focus:bg-white focus:outline-none focus:border-forest text-sm font-mono text-stone-800 transition-colors">
                                <span class="text-[11px] text-stone-400 mt-1 block">Akses tanpa login melalui parameter <code>?bypass=kunci_rahasia</code>.</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-6">

                <div class="bg-stone-900 text-stone-200 rounded-2xl border border-stone-800 p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <h3 class="font-serif text-base font-bold text-white">Pengaturan via File .env</h3>
                    </div>
                    <p class="text-xs text-stone-400 leading-relaxed mb-4">
                        Selain melalui tombol di halaman ini, Anda juga dapat mengontrol mode pemeliharaan langsung melalui file <code>.env</code> di server:
                    </p>

                    <div class="p-3.5 rounded-xl bg-stone-950 border border-stone-800 font-mono text-xs text-emerald-400 space-y-1 overflow-x-auto leading-relaxed">
                        <div class="text-stone-500"># Aktifkan mode pemeliharaan</div>
                        <div>APP_MAINTENANCE=true</div>
                        <br>
                        <div class="text-stone-500"># Kustomisasi teks (opsional)</div>
                        <div>MAINTENANCE_TITLE="Pemeliharaan Sistem"</div>
                        <div>MAINTENANCE_MESSAGE="Situs sedang diperbarui..."</div>
                        <div>MAINTENANCE_END_TIME="Pukul 14:00 WIB"</div>
                        <div>MAINTENANCE_SECRET="token-khusus"</div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-stone-800 text-xs text-stone-400 space-y-2">
                        <p><strong>Catatan Prioritas:</strong></p>
                        <ul class="list-disc list-inside space-y-1 text-stone-400">
                            <li>Jika <code>APP_MAINTENANCE=true</code> di <code>.env</code>, situs akan <strong>selalu aktif</strong> dalam mode pemeliharaan.</li>
                            <li>Jika <code>APP_MAINTENANCE=false</code> di <code>.env</code>, status ditentukan oleh tombol di halaman dasbor ini.</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-stone-200 p-5 shadow-2xs">
                    <h3 class="font-sans text-sm font-bold text-stone-900 mb-2">Akses Khusus Administrator</h3>
                    <p class="text-xs text-stone-600 leading-relaxed mb-3">
                        Saat mode pemeliharaan aktif:
                    </p>
                    <ul class="text-xs text-stone-600 space-y-2 list-disc list-inside">
                        <li>Halaman <code>/admin/login</code> dan seluruh area <code>/admin/*</code> tetap dapat dibuka.</li>
                        <li>Administrator yang sudah login dapat menjelajahi seluruh website publik tanpa terhalang.</li>
                        <li>Akan muncul banner informasi di bagian atas portal sekolah saat diakses oleh Administrator.</li>
                    </ul>
                </div>

            </div>

        </div>

    </form>

</x-layouts.admin>
