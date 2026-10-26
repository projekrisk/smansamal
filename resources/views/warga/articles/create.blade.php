<x-layouts.warga title="Tulis Karya Baru - Dasbor Warga" headerTitle="Tulis Karya Baru">

    <form action="{{ route('warga.articles.store') }}" method="POST" enctype="multipart/form-data" class="w-full bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 shadow-none sm:shadow-2xs p-0 sm:p-5 font-sans">
        @csrf

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5 pb-4 border-b border-stone-200">
            <div>
                <h1 class="font-serif text-2xl text-stone-900 font-bold tracking-tight">Tulis Karya Suara Warga</h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('warga.articles.index') }}" class="px-4 py-2 rounded-xl border border-stone-300 text-stone-700 text-sm font-bold tracking-wider hover:bg-stone-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2 rounded-xl bg-forest text-white text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-xs cursor-pointer">
                    <span>Kirim & Ajukan</span>
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
                            Judul Tulisan / Opini <span class="text-terracotta">*</span>
                        </label>
                        <input type="text" name="title" id="article_title" value="{{ old('title') }}" required placeholder="Contoh: Menumbuhkan Budaya Membaca Kritis di Era Digital..." class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-sm sm:text-base font-medium focus:border-forest focus:ring-2 focus:ring-forest/10 outline-none transition-all bg-white text-stone-900">
                    </div>
                </div>

                <div class="bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 p-0 sm:p-4 shadow-none sm:shadow-2xs">
                    <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-2">
                        Ringkasan Singkat (Excerpt)
                    </label>
                    <textarea name="excerpt" rows="2" placeholder="Satu atau dua kalimat ringkasan pengantar yang menarik pembaca..." class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-2 focus:ring-forest/10 outline-none transition-all resize-none text-stone-800 bg-white">{{ old('excerpt') }}</textarea>
                    <span class="text-sm text-stone-500 block mt-1.5">Ditampilkan pada cuplikan berita di halaman depan.</span>
                </div>

                <div class="bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 p-0 sm:p-4 shadow-none sm:shadow-2xs">
                    <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-2">
                        Isi Konten Tulisan <span class="text-terracotta">*</span>
                    </label>
                    <x-rich-editor name="content" id="warga-article-create-editor" :value="old('content')" />
                </div>
            </div>

            <div class="lg:col-span-5 space-y-4">

                <div class="bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 shadow-none sm:shadow-2xs sm:overflow-hidden">
                    <div class="px-0 sm:px-4 py-1.5 sm:py-2.5 border-b border-stone-200 sm:border-stone-100 flex items-center justify-between bg-transparent sm:bg-stone-50/70">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-forest"></span>
                            <h2 class="font-sans font-bold text-sm text-stone-900">Status & Alur Moderasi</h2>
                        </div>
                    </div>

                    <div class="py-3 px-0 sm:p-4 space-y-3.5">

                        <div>
                            <div class="py-2.5 px-3 rounded-xl border-2 border-forest bg-forest/5 text-forest font-bold text-sm flex items-center justify-center gap-2 shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-forest animate-pulse"></span>
                                Menunggu Tinjauan Kurasi
                            </div>
                            <p class="text-sm text-stone-500 mt-1.5">Karya akan ditinjau oleh Dewan Moderator Literasi SMAN 1 Malingping sebelum dipublikasikan.</p>
                        </div>

                        <div class="pt-2 border-t border-stone-200 sm:border-stone-100">
                            <div class="p-2.5 rounded-xl bg-stone-50 border border-stone-200/80 text-sm text-stone-600 leading-relaxed flex items-start gap-2">
                                <svg class="w-4 h-4 text-forest flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Tulisan wajib orisinal, menjunjung tinggi etika kesantunan, dan bebas dari unsur plagiarisme.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative z-30 bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 shadow-none sm:shadow-2xs">
                    <div class="px-0 sm:px-4 py-1.5 sm:py-2.5 border-b border-stone-200 sm:border-stone-100 flex items-center justify-between bg-transparent sm:bg-stone-50/70">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h2 class="font-sans font-bold text-sm text-stone-900">Kategori Tulisan</h2>
                        </div>
                    </div>

                    <div class="py-3 px-0 sm:p-4 space-y-3.5">

                        <div class="relative" id="category_selector_container">
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                                Kategori Tulisan <span class="text-terracotta">*</span>
                            </label>

                            <input type="hidden" name="category_id" id="input_category_id" value="{{ old('category_id') }}" required>

                            <button
                                type="button"
                                id="category_dropdown_btn"
                                onclick="toggleCategoryDropdown()"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 bg-white hover:border-stone-300 text-left flex items-center justify-between transition-colors focus:outline-none focus:border-forest focus:ring-2 focus:ring-forest/10 cursor-pointer"
                            >
                                <div class="flex items-center gap-2.5 truncate" id="category_selected_display">
                                    @php
                                        $selectedCat = old('category_id') ? $categories->firstWhere('id', old('category_id')) : null;
                                    @endphp
                                    @if($selectedCat)
                                        <span class="w-3.5 h-3.5 rounded-full flex-shrink-0" style="background-color: {{ $selectedCat->color ?: '#2A5C43' }};"></span>
                                        <span class="text-sm font-semibold text-stone-900 truncate">{{ $selectedCat->name }}</span>
                                    @else
                                        <span class="text-sm text-stone-400">Pilih Kategori Tulisan...</span>
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
                                            onclick="selectCategory('{{ $cat->id }}', '{{ addslashes($cat->name) }}', '{{ $cat->color ?: '#2A5C43' }}')"
                                            class="category-option p-2.5 px-3.5 flex items-center justify-between hover:bg-stone-50 cursor-pointer transition-colors"
                                            data-name="{{ strtolower($cat->name) }}"
                                        >
                                            <div class="flex items-center gap-2">
                                                <span class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $cat->color ?: '#2A5C43' }};"></span>
                                                <span class="text-sm font-semibold text-stone-800">{{ $cat->name }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-stone-100">
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5 flex items-center justify-between">
                                <span>Tag / Label <span class="text-stone-400 font-normal lowercase">(opsional)</span></span>
                            </label>
                            <input
                                type="text"
                                name="tags"
                                id="article_tags"
                                value="{{ old('tags') }}"
                                placeholder="Contoh: tugas-biologi, cerpen, literasi"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-2 focus:ring-forest/10 outline-none transition-all bg-white text-stone-900"
                            >
                            <p class="text-xs text-stone-500 mt-1 leading-relaxed">
                                Pisahkan dengan tanda koma (,). Masukkan tag instruksi dari guru jika karya ini merupakan pengumpulan tugas.
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

                        <div>
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                                Unggah Foto Sampul
                            </label>
                            <input type="file" name="featured_image" accept="image/*" class="w-full text-sm text-stone-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-forest file:text-white hover:file:bg-stone-900 file:transition-colors cursor-pointer border border-stone-200 rounded-xl p-1 bg-white">
                            <span class="text-sm text-stone-500 block mt-1">Format JPG, PNG, WebP (Maks. 5MB).</span>
                        </div>

                        <div>
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                                Format Tampilan di Halaman Baca
                            </label>
                            <input type="hidden" name="featured_image_mode" id="input_image_mode" value="{{ old('featured_image_mode', 'normal') }}">

                            <div class="grid grid-cols-2 gap-2">
                                <div
                                    onclick="selectImageMode('normal')"
                                    id="mode_card_normal"
                                    class="cursor-pointer p-2.5 rounded-xl border-2 transition-all flex items-center gap-2 bg-white {{ old('featured_image_mode', 'normal') === 'normal' ? 'border-forest bg-forest/5 shadow-2xs' : 'border-stone-200 hover:border-stone-300' }}"
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
                            <input type="text" name="featured_image_caption" value="{{ old('featured_image_caption') }}" placeholder="Dokumentasi kegiatan..." class="w-full px-3 py-2 rounded-xl border border-stone-200 bg-white font-sans text-sm focus:outline-none focus:border-forest text-stone-800">
                        </div>
                    </div>
                </div>

                <div class="py-3 px-0 sm:p-3 bg-transparent sm:bg-stone-50 rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 flex items-center justify-end gap-2.5">
                    <a href="{{ route('warga.articles.index') }}" class="px-4 py-2 rounded-xl border border-stone-300 text-stone-700 text-sm font-bold tracking-wider hover:bg-stone-100 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-forest text-white px-5 py-2 rounded-xl text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-xs cursor-pointer">
                        Kirim Artikel
                    </button>
                </div>

            </div>
        </div>
    </form>

    <script>
        function toggleCategoryDropdown() {
            const menu = document.getElementById('category_dropdown_menu');
            const chevron = document.getElementById('category_chevron');
            menu.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }

        function selectCategory(id, name, color) {
            document.getElementById('input_category_id').value = id;
            document.getElementById('category_selected_display').innerHTML = `
                <span class="w-3.5 h-3.5 rounded-full flex-shrink-0" style="background-color: ${color};"></span>
                <span class="text-sm font-semibold text-stone-900 truncate">${name}</span>
            `;
            document.getElementById('category_dropdown_menu').classList.add('hidden');
            document.getElementById('category_chevron').classList.remove('rotate-180');
        }

        function filterCategories(query) {
            const cleanQuery = query.toLowerCase().trim();
            const options = document.querySelectorAll('.category-option');
            options.forEach(opt => {
                const name = opt.getAttribute('data-name');
                if (name && name.includes(cleanQuery)) {
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
    </script>

</x-layouts.warga>
