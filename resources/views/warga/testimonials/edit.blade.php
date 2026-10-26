<x-layouts.warga title="Edit Testimoni - Dasbor Warga" headerTitle="Perbarui Testimoni">

    <div class="mb-5">
        <h1 class="font-serif text-2xl font-bold text-stone-900">Perbarui Testimoni</h1>
    </div>

    @if($testimonial->rejection_reason)
        <div class="mb-5 p-4 sm:p-5 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-sans w-full shadow-2xs">
            <div class="flex items-center gap-2 font-bold mb-1.5 text-rose-800">
                <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span class="text-base font-serif">Catatan Redaksi (Perlu Revisi)</span>
            </div>
            <p class="leading-relaxed pl-7 text-rose-800 bg-white/70 p-3 rounded-lg border border-rose-200/60 font-serif italic mb-2">
                "{{ $testimonial->rejection_reason }}"
            </p>
            <p class="text-xs text-rose-600 pl-7">
                Silakan sesuaikan data dan pesan testimoni Anda sesuai catatan di atas, kemudian klik <strong>Simpan Perubahan</strong> untuk diajukan kembali ke tim kurasi redaksi.
            </p>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-stone-200 shadow-2xs p-5 sm:p-7 w-full">
        <form action="{{ route('warga.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200 flex items-center gap-3.5">
                <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}" class="w-10 h-10 rounded-full object-cover border border-stone-200 flex-shrink-0">
                <div>
                    <span class="font-bold text-sm text-stone-900 block leading-tight">{{ $testimonial->name }}</span>
                    <span class="text-sm text-stone-500">Avatar testimoni yang saat ini tersimpan</span>
                </div>
            </div>

            <div>
                <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                    Keterangan Aktivitas Saat Ini <span class="text-terracotta">*</span>
                </label>
                <input type="text" name="role_subtitle" value="{{ old('role_subtitle', $testimonial->role_subtitle) }}" required class="form-input text-sm">
            </div>

            <div>
                <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                    Ganti Foto Avatar (Opsional)
                </label>
                <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-stone-100 file:text-stone-700 hover:file:bg-forest hover:file:text-white file:transition-colors cursor-pointer border border-stone-200 rounded-xl p-1 bg-white">
                <span class="text-sm text-stone-400 block mt-1">Kosongkan jika tidak ingin mengubah foto avatar.</span>
            </div>

            <div x-data="{ text: @js(old('content', $testimonial->content)), max: 300 }">
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider">
                        Pesan & Kesan Testimoni <span class="text-terracotta">*</span>
                    </label>
                    <span class="text-xs font-semibold" :class="text.length > 270 ? (text.length >= max ? 'text-rose-600 font-bold' : 'text-amber-600') : 'text-stone-400'">
                        <span x-text="text.length"></span>/300 karakter
                    </span>
                </div>
                <textarea name="content" x-model="text" maxlength="300" rows="4" required class="form-input leading-relaxed text-sm @error('content') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror"></textarea>
                @error('content')
                    <span class="text-xs text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                @else
                    <span class="text-xs text-stone-400 mt-1 block">Maksimal 300 karakter agar tampilan kutipan tetap ringkas dan elegan di beranda.</span>
                @enderror
            </div>

            <div class="pt-5 border-t border-stone-200 flex justify-between items-center gap-3">
                <button type="button" onclick="window.confirmDelete('{{ route('warga.testimonials.destroy', $testimonial->id) }}', 'Yakin ingin menghapus testimoni ini?')" class="text-sm text-red-600 font-bold tracking-wider hover:underline flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    <span>Hapus</span>
                </button>

                <div class="flex items-center gap-2.5">
                    <a href="{{ route('warga.testimonials.index') }}" class="px-5 py-2.5 rounded-xl border border-stone-300 text-stone-600 text-sm font-bold tracking-wider hover:bg-stone-50 transition-colors cursor-pointer">
                        Batal
                    </a>
                    <button type="submit" class="bg-forest text-white px-6 py-2.5 rounded-xl text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-2xs cursor-pointer">
                        {{ $testimonial->rejection_reason ? 'Simpan & Ajukan Kembali' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-layouts.warga>
