<x-layouts.warga title="Tulis Testimoni - Dasbor Warga" headerTitle="Tulis Testimoni">

    <div class="mb-5">
        <h1 class="font-serif text-2xl font-bold text-stone-900">Tulis Testimoni</h1>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-2xs p-5 sm:p-7 w-full">
        <form action="{{ route('warga.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="p-3.5 rounded-xl bg-amber-50/80 border border-amber-200/80 flex items-start gap-2.5 text-xs text-amber-950">
                <svg class="w-4 h-4 text-amber-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <div>
                    <strong>Perhatian:</strong> Setiap alumni hanya memiliki <strong>1 kali kesempatan</strong> untuk membuat testimoni. Begitu dikirimkan, testimoni akan terkunci permanen dan tidak dapat diedit atau dihapus. Pastikan data yang Anda tulis sudah benar.
                </div>
            </div>

            <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200 flex items-center gap-3.5">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border border-stone-200 flex-shrink-0">
                <div>
                    <span class="font-bold text-sm text-stone-900 block leading-tight">{{ $user->name }}</span>
                    <span class="text-sm text-stone-500">{{ $user->role_detail }} &bull; {{ $user->email }}</span>
                </div>
            </div>

            <div>
                <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                    Keterangan Aktivitas Saat Ini <span class="text-terracotta">*</span>
                </label>
                <input type="text" name="role_subtitle" value="{{ old('role_subtitle', $user->pekerjaan_kampus ? ($user->tahun_lulus ? 'Alumni ' . $user->tahun_lulus . ' • ' . $user->pekerjaan_kampus : $user->pekerjaan_kampus) : '') }}" required placeholder="Contoh: Alumni 2021 • Mahasiswa Kedokteran UI / Software Engineer" class="form-input text-sm">
                <span class="text-sm text-stone-400 block mt-1">Keterangan ini akan tercetak di bawah nama Anda pada beranda website.</span>
            </div>

            <div>
                <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                    Foto Avatar Kustom (Opsional)
                </label>
                <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-stone-100 file:text-stone-700 hover:file:bg-forest hover:file:text-white file:transition-colors cursor-pointer border border-stone-200 rounded-xl p-1 bg-white">
                <span class="text-sm text-stone-400 block mt-1">Kosongkan jika ingin menggunakan foto avatar profil Anda saat ini.</span>
            </div>

            <div x-data="{ text: @js(old('content', '')), max: 300 }">
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider">
                        Pesan & Kesan Testimoni <span class="text-terracotta">*</span>
                    </label>
                    <span class="text-xs font-semibold" :class="text.length > 270 ? (text.length >= max ? 'text-rose-600 font-bold' : 'text-amber-600') : 'text-stone-400'">
                        <span x-text="text.length"></span>/300 karakter
                    </span>
                </div>
                <textarea name="content" x-model="text" maxlength="300" rows="4" required placeholder="Tuliskan pengalaman berharga, bimbingan guru, suasana belajar, atau pesan semangat untuk adik-adik kelas di SMAN 1 Malingping..." class="form-input leading-relaxed text-sm @error('content') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror"></textarea>
                @error('content')
                    <span class="text-xs text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                @else
                    <span class="text-xs text-stone-400 mt-1 block">Maksimal 300 karakter agar tampilan kutipan tetap ringkas dan elegan di beranda.</span>
                @enderror
            </div>

            <div class="pt-5 border-t border-stone-200 flex justify-end gap-2.5">
                <a href="{{ route('warga.testimonials.index') }}" class="px-5 py-2.5 rounded-xl border border-stone-300 text-stone-600 text-sm font-bold tracking-wider hover:bg-stone-50 transition-colors cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="bg-forest text-white px-6 py-2.5 rounded-xl text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-2xs cursor-pointer">
                    Kirim Testimoni
                </button>
            </div>
        </form>
    </div>

</x-layouts.warga>
