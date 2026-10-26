<x-layouts.admin title="Edit Artikel - Admin SMAN 1 Malingping" headerTitle="Edit Artikel">

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="w-full bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 shadow-none sm:shadow-2xs p-0 sm:p-5 font-sans">
        @csrf
        @method('PUT')

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5 pb-4 border-b border-stone-200">
            <div>
                <h1 class="font-serif text-2xl text-stone-900 font-bold tracking-tight">Edit Artikel</h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 rounded-xl border border-stone-300 text-stone-700 text-sm font-bold tracking-wider hover:bg-stone-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2 rounded-xl bg-forest text-white text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-xs">
                    <span>Simpan</span>
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-600 font-sans w-full">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

            <div class="lg:col-span-7 space-y-4">

                <div class="bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 p-0 sm:p-4 shadow-none sm:shadow-2xs space-y-3">
                    <div>
                        <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                            Judul Artikel <span class="text-terracotta">*</span>
                        </label>
                        <input type="text" name="title" id="article_title" value="{{ old('title', $article->title) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-sm sm:text-base font-medium focus:border-forest focus:ring-2 focus:ring-forest/10 outline-none transition-all bg-white text-stone-900">
                    </div>

                    <div>
                        <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                            Slug URL / Permalink
                        </label>
                        <div class="flex items-center rounded-xl border border-stone-200 bg-stone-50/60 overflow-hidden focus-within:border-forest focus-within:ring-2 focus-within:ring-forest/10 focus-within:bg-white transition-all">
                            <span class="px-3 text-sm text-stone-400 font-mono select-none bg-stone-100 border-r border-stone-200 py-2.5">/berita/</span>
                            <input type="text" name="slug" id="article_slug" value="{{ old('slug', $article->slug) }}" required class="w-full px-3 py-2.5 text-sm font-mono text-stone-800 bg-transparent outline-none">
                        </div>
                        <span class="text-sm text-stone-500 block mt-1">Mengubah slug akan mengubah tautan permanen artikel ini.</span>
                    </div>
                </div>

                <div class="bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 p-0 sm:p-4 shadow-none sm:shadow-2xs">
                    <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-2">
                        Ringkasan Singkat (Excerpt)
                    </label>
                    <textarea name="excerpt" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-2 focus:ring-forest/10 outline-none transition-all resize-none text-stone-800">{{ old('excerpt', $article->excerpt) }}</textarea>
                    <span class="text-sm text-stone-500 block mt-1.5">Ditampilkan pada cuplikan berita di halaman depan.</span>
                </div>

                <div class="bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 p-0 sm:p-4 shadow-none sm:shadow-2xs">
                    <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-2">
                        Isi Konten Artikel <span class="text-terracotta">*</span>
                    </label>
                    <x-rich-editor name="content" id="admin-article-edit-editor" :value="old('content', $article->content)" />
                </div>
            </div>

            <div class="lg:col-span-5 space-y-4">

                <div class="bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 shadow-none sm:shadow-2xs sm:overflow-hidden">
                    <div class="px-0 sm:px-4 py-1.5 sm:py-2.5 border-b border-stone-200 sm:border-stone-100 flex items-center justify-between bg-transparent sm:bg-stone-50/70">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-forest"></span>
                            <h2 class="font-sans font-bold text-sm text-stone-900">Status & Jadwal Publikasi</h2>
                        </div>
                    </div>

                    <div class="py-3 px-0 sm:p-4 space-y-3.5">

                        <div>
                            @php
                                $currentStatus = old('status', $article->status);
                            @endphp
                            <input type="hidden" name="status" id="input_status" value="{{ $currentStatus }}">

                            <div class="grid grid-cols-2 gap-2">
                                <button
                                    type="button"
                                    onclick="selectStatus('published')"
                                    id="status_btn_published"
                                    class="py-2 px-3 rounded-xl border-2 text-sm font-bold transition-all flex items-center justify-center gap-1.5 {{ $currentStatus === 'published' ? 'border-forest bg-forest text-white shadow-2xs' : 'border-stone-200 text-stone-600 hover:bg-stone-50 bg-white' }}"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    Terbitkan
                                </button>
                                <button
                                    type="button"
                                    onclick="selectStatus('draft')"
                                    id="status_btn_draft"
                                    class="py-2 px-3 rounded-xl border-2 text-sm font-bold transition-all flex items-center justify-center gap-1.5 {{ $currentStatus === 'draft' ? 'border-stone-800 bg-stone-800 text-white shadow-2xs' : 'border-stone-200 text-stone-600 hover:bg-stone-50 bg-white' }}"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    Draft
                                </button>
                                <button
                                    type="button"
                                    onclick="selectStatus('pending_review')"
                                    id="status_btn_pending_review"
                                    class="py-2 px-3 rounded-xl border-2 text-sm font-bold transition-all flex items-center justify-center gap-1.5 {{ $currentStatus === 'pending_review' ? 'border-amber-500 bg-amber-500 text-white shadow-2xs' : 'border-stone-200 text-stone-600 hover:bg-stone-50 bg-white' }}"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Review
                                </button>
                                <button
                                    type="button"
                                    onclick="selectStatus('rejected')"
                                    id="status_btn_rejected"
                                    class="py-2 px-3 rounded-xl border-2 text-sm font-bold transition-all flex items-center justify-center gap-1.5 {{ $currentStatus === 'rejected' ? 'border-red-600 bg-red-600 text-white shadow-2xs' : 'border-stone-200 text-stone-600 hover:bg-stone-50 bg-white' }}"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Ditolak
                                </button>
                            </div>
                        </div>

                        <div>
                            <input
                                type="datetime-local"
                                name="published_at"
                                id="published_at"
                                value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                                class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm font-medium focus:border-forest focus:ring-2 focus:ring-forest/10 outline-none transition-all bg-white text-stone-800"
                            >
                        </div>

                        <div class="pt-2 border-t border-stone-200 sm:border-stone-100">
                            <label class="flex items-center gap-3 cursor-pointer p-2 rounded-xl hover:bg-stone-100/60 sm:hover:bg-stone-50 transition-colors">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $article->is_featured) ? 'checked' : '' }} class="w-4 h-4 rounded border-stone-300 text-forest focus:ring-forest">
                                <div>
                                    <span class="font-sans text-sm font-bold text-stone-800 block">Sorotan Utama (Spotlight)</span>
                                    <span class="text-sm text-stone-500 block">Tampilkan di slider utama beranda.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="relative z-30 bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 shadow-none sm:shadow-2xs">
                    <div class="px-0 sm:px-4 py-1.5 sm:py-2.5 border-b border-stone-200 sm:border-stone-100 flex items-center justify-between bg-transparent sm:bg-stone-50/70">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h2 class="font-sans font-bold text-sm text-stone-900">Tipe & Kategori</h2>
                        </div>
                    </div>

                    <div class="py-3 px-0 sm:p-4 space-y-3.5">

                        <div>
                            <input type="hidden" name="type" id="input_type" value="{{ old('type', $article->type) }}">

                            <div class="grid grid-cols-2 gap-2">

                                <div
                                    onclick="selectType('jurnal')"
                                    id="type_card_jurnal"
                                    class="cursor-pointer p-2.5 rounded-xl border-2 transition-all flex items-start gap-2 bg-white {{ old('type', $article->type) === 'jurnal' ? 'border-forest bg-forest/5 shadow-2xs' : 'border-stone-200 hover:border-stone-300' }}"
                                >
                                    <div class="w-7 h-7 rounded-lg bg-forest/10 text-forest flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-sm text-stone-900 truncate">Jurnal Sekolah</span>
                                            <span id="check_jurnal" class="{{ old('type', $article->type) === 'jurnal' ? '' : 'hidden' }} text-forest">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            </span>
                                        </div>
                                        <p class="text-sm text-stone-500">Resmi</p>
                                    </div>
                                </div>

                                <div
                                    onclick="selectType('suara_warga')"
                                    id="type_card_suara_warga"
                                    class="cursor-pointer p-2.5 rounded-xl border-2 transition-all flex items-start gap-2 bg-white {{ old('type', $article->type) === 'suara_warga' ? 'border-terracotta bg-terracotta/5 shadow-2xs' : 'border-stone-200 hover:border-stone-300' }}"
                                >
                                    <div class="w-7 h-7 rounded-lg bg-terracotta/10 text-terracotta flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-sm text-stone-900 truncate">Suara Warga</span>
                                            <span id="check_suara_warga" class="{{ old('type', $article->type) === 'suara_warga' ? '' : 'hidden' }} text-terracotta">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            </span>
                                        </div>
                                        <p class="text-sm text-stone-500">Opini/Karya</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative" id="category_selector_container">
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider">
                                    Kategori Tulisan <span class="text-terracotta">*</span>
                                </label>
                                <button type="button" onclick="openQuickCategoryModal()" class="text-sm text-forest hover:text-stone-900 font-bold inline-flex items-center gap-1 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    + Tambah Baru
                                </button>
                            </div>

                            <input type="hidden" name="category_id" id="input_category_id" value="{{ old('category_id', $article->category_id) }}" required>

                            <button
                                type="button"
                                id="category_dropdown_btn"
                                onclick="toggleCategoryDropdown()"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 bg-white hover:border-stone-300 text-left flex items-center justify-between transition-colors focus:outline-none focus:border-forest focus:ring-2 focus:ring-forest/10"
                            >
                                <div class="flex items-center gap-2.5 truncate" id="category_selected_display">
                                    @php
                                        $selectedCat = $categories->firstWhere('id', old('category_id', $article->category_id));
                                    @endphp
                                    @if($selectedCat)
                                        <span class="w-3.5 h-3.5 rounded-full flex-shrink-0" style="background-color: {{ $selectedCat->color ?: '#2A5C43' }};"></span>
                                        <span class="text-sm font-semibold text-stone-900 truncate">{{ $selectedCat->name }}</span>
                                        <span class="text-sm text-stone-500 tracking-wider bg-stone-100 px-2 py-0.5 rounded-md ml-1 font-mono flex-shrink-0">({{ $selectedCat->type }})</span>
                                    @else
                                        <span class="text-sm text-stone-400">Pilih Kategori...</span>
                                    @endif
                                </div>
                                <svg class="w-4 h-4 text-stone-400 transition-transform duration-200 flex-shrink-0 ml-2" id="category_chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div id="category_dropdown_menu" class="hidden absolute left-0 right-0 mt-2 bg-white rounded-2xl shadow-xl border border-stone-200 z-50 overflow-hidden font-sans">
                                <div class="p-2.5 border-b border-stone-100 bg-stone-50">
                                    <input type="text" id="category_search_input" oninput="filterCategories(this.value)" placeholder="Ketik untuk mencari..." class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-sm focus:outline-none focus:border-forest bg-white">
                                </div>
                                <div class="max-h-56 overflow-y-auto divide-y divide-stone-50 no-scrollbar" id="categories_list_container">
                                    @foreach($categories as $cat)
                                        <div
                                            onclick="selectCategory('{{ $cat->id }}', '{{ addslashes($cat->name) }}', '{{ $cat->color ?: '#2A5C43' }}', '{{ $cat->type }}')"
                                            class="category-option p-2.5 px-3.5 flex items-center justify-between hover:bg-stone-50 cursor-pointer transition-colors"
                                            data-name="{{ strtolower($cat->name) }}"
                                        >
                                            <div class="flex items-center gap-2">
                                                <span class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $cat->color ?: '#2A5C43' }};"></span>
                                                <span class="text-sm font-semibold text-stone-800">{{ $cat->name }}</span>
                                            </div>
                                            <span class="text-sm text-stone-500 tracking-wider bg-stone-100 px-2 py-0.5 rounded font-mono">({{ $cat->type }})</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-stone-100">
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5 flex items-center justify-between">
                                <span>Tag / Label Karya <span class="text-stone-400 font-normal lowercase">(opsional)</span></span>
                            </label>
                            <input
                                type="text"
                                name="tags"
                                id="article_tags"
                                value="{{ old('tags', $article->tags_string) }}"
                                placeholder="Contoh: tugas-biologi, cerpen, literasi"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-2 focus:ring-forest/10 outline-none transition-all bg-white text-stone-900"
                            >
                            <p class="text-xs text-stone-500 mt-1 leading-relaxed">
                                Pisahkan tag dengan koma (,).
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 shadow-none sm:shadow-2xs sm:overflow-hidden">
                    <div class="px-0 sm:px-4 py-1.5 sm:py-2.5 border-b border-stone-200 sm:border-stone-100 flex items-center justify-between bg-transparent sm:bg-stone-50/70">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <h2 class="font-sans font-bold text-sm text-stone-900">Foto Sampul & Tampilan</h2>
                        </div>
                    </div>

                    <div class="py-3 px-0 sm:p-4 space-y-3.5">

                        @if($article->featured_image)
                            <div class="w-36 aspect-video rounded-xl overflow-hidden border border-stone-200 shadow-2xs">
                                <img src="{{ $article->featured_image_url }}" alt="Preview" class="w-full h-full object-cover">
                            </div>
                        @endif

                        <div>
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                                {{ $article->featured_image ? 'Ganti Foto Sampul' : '' }}
                            </label>
                            <input type="file" name="featured_image" accept="image/*" class="w-full text-sm text-stone-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-forest file:text-white hover:file:bg-stone-900 file:transition-colors cursor-pointer border border-stone-200 rounded-xl p-1 bg-white">
                            <span class="text-sm text-stone-500 block mt-1">Format JPG, PNG, WebP (Maks. 5MB).</span>
                        </div>

                        <div>
                            <input type="hidden" name="featured_image_mode" id="input_image_mode" value="{{ old('featured_image_mode', $article->featured_image_mode ?? 'normal') }}">

                            <div class="grid grid-cols-2 gap-2">
                                <div
                                    onclick="selectImageMode('normal')"
                                    id="mode_card_normal"
                                    class="cursor-pointer p-2.5 rounded-xl border-2 transition-all flex items-center gap-2 bg-white {{ old('featured_image_mode', $article->featured_image_mode ?? 'normal') === 'normal' ? 'border-forest bg-forest/5 shadow-2xs' : 'border-stone-200 hover:border-stone-300' }}"
                                >
                                    <div class="w-7 h-7 rounded-lg bg-stone-100 flex items-center justify-center flex-shrink-0 text-stone-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <span class="font-bold text-sm text-stone-900">Normal</span>
                                </div>

                                <div
                                    onclick="selectImageMode('full')"
                                    id="mode_card_full"
                                    class="cursor-pointer p-2.5 rounded-xl border-2 transition-all flex items-center gap-2 bg-white {{ old('featured_image_mode') === 'full' ? 'border-forest bg-forest/5 shadow-2xs' : 'border-stone-200 hover:border-stone-300' }}"
                                >
                                    <div class="w-7 h-7 rounded-lg bg-forest/10 flex items-center justify-center flex-shrink-0 text-forest">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                    </div>
                                    <span class="font-bold text-sm text-stone-900">Penuh</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                                Keterangan Gambar (Opsional)
                            </label>
                            <input type="text" name="featured_image_caption" value="{{ old('featured_image_caption', $article->featured_image_caption) }}" placeholder="Dokumentasi kegiatan..." class="w-full px-3 py-2 rounded-xl border border-stone-200 bg-white font-sans text-sm focus:outline-none focus:border-forest text-stone-800">
                        </div>
                    </div>
                </div>

                <div class="py-3 px-0 sm:p-3 bg-transparent sm:bg-stone-50 rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 flex items-center justify-end gap-2.5">
                    <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 rounded-xl border border-stone-300 text-stone-700 text-sm font-bold tracking-wider hover:bg-stone-100 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-forest text-white px-5 py-2 rounded-xl text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-xs">
                        Simpan
                    </button>
                </div>

            </div>
        </div>
    </form>

    <div id="quick_category_modal" class="fixed inset-0 z-[400] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 font-sans p-4">
        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm" onclick="closeQuickCategoryModal()"></div>
        <div class="bg-white rounded-2xl p-5 max-w-sm w-full relative z-10 shadow-xl transform scale-95 transition-transform duration-300">
            <h3 class="font-serif text-lg font-bold text-stone-900 mb-1">Tambah Kategori Cepat</h3>
            <p class="text-sm text-stone-500 mb-3">Kategori baru langsung tersedia untuk artikel ini.</p>

            <form id="quick_category_form" onsubmit="submitQuickCategory(event)" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1">Nama Kategori</label>
                    <input type="text" id="qc_name" required placeholder="Contoh: Literasi Digital" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:border-forest outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-2">Tipe Publikasi</label>
                    <input type="hidden" id="qc_type" value="both">
                    <div class="grid grid-cols-3 gap-2" id="qc_type_container">
                        <button type="button" onclick="setQcType('both', this)" class="qc-type-btn py-2 px-2 rounded-xl border-2 border-forest bg-forest/5 text-forest text-sm font-bold text-center transition-all">Keduanya</button>
                        <button type="button" onclick="setQcType('jurnal', this)" class="qc-type-btn py-2 px-2 rounded-xl border-2 border-stone-200 text-stone-600 hover:border-stone-300 text-sm font-semibold text-center transition-all">Jurnal</button>
                        <button type="button" onclick="setQcType('suara_warga', this)" class="qc-type-btn py-2 px-2 rounded-xl border-2 border-stone-200 text-stone-600 hover:border-stone-300 text-sm font-semibold text-center transition-all">Warga</button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1">Warna Aksen</label>
                    <input type="color" id="qc_color" value="#2A5C43" class="w-12 h-9 rounded-lg cursor-pointer border border-stone-200">
                </div>
                <div class="flex justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" onclick="closeQuickCategoryModal()" class="px-4 py-2 rounded-xl text-stone-600 text-sm font-semibold hover:bg-stone-100">Batal</button>
                    <button type="submit" class="bg-forest text-white text-sm font-bold px-5 py-2 rounded-xl hover:bg-stone-900 shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function selectType(val) {
            document.getElementById('input_type').value = val;
            const cardJurnal = document.getElementById('type_card_jurnal');
            const cardSuara = document.getElementById('type_card_suara_warga');
            const checkJurnal = document.getElementById('check_jurnal');
            const checkSuara = document.getElementById('check_suara_warga');

            if (val === 'jurnal') {
                cardJurnal.classList.add('border-forest', 'bg-forest/5');
                cardJurnal.classList.remove('border-stone-200');
                checkJurnal.classList.remove('hidden');

                cardSuara.classList.remove('border-terracotta', 'bg-terracotta/5');
                cardSuara.classList.add('border-stone-200');
                checkSuara.classList.add('hidden');
            } else {
                cardSuara.classList.add('border-terracotta', 'bg-terracotta/5');
                cardSuara.classList.remove('border-stone-200');
                checkSuara.classList.remove('hidden');

                cardJurnal.classList.remove('border-forest', 'bg-forest/5');
                cardJurnal.classList.add('border-stone-200');
                checkJurnal.classList.add('hidden');
            }
        }

        function toggleCategoryDropdown() {
            const menu = document.getElementById('category_dropdown_menu');
            const chevron = document.getElementById('category_chevron');
            menu.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }

        function selectCategory(id, name, color, type) {
            document.getElementById('input_category_id').value = id;
            document.getElementById('category_selected_display').innerHTML = `
                <span class="w-3.5 h-3.5 rounded-full flex-shrink-0" style="background-color: ${color};"></span>
                <span class="text-sm font-semibold text-stone-900">${name}</span>
                <span class="text-sm text-stone-500 tracking-wider bg-stone-200/60 px-2 py-0.5 rounded-md ml-1 font-mono">(${type})</span>
            `;
            document.getElementById('category_dropdown_menu').classList.add('hidden');
            document.getElementById('category_chevron').classList.remove('rotate-180');
        }

        function filterCategories(query) {
            const cleanQuery = query.toLowerCase().trim();
            const options = document.querySelectorAll('.category-option');
            options.forEach(opt => {
                const name = opt.getAttribute('data-name');
                if (name.includes(cleanQuery)) {
                    opt.style.display = 'flex';
                } else {
                    opt.style.display = 'none';
                }
            });
        }

        document.addEventListener('click', (e) => {
            const container = document.getElementById('category_selector_container');
            const menu = document.getElementById('category_dropdown_menu');
            const chevron = document.getElementById('category_chevron');
            if (container && !container.contains(e.target) && menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            }
        });

        function selectImageMode(mode) {
            document.getElementById('input_image_mode').value = mode;
            const cardNormal = document.getElementById('mode_card_normal');
            const cardFull = document.getElementById('mode_card_full');

            if (mode === 'normal') {
                cardNormal.classList.add('border-forest', 'bg-forest/5');
                cardNormal.classList.remove('border-stone-200');
                cardFull.classList.remove('border-forest', 'bg-forest/5');
                cardFull.classList.add('border-stone-200');
            } else {
                cardFull.classList.add('border-forest', 'bg-forest/5');
                cardFull.classList.remove('border-stone-200');
                cardNormal.classList.remove('border-forest', 'bg-forest/5');
                cardNormal.classList.add('border-stone-200');
            }
        }

        function selectStatus(val) {
            document.getElementById('input_status').value = val;
            const btnPub = document.getElementById('status_btn_published');
            const btnDraft = document.getElementById('status_btn_draft');
            const btnPending = document.getElementById('status_btn_pending_review');
            const btnReject = document.getElementById('status_btn_rejected');

            [btnPub, btnDraft, btnPending, btnReject].forEach(btn => {
                if (btn) {
                    btn.className = 'py-2 px-3 rounded-xl border-2 text-sm font-bold transition-all flex items-center justify-center gap-1.5 border-stone-200 text-stone-600 hover:bg-stone-50 bg-white';
                }
            });

            if (val === 'published' && btnPub) {
                btnPub.className = 'py-2 px-3 rounded-xl border-2 text-sm font-bold transition-all flex items-center justify-center gap-1.5 border-forest bg-forest text-white shadow-2xs';
            } else if (val === 'draft' && btnDraft) {
                btnDraft.className = 'py-2 px-3 rounded-xl border-2 text-sm font-bold transition-all flex items-center justify-center gap-1.5 border-stone-800 bg-stone-800 text-white shadow-2xs';
            } else if (val === 'pending_review' && btnPending) {
                btnPending.className = 'py-2 px-3 rounded-xl border-2 text-sm font-bold transition-all flex items-center justify-center gap-1.5 border-amber-500 bg-amber-500 text-white shadow-2xs';
            } else if (val === 'rejected' && btnReject) {
                btnReject.className = 'py-2 px-3 rounded-xl border-2 text-sm font-bold transition-all flex items-center justify-center gap-1.5 border-red-600 bg-red-600 text-white shadow-2xs';
            }
        }

        function setQcType(val, btn) {
            document.getElementById('qc_type').value = val;
            document.querySelectorAll('.qc-type-btn').forEach(b => {
                b.classList.remove('border-forest', 'bg-forest/5', 'text-forest', 'font-bold');
                b.classList.add('border-stone-200', 'text-stone-600', 'font-semibold');
            });
            btn.classList.add('border-forest', 'bg-forest/5', 'text-forest', 'font-bold');
            btn.classList.remove('border-stone-200', 'text-stone-600', 'font-semibold');
        }

        function openQuickCategoryModal() {
            const modal = document.getElementById('quick_category_modal');
            const card = modal.querySelector('div.bg-white');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeQuickCategoryModal() {
            const modal = document.getElementById('quick_category_modal');
            const card = modal.querySelector('div.bg-white');
            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }

        async function submitQuickCategory(e) {
            e.preventDefault();
            const name = document.getElementById('qc_name').value;
            const type = document.getElementById('qc_type').value;
            const color = document.getElementById('qc_color').value;

            try {
                const res = await fetch('{{ route('admin.categories.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ name, type, color })
                });

                const data = await res.json();
                if (data.success && data.category) {
                    selectCategory(data.category.id, data.category.name, data.category.color, data.category.type);
                    closeQuickCategoryModal();
                    if (window.showToast) {
                        window.showToast('Kategori baru berhasil ditambahkan dan dipilih!', 'success');
                    }
                }
            } catch (err) {
                alert('Gagal menambahkan kategori. Pastikan nama belum pernah digunakan.');
            }
        }
    </script>
    @endpush

</x-layouts.admin>
