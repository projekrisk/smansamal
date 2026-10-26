<x-layouts.admin title="Edit Pengumuman - Dasbor Pengelola" headerTitle="Edit Pengumuman">

    <div class="mb-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 font-sans">
        <div>
            <h1 class="font-serif text-2xl text-stone-900 font-bold">Edit Pengumuman</h1>
        </div>
        <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 rounded-xl border border-stone-300 text-stone-700 hover:bg-stone-50 text-sm sm:text-sm font-bold tracking-wider transition-colors inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-stone-200 shadow-2xs p-5 sm:p-8 font-sans w-full"
        x-data="{
            existingImage: @js($announcement->image_url),
            removeImage: false,
            newImagePreview: null,
            fileChosen(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => { this.newImagePreview = e.target.result; };
                reader.readAsDataURL(file);
                this.removeImage = false;
            }
        }">

        <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <input type="hidden" name="remove_image" :value="removeImage ? '1' : '0'">

            <div>
                <label class="block text-sm font-bold tracking-wider text-stone-700 mb-1.5">
                    Judul Pengumuman <span class="text-terracotta">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required placeholder="Contoh: Pembukaan SPMB / PPDB Tahun Ajaran Baru" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest @error('title') border-rose-400 @enderror">
                @error('title')
                    <span class="text-sm text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold tracking-wider text-stone-700 mb-2">
                    Model Tampilan Pengumuman <span class="text-terracotta">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="relative flex items-start gap-3 p-3.5 rounded-xl border border-stone-200 bg-stone-50/50 hover:bg-stone-50 cursor-pointer transition-colors has-[:checked]:border-forest has-[:checked]:bg-forest/5 has-[:checked]:ring-1 has-[:checked]:ring-forest">
                        <input type="radio" name="type" value="popup" {{ old('type', $announcement->type ?? 'popup') === 'popup' ? 'checked' : '' }} class="mt-1 text-forest focus:ring-forest">
                        <div>
                            <span class="block text-sm font-bold text-stone-900">Popup Saat Halaman Dibuka</span>
                            <span class="block text-xs text-stone-500 mt-0.5">Otomatis muncul berupa modal popup di tengah layar saat pengunjung membuka website (misal: pengumuman darurat, libur, info ujian).</span>
                        </div>
                    </label>

                    <label class="relative flex items-start gap-3 p-3.5 rounded-xl border border-stone-200 bg-stone-50/50 hover:bg-stone-50 cursor-pointer transition-colors has-[:checked]:border-forest has-[:checked]:bg-forest/5 has-[:checked]:ring-1 has-[:checked]:ring-forest">
                        <input type="radio" name="type" value="floating" {{ old('type', $announcement->type ?? 'popup') === 'floating' ? 'checked' : '' }} class="mt-1 text-forest focus:ring-forest">
                        <div>
                            <span class="block text-sm font-bold text-stone-900">Pengumuman Melayang (Sebelah Kiri)</span>
                            <span class="block text-xs text-stone-500 mt-0.5">Tampil sebagai tombol mengambang di kiri bawah (seperti Survei Kepuasan Masyarakat), popup muncul saat diklik.</span>
                        </div>
                    </label>

                    <label class="relative flex items-start gap-3 p-3.5 rounded-xl border border-stone-200 bg-stone-50/50 hover:bg-stone-50 cursor-pointer transition-colors has-[:checked]:border-forest has-[:checked]:bg-forest/5 has-[:checked]:ring-1 has-[:checked]:ring-forest sm:col-span-2">
                        <input type="radio" name="type" value="both" {{ old('type', $announcement->type ?? 'popup') === 'both' ? 'checked' : '' }} class="mt-1 text-forest focus:ring-forest">
                        <div>
                            <span class="block text-sm font-bold text-stone-900">Keduanya (Popup Otomatis & Tombol Melayang)</span>
                            <span class="block text-xs text-stone-500 mt-0.5">Muncul otomatis saat halaman dibuka dan tetap tersedia tombol melayang di kiri bawah.</span>
                        </div>
                    </label>
                </div>
                @error('type')
                    <span class="text-sm text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold tracking-wider text-stone-700 mb-1.5">
                    Teks Informasi / Pesan Pengumuman
                </label>
                <textarea name="content" rows="4" placeholder="Tuliskan rincian pengumuman, pengantar informasi, atau pengingat penting bagi pengunjung..." class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest @error('content') border-rose-400 @enderror">{{ old('content', $announcement->content) }}</textarea>
                <p class="text-[11px] text-stone-500 mt-1">Dapat dikosongkan jika pengumuman hanya berupa poster atau gambar berukuran penuh.</p>
                @error('content')
                    <span class="text-sm text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold tracking-wider text-stone-700 mb-1.5">
                    Gambar / Banner Pengumuman (Opsional)
                </label>

                <template x-if="existingImage && !removeImage && !newImagePreview">
                    <div class="mb-3 relative inline-block">
                        <img :src="existingImage" alt="Gambar Saat Ini" class="max-h-56 rounded-xl border border-stone-200 shadow-xs object-cover">
                        <button type="button" @click="removeImage = true" class="absolute -top-2 -right-2 bg-rose-600 text-white rounded-full p-1 shadow-md hover:bg-rose-700 focus:outline-none" title="Hapus Gambar">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>

                <template x-if="newImagePreview">
                    <div class="mb-3 relative inline-block">
                        <img :src="newImagePreview" alt="Pratinjau Gambar Baru" class="max-h-56 rounded-xl border border-stone-200 shadow-xs object-cover">
                        <button type="button" @click="newImagePreview = null; $el.closest('form').querySelector('input[type=file]').value = ''" class="absolute -top-2 -right-2 bg-rose-600 text-white rounded-full p-1 shadow-md hover:bg-rose-700 focus:outline-none" title="Batal Gambar Baru">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>

                <div class="mt-1 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-stone-700 hover:bg-stone-100 text-sm sm:text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span x-text="existingImage && !removeImage ? 'Ganti Berkas Gambar' : 'Pilih Berkas Gambar'">Pilih Berkas</span>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/jpg" @change="fileChosen" class="hidden">
                    </label>
                    <span class="text-sm text-stone-400">Format: JPG, PNG, WEBP. Maksimal 3MB.</span>
                </div>
                @error('image')
                    <span class="text-sm text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 pt-3 border-t border-stone-100">
                <div>
                    <label class="block text-sm font-bold tracking-wider text-stone-700 mb-1.5">
                        Teks Tombol Aksi (Opsional)
                    </label>
                    <input type="text" name="button_text" value="{{ old('button_text', $announcement->button_text) }}" placeholder="Contoh: Daftar Sekarang, Lihat Selengkapnya" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest @error('button_text') border-rose-400 @enderror">
                    @error('button_text')
                        <span class="text-sm text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold tracking-wider text-stone-700 mb-1.5">
                        URL / Tautan Tombol (Opsional)
                    </label>
                    <input type="url" name="button_url" value="{{ old('button_url', $announcement->button_url) }}" placeholder="Contoh: https://spmb.bantenprov.go.id atau https://..." class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest @error('button_url') border-rose-400 @enderror">
                    @error('button_url')
                        <span class="text-sm text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 pt-3 border-t border-stone-100">
                <div>
                    <label class="block text-sm font-bold tracking-wider text-stone-700 mb-1.5">
                        Mulai Tayang (Opsional)
                    </label>
                    <input type="datetime-local" name="start_at" value="{{ old('start_at', $announcement->start_at?->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest @error('start_at') border-rose-400 @enderror">
                    <p class="text-[11px] text-stone-400 mt-1">Kosongkan jika langsung ingin ditayangkan sekarang.</p>
                    @error('start_at')
                        <span class="text-sm text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold tracking-wider text-stone-700 mb-1.5">
                        Berakhir Tayang (Opsional)
                    </label>
                    <input type="datetime-local" name="end_at" value="{{ old('end_at', $announcement->end_at?->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest @error('end_at') border-rose-400 @enderror">
                    <p class="text-[11px] text-stone-400 mt-1">Kosongkan jika tidak ada batas waktu penayangan.</p>
                    @error('end_at')
                        <span class="text-sm text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="pt-3 border-t border-stone-100">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $announcement->is_active ? '1' : '0') == '1' ? 'checked' : '' }} class="w-4 h-4 text-forest rounded focus:ring-forest border-stone-300">
                    <div>
                        <span class="text-sm sm:text-sm font-bold text-stone-800">Aktifkan Pengumuman Langsung</span>
                        <p class="text-[11px] text-stone-500">Pengumuman akan langsung tampil sebagai popup di seluruh halaman publik sekolah.</p>
                    </div>
                </label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-stone-100">
                <a href="{{ route('admin.announcements.index') }}" class="px-5 py-2.5 rounded-xl border border-stone-300 text-stone-700 hover:bg-stone-50 text-sm sm:text-sm font-bold tracking-wider transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-forest hover:bg-stone-900 text-white text-sm sm:text-sm font-bold tracking-wider shadow-sm transition-colors cursor-pointer">
                    Perbarui
                </button>
            </div>
        </form>
    </div>

</x-layouts.admin>
