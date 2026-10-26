<x-layouts.admin title="Edit Halaman Statis - Dasbor Pengelola" headerTitle="Edit Halaman">

    <div class="mb-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 font-sans">
        <div>
            <div class="flex items-center gap-2 text-xs text-stone-500 mb-1">
                <a href="{{ route('admin.pages.index') }}" class="hover:text-forest transition-colors">Manajemen Halaman</a>
                <span>/</span>
                <span>Edit Halaman</span>
            </div>
            <h1 class="font-serif text-2xl text-stone-900 font-bold">Edit: {{ $page->title }}</h1>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ $page->public_url }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs sm:text-sm font-bold tracking-wider transition-colors inline-flex items-center gap-1.5" title="Buka Halaman Langsung">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Lihat Langsung</span>
            </a>
            <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 rounded-xl border border-stone-300 text-stone-700 hover:bg-stone-50 text-xs sm:text-sm font-bold tracking-wider transition-colors inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    @if($page->is_system)
        <div class="mb-5 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-900 text-xs sm:text-sm font-sans flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <strong class="font-bold">Halaman Sistem Bawaan:</strong>
                <p class="text-xs text-blue-800 mt-0.5">Halaman ini merupakan bagian dari struktur navigasi inti portal sekolah. URL slug dikunci demi menjaga kestabilan tautan situs, namun Anda bebas mengubah judul, deskripsi, dan konten halaman sesuai kebutuhan.</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-stone-200 shadow-2xs p-5 sm:p-8 font-sans w-full"
        x-data="{
            title: @js(old('title', $page->title)),
            slug: @js(old('slug', $page->slug)),
            insertTag(tag, closeTag = '') {
                const textarea = this.$refs.contentArea;
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const selected = textarea.value.substring(start, end);
                const replacement = tag + selected + closeTag;
                textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
                textarea.focus();
                textarea.selectionStart = start + tag.length;
                textarea.selectionEnd = start + tag.length + selected.length;
            }
        }">

        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                    Judul Halaman <span class="text-terracotta">*</span>
                </label>
                <input type="text" name="title" x-model="title" required class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest @error('title') border-rose-400 @enderror">
                @error('title')
                    <span class="text-xs text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                    URL Slug @if($page->is_system) (Terkunci) @else <span class="text-terracotta">*</span> @endif
                </label>
                <div class="flex rounded-xl shadow-2xs border border-stone-200 overflow-hidden {{ $page->is_system ? 'bg-stone-50' : 'focus-within:border-forest focus-within:ring-1 focus-within:ring-forest' }}">
                    <span class="inline-flex items-center px-3 text-xs bg-stone-100 text-stone-500 border-r border-stone-200">
                        {{ url('/') }}/
                    </span>
                    <input type="text" name="slug" x-model="slug" {{ $page->is_system ? 'readonly' : '' }} class="w-full px-3 py-2.5 text-sm border-0 focus:ring-0 {{ $page->is_system ? 'bg-stone-50 text-stone-500 cursor-not-allowed' : '' }}">
                </div>
                @error('slug')
                    <span class="text-xs text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                @endif
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                    Deskripsi Singkat / Ringkasan SEO (Opsional)
                </label>
                <textarea name="meta_description" rows="2" placeholder="Ringkasan penjelasan halaman untuk pencarian Google..." class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-forest leading-relaxed">{{ old('meta_description', $page->meta_description) }}</textarea>
                @error('meta_description')
                    <span class="text-xs text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700">
                        Konten Halaman (HTML / Teks) <span class="text-terracotta">*</span>
                    </label>
                    <span class="text-xs text-stone-400">Mendukung format HTML dan teks kaya</span>
                </div>

                <div class="border border-stone-200 rounded-xl overflow-hidden bg-white">
                    <div class="flex flex-wrap items-center gap-1 p-2 bg-stone-50 border-b border-stone-200 text-xs">
                        <button type="button" @click="insertTag('<h2>', '</h2>')" class="px-2.5 py-1 rounded bg-white hover:bg-stone-200 text-stone-700 border border-stone-200 font-bold" title="Heading 2">H2</button>
                        <button type="button" @click="insertTag('<h3>', '</h3>')" class="px-2.5 py-1 rounded bg-white hover:bg-stone-200 text-stone-700 border border-stone-200 font-bold" title="Heading 3">H3</button>
                        <button type="button" @click="insertTag('<strong>', '</strong>')" class="px-2.5 py-1 rounded bg-white hover:bg-stone-200 text-stone-700 border border-stone-200 font-bold" title="Tebal">B</button>
                        <button type="button" @click="insertTag('<em>', '</em>')" class="px-2.5 py-1 rounded bg-white hover:bg-stone-200 text-stone-700 border border-stone-200 italic font-bold" title="Miring">I</button>
                        <button type="button" @click="insertTag('<p>', '</p>')" class="px-2.5 py-1 rounded bg-white hover:bg-stone-200 text-stone-700 border border-stone-200" title="Paragraf">P</button>
                        <button type="button" @click="insertTag('<ul>\n  <li>', '</li>\n</ul>')" class="px-2.5 py-1 rounded bg-white hover:bg-stone-200 text-stone-700 border border-stone-200" title="Daftar Poin">Bullet List</button>
                        <button type="button" @click="insertTag('<ol>\n  <li>', '</li>\n</ol>')" class="px-2.5 py-1 rounded bg-white hover:bg-stone-200 text-stone-700 border border-stone-200" title="Daftar Angka">Numbered List</button>
                        <button type="button" @click="insertTag('<blockquote>', '</blockquote>')" class="px-2.5 py-1 rounded bg-white hover:bg-stone-200 text-stone-700 border border-stone-200" title="Kutipan">Quote</button>
                        <button type="button" @click="insertTag('<a href=\'#\'>', '</a>')" class="px-2.5 py-1 rounded bg-white hover:bg-stone-200 text-stone-700 border border-stone-200" title="Tautan">Link</button>
                    </div>

                    <textarea name="content" x-ref="contentArea" rows="14" required class="w-full p-4 text-sm font-sans leading-relaxed border-0 focus:ring-0 resize-y">{{ old('content', $page->content) }}</textarea>
                </div>
                @error('content')
                    <span class="text-xs text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="p-4 rounded-xl bg-stone-50 border border-stone-200 flex items-center justify-between">
                <div>
                    <span class="font-bold text-sm text-stone-900 block">Status Publikasi</span>
                    <span class="text-xs text-stone-500">Jika aktif, halaman dapat diakses langsung oleh pengunjung portal.</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-forest"></div>
                </label>
            </div>

            <div class="pt-5 border-t border-stone-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 rounded-xl border border-stone-300 text-stone-600 text-sm font-bold tracking-wider hover:bg-stone-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-forest text-white px-6 py-2.5 rounded-xl text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-2xs cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</x-layouts.admin>
