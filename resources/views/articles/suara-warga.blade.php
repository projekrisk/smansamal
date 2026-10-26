<x-layouts.app
    title="Suara Warga - Literasi & Opini Civitas SMAN 1 Malingping"
    description="Kanal literasi digital, opini, esai, dan karya tulis kreatif para siswa, dewan guru, serta alumni SMA Negeri 1 Malingping.">

    <main
        class="flex-grow pt-32 pb-20 w-full"
        x-data="suaraWargaSearchModal()"
    >

        <div class="w-full max-w-[1000px] mx-auto px-6 mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="text-center md:text-left">

                <div class="flex items-center justify-center md:justify-start gap-3 mb-3">
                    <a href="{{ route('home') }}" class="font-sans text-sm text-stone-500 hover:text-stone-900 transition-colors">Beranda</a>
                    <span class="text-stone-400 text-xs">/</span>
                    <span class="font-sans text-[11px] font-bold text-terracotta uppercase tracking-widest">Suara Warga</span>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl text-stone-900 mb-3 font-bold">Suara Warga Sekolah</h1>
                <p class="font-sans text-stone-600 max-w-xl text-base sm:text-lg">Ruang karya, opini, tugas literasi siswa, dan buah pemikiran guru SMAN 1 Malingping.</p>
            </div>

            <div class="flex items-center justify-center md:justify-end flex-shrink-0">
                <button
                    type="button"
                    @click="openModal()"
                    class="group inline-flex items-center gap-3 px-5 py-2.5 rounded-full border border-stone-200 bg-white hover:border-forest/60 hover:bg-stone-50 text-stone-600 shadow-2xs hover:shadow-sm text-sm font-sans transition-all cursor-pointer"
                    title="Buka Pencarian Artikel & #Tag Tugas">
                    <span class="w-8 h-8 rounded-full bg-forest/10 text-forest flex items-center justify-center group-hover:bg-forest group-hover:text-white transition-all shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <span class="text-stone-500 group-hover:text-stone-800 font-medium text-xs sm:text-sm">
                        @if($search)
                            Cari: <span class="font-bold text-stone-800">"{{ Str::limit($search, 18) }}"</span>
                        @elseif($selectedTag)
                            Tag: <span class="font-mono font-bold text-forest">#{{ $selectedTag }}</span>
                        @else
                            Cari artikel atau #tag tugas...
                        @endif
                    </span>
                    <kbd class="hidden sm:inline-flex items-center gap-0.5 px-2 py-0.5 text-[10px] font-mono font-semibold text-stone-400 bg-stone-100 rounded border border-stone-200 ml-1">
                        <span>Ctrl</span><span>K</span>
                    </kbd>
                </button>
            </div>
        </div>

        <div
            x-show="isOpen"
            x-cloak
            @keydown.window="handleKeyDown($event)"
            @keydown.escape.window="closeModal()"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >

            <div
                x-show="isOpen"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="closeModal()"
                class="fixed inset-0 bg-stone-900/60 backdrop-blur-sm transition-opacity"
            ></div>

            <div class="min-h-full flex items-start justify-center p-4 sm:p-6 md:p-10 text-center">
                <div
                    x-show="isOpen"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                    @click.stop
                    class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-stone-200 overflow-hidden text-left flex flex-col max-h-[85vh] mt-8 sm:mt-12"
                >

                    <div class="p-4 sm:p-5 border-b border-stone-200 bg-stone-50/70 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-forest/10 text-forest flex items-center justify-center flex-shrink-0">
                            <template x-if="!isLoading">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </template>
                            <template x-if="isLoading">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </template>
                        </div>

                        <div class="flex-1 relative">
                            <input
                                x-ref="searchInput"
                                type="text"
                                x-model="query"
                                @input.debounce.200ms="fetchSuggest()"
                                @keydown.enter.prevent="submitSearch()"
                                placeholder="Ketik kata kunci atau #tag tugas guru..."
                                class="w-full bg-transparent border-0 font-sans text-base sm:text-lg text-stone-900 placeholder:text-stone-400 focus:outline-none focus:ring-0 p-0"
                            >
                        </div>

                        <button
                            x-show="query.length > 0"
                            @click="clearQuery()"
                            type="button"
                            class="p-1.5 text-stone-400 hover:text-stone-700 rounded-full hover:bg-stone-200/60 transition-colors"
                            title="Bersihkan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>

                        <button
                            @click="closeModal()"
                            type="button"
                            class="px-2.5 py-1 text-xs font-mono font-semibold text-stone-500 bg-stone-200/70 hover:bg-stone-200 hover:text-stone-800 rounded-lg transition-colors"
                            title="Tutup (ESC)">
                            ESC
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-5 sm:p-6 space-y-6">

                        <div x-show="query.trim().length < 2" class="space-y-6">

                            <div class="p-3.5 bg-forest/5 rounded-2xl border border-forest/15 flex items-start gap-3 text-xs font-sans text-forest-900">
                                <span class="text-base leading-none">💡</span>
                                <p class="text-stone-600 leading-relaxed">
                                    <strong class="text-forest font-semibold">Tugas Karya Sekolah:</strong> Guru dapat memberikan perintah tag tertentu pada instruksi tugas (misal: <code class="bg-forest/10 text-forest px-1.5 py-0.5 rounded font-mono font-bold">#TugasBiologi</code>). Guru dan siswa dapat langsung mencari seluruh karya tugas kelas hanya dengan mengetik atau mengklik tag tersebut.
                                </p>
                            </div>

                            @if(isset($popularTags) && $popularTags->isNotEmpty())
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h5 class="font-sans text-xs font-bold uppercase tracking-wider text-stone-400 flex items-center gap-1.5">
                                            <span>🔥</span> Tag Terpopuler
                                        </h5>
                                        <span class="text-[11px] font-sans text-stone-400">Paling banyak karya</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($popularTags as $tag)
                                            <a
                                                href="{{ route('suara-warga.index', ['tag' => $tag->slug]) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-stone-100 hover:bg-forest hover:text-white text-stone-700 text-xs font-mono font-medium transition-colors group">
                                                <span>#{{ $tag->name }}</span>
                                                <span class="text-[10px] bg-stone-200/80 group-hover:bg-white/20 group-hover:text-white text-stone-500 px-1.5 py-0.5 rounded-md font-sans">
                                                    {{ $tag->articles_count }}
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(isset($recentTags) && $recentTags->isNotEmpty())
                                <div>
                                    <h5 class="font-sans text-xs font-bold uppercase tracking-wider text-stone-400 flex items-center gap-1.5 mb-3">
                                        <span>✨</span> Tag Tugas & Topik Terbaru
                                    </h5>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($recentTags as $tag)
                                            <a
                                                href="{{ route('suara-warga.index', ['tag' => $tag->slug]) }}"
                                                class="inline-flex items-center px-3 py-1.5 rounded-xl bg-white border border-stone-200 hover:border-forest hover:text-forest text-stone-600 text-xs font-mono font-medium transition-colors">
                                                #{{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div>
                                <h5 class="font-sans text-xs font-bold uppercase tracking-wider text-stone-400 flex items-center gap-1.5 mb-3">
                                    <span>📂</span> Rubrik Suara Warga
                                </h5>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($categories as $cat)
                                        <a
                                            href="{{ route('suara-warga.index', ['kategori' => $cat->slug]) }}"
                                            class="px-3 py-1.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-sans font-medium transition-colors">
                                            {{ $cat->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div x-show="query.trim().length >= 2" class="space-y-6">

                            <template x-if="results.tags && results.tags.length > 0">
                                <div>
                                    <h5 class="font-sans text-xs font-bold uppercase tracking-wider text-stone-400 flex items-center gap-1.5 mb-2.5">
                                        <span>🏷️</span> Tag & Label Tugas Terkait
                                    </h5>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="t in results.tags" :key="t.slug">
                                            <a
                                                :href="t.url"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-forest/10 hover:bg-forest text-forest hover:text-white text-xs font-mono font-bold transition-all shadow-2xs">
                                                <span x-text="'#' + t.name"></span>
                                                <span class="text-[10px] bg-forest/20 text-forest hover:text-white px-1.5 py-0.5 rounded-md" x-text="t.count + ' karya'"></span>
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <h5 class="font-sans text-xs font-bold uppercase tracking-wider text-stone-400 flex items-center gap-1.5">
                                        <span>📄</span> Artikel & Karya Ditemukan
                                    </h5>
                                    <span class="text-xs text-stone-400 font-sans" x-text="results.articles.length > 0 ? (results.articles.length + ' saran ditemukan') : ''"></span>
                                </div>

                                <div x-show="isLoading" class="py-6 flex items-center justify-center gap-2 text-stone-400 text-sm font-sans">
                                    <svg class="animate-spin w-4 h-4 text-forest" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span>Mencari artikel & tag...</span>
                                </div>

                                <div x-show="!isLoading && results.articles && results.articles.length > 0" class="divide-y divide-stone-100">
                                    <template x-for="art in results.articles" :key="art.id">
                                        <a
                                            :href="art.url"
                                            class="block py-3 px-3 -mx-3 rounded-2xl hover:bg-stone-50 transition-colors group">
                                            <div class="flex items-center justify-between gap-2 mb-1">
                                                <span class="text-[10px] font-sans font-bold uppercase tracking-wider text-terracotta bg-terracotta/10 px-2 py-0.5 rounded-md" x-text="art.category"></span>
                                                <span class="text-[11px] font-mono text-stone-400" x-text="art.date"></span>
                                            </div>
                                            <h6 class="font-serif text-sm sm:text-base font-bold text-stone-900 group-hover:text-forest transition-colors leading-snug" x-text="art.title"></h6>
                                            <div class="flex items-center gap-3 mt-1.5 text-xs font-sans text-stone-500">
                                                <span class="font-medium text-stone-700" x-text="art.author"></span>
                                                <span>•</span>
                                                <span class="flex items-center gap-1 font-mono text-stone-400 text-[11px]">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    <span x-text="art.views"></span>
                                                </span>
                                                <template x-if="art.tags && art.tags.length > 0">
                                                    <div class="hidden sm:flex items-center gap-1 ml-auto">
                                                        <template x-for="tg in art.tags" :key="tg">
                                                            <span class="text-[10px] font-mono text-forest bg-forest/5 px-1.5 py-0.5 rounded" x-text="'#' + tg"></span>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                        </a>
                                    </template>
                                </div>

                                <div x-show="!isLoading && hasSearched && results.articles.length === 0 && (!results.tags || results.tags.length === 0)" class="text-center py-8">
                                    <div class="w-12 h-12 rounded-full bg-stone-100 text-stone-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="font-serif text-stone-800 text-base font-bold mb-1">Tidak ditemukan hasil</p>
                                    <p class="font-sans text-stone-500 text-xs">Tidak ada karya atau tag yang cocok dengan kata kunci "<span class="font-semibold text-stone-800" x-text="query"></span>".</p>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="p-4 border-t border-stone-200 bg-stone-50 flex items-center justify-between gap-3 text-xs font-sans">
                        <span class="text-stone-500 hidden sm:inline">
                            Tekan <kbd class="px-1.5 py-0.5 font-mono text-[10px] bg-white border border-stone-200 rounded font-semibold text-stone-700">Enter</kbd> untuk hasil lengkap
                        </span>
                        <button
                            type="button"
                            @click="submitSearch()"
                            class="w-full sm:w-auto ml-auto px-5 py-2.5 bg-forest hover:bg-forest/90 text-white font-semibold rounded-full shadow-sm transition-colors flex items-center justify-center gap-2 cursor-pointer">
                            <span>Tampilkan Semua Hasil</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        @if($selectedCategory || $selectedTag || $search)
            <div class="w-full max-w-[1000px] mx-auto px-6 mb-8">
                <div class="p-3.5 bg-stone-100/80 rounded-2xl border border-stone-200/80 flex flex-wrap items-center justify-between gap-3 font-sans text-xs">
                    <div class="flex items-center flex-wrap gap-2">
                        <span class="font-bold text-stone-700">Filter Aktif:</span>

                        @if($selectedCategory)
                            @php
                                $currentCat = $categories->firstWhere('slug', $selectedCategory);
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-stone-200 text-stone-800 rounded-full font-semibold shadow-2xs">
                                <span>Rubrik: {{ $currentCat->name ?? $selectedCategory }}</span>
                                <a href="{{ route('suara-warga.index', array_filter(['tag' => $selectedTag, 'q' => $search])) }}" class="text-stone-400 hover:text-red-600 transition-colors" title="Hapus Filter Rubrik">&times;</a>
                            </span>
                        @endif

                        @if($selectedTag)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-forest text-white rounded-full font-mono font-semibold shadow-2xs">
                                <span>Tag: #{{ $selectedTag }}</span>
                                <a href="{{ route('suara-warga.index', array_filter(['kategori' => $selectedCategory, 'q' => $search])) }}" class="text-white/70 hover:text-white transition-colors" title="Hapus Filter Tag">&times;</a>
                            </span>
                        @endif

                        @if($search)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-stone-200 text-stone-800 rounded-full font-semibold shadow-2xs">
                                <span>Pencarian: "{{ $search }}"</span>
                                <a href="{{ route('suara-warga.index', array_filter(['kategori' => $selectedCategory, 'tag' => $selectedTag])) }}" class="text-stone-400 hover:text-red-600 transition-colors" title="Hapus Pencarian">&times;</a>
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('suara-warga.index') }}" class="font-bold text-terracotta hover:underline uppercase tracking-wider text-[11px]">
                        Reset Semua Filter
                    </a>
                </div>
            </div>
        @endif

        @if($spotlight && !$selectedTag && !$search && empty($selectedCategory))
            <div class="w-full max-w-[1000px] mx-auto px-6 mb-16">
                <div class="bg-forest text-white rounded-3xl md:rounded-[2.5rem] p-8 md:p-12 relative overflow-hidden flex flex-col md:flex-row items-center gap-8 md:gap-12 shadow-md">

                    <svg class="absolute -bottom-10 -right-10 w-64 h-64 text-white/5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>

                    <div class="w-24 h-24 md:w-40 md:h-40 rounded-full border-4 border-white/20 overflow-hidden flex-shrink-0 z-10">
                        <img src="{{ $spotlight->user->avatar_url }}" alt="{{ $spotlight->user->name }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <div class="z-10 text-center md:text-left">
                        <div class="inline-flex items-center gap-1.5 bg-terracotta text-white font-sans text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-4 shadow-2xs">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.316.492-.533 1.035-.688 1.581a9.92 9.92 0 00-.377 1.87c-.126 1.05-.126 1.936-.126 2.5a.75.75 0 01-1.5 0c0-.604-.002-1.564-.13-2.673a9.89 9.89 0 00-.39-1.92 5.034 5.034 0 00-.735-1.568 1 1 0 00-1.566.248C3.78 4.256 3 6.07 3 8.25c0 4.28 3.47 7.75 7.75 7.75s7.75-3.47 7.75-7.75c0-2.385-.945-4.32-2.355-5.697z" clip-rule="evenodd"/></svg>
                            <span>Sorotan Minggu Ini</span>
                        </div>
                        <h2 class="font-serif text-2xl md:text-4xl leading-snug mb-4">"{{ $spotlight->title }}"</h2>
                        <p class="font-sans text-stone-200 text-sm md:text-base leading-relaxed mb-4 max-w-xl">
                            {{ $spotlight->excerpt }}
                        </p>
                        @if($spotlight->tags && $spotlight->tags->isNotEmpty())
                            <div class="flex flex-wrap gap-1.5 mb-6 justify-center md:justify-start">
                                @foreach($spotlight->tags as $t)
                                    <a href="{{ route('suara-warga.index', ['tag' => $t->slug]) }}" class="inline-flex items-center text-xs font-mono font-medium bg-white/10 hover:bg-white hover:text-forest px-2.5 py-1 rounded-full transition-colors">
                                        #{{ $t->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        <div class="flex flex-wrap items-center gap-2 mb-6">
                            <span class="inline-flex items-center gap-1.5 bg-white/10 text-white/90 px-3 py-1 rounded-full text-xs font-mono">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>{{ number_format($spotlight->views_count) }} views</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 bg-white/10 text-white/90 px-3 py-1 rounded-full text-xs font-mono">
                                <svg class="w-3.5 h-3.5 text-red-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                                <span>{{ number_format($spotlight->likes_count) }} suka</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 bg-white/10 text-white/90 px-3 py-1 rounded-full text-xs font-mono">
                                <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                <span>{{ number_format($spotlight->comments_count ?? $spotlight->comments()->count()) }} komentar</span>
                            </span>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 font-sans">
                            <span class="font-bold">{{ $spotlight->user->name }}</span>
                            <span class="hidden md:inline text-stone-400">•</span>
                            <span class="text-stone-300 text-sm">{{ $spotlight->user->role_detail }}</span>
                            <a href="{{ $spotlight->url }}" class="mt-4 md:mt-0 md:ml-auto inline-block border border-white/30 text-white hover:bg-white hover:text-forest px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-colors duration-300">
                                Baca Artikel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="w-full max-w-[1000px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-12">

            <div class="lg:col-span-2 flex flex-col gap-10">

                <div class="flex space-x-6 border-b border-stone-200 pb-1 mb-2 font-sans text-sm font-semibold text-stone-500 overflow-x-auto no-scrollbar">
                    <a href="{{ route('suara-warga.index', array_filter(['q' => $search, 'tag' => $selectedTag])) }}"
                       class="pb-3 border-b-2 transition-colors whitespace-nowrap {{ empty($selectedCategory) ? 'border-forest text-forest' : 'border-transparent hover:text-stone-900' }}">
                        Semua Tulisan
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('suara-warga.index', array_filter(['kategori' => $category->slug, 'q' => $search, 'tag' => $selectedTag])) }}"
                           class="pb-3 border-b-2 transition-colors whitespace-nowrap {{ ($selectedCategory === $category->slug) ? 'border-forest text-forest' : 'border-transparent hover:text-stone-900' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <div id="articles-container" class="flex flex-col gap-10">
                    @forelse($articles as $article)
                        <x-article-card-suara-warga :article="$article" layout="horizontal" />
                    @empty
                        <div class="text-center py-16 bg-white rounded-3xl border border-stone-200/60 p-8 shadow-2xs">
                            <svg class="w-12 h-12 text-stone-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <h3 class="font-serif text-xl text-stone-800 mb-1">Tidak ada karya tulis yang sesuai</h3>
                            <p class="font-sans text-stone-500 text-sm">Coba gunakan kata kunci pencarian, rubrik, atau #tag tugas lain.</p>
                            @if($search || $selectedTag || $selectedCategory)
                                <a href="{{ route('suara-warga.index') }}" class="mt-4 inline-block text-xs font-bold text-forest uppercase tracking-wider underline">Reset Filter</a>
                            @endif
                        </div>
                    @endforelse
                </div>

                @if($articles->hasMorePages())
                    <div id="load-more-wrapper" class="flex justify-center mt-2 mb-6">
                        <button
                            id="load-more-btn"
                            type="button"
                            data-next-url="{{ $articles->nextPageUrl() }}"
                            class="group inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full border border-stone-300 bg-white hover:bg-forest hover:border-forest text-stone-800 hover:text-white font-sans text-sm font-semibold transition-all duration-300 shadow-2xs hover:shadow-sm cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="load-more-text">Muat Lainnya</span>
                            <svg id="load-more-spinner" class="hidden animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <svg id="load-more-icon" class="w-4 h-4 transition-transform group-hover:translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>
                @endif

            </div>

            <aside class="w-full flex flex-col gap-10">

                <div class="bg-stone-100 rounded-2xl p-6 md:p-8 text-center border border-stone-200/60 shadow-2xs">
                    <h4 class="font-serif text-xl text-stone-900 mb-3 font-bold">Punya Ide atau Opini?</h4>
                    <p class="font-sans text-sm text-stone-600 mb-6 leading-relaxed">Kirimkan tugas karya, esai, cerpen, atau liputan Anda untuk diterbitkan ke portal resmi SMAN 1 Malingping.</p>
                    @auth
                        <a href="{{ route('warga.articles.create') }}" class="block w-full bg-stone-900 text-white py-3 rounded-full font-sans text-sm font-semibold hover:bg-forest transition-colors shadow-sm">
                            Kirim Karya Tulis
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="block w-full bg-stone-900 text-white py-3 rounded-full font-sans text-sm font-semibold hover:bg-forest transition-colors shadow-sm">
                            Daftar & Tulis Karya
                        </a>
                    @endauth
                </div>

                @if(isset($popularArticlesMonth) && $popularArticlesMonth->isNotEmpty())
                    <div>
                        <div class="flex items-center justify-between border-b border-stone-200 pb-2 mb-6">
                            <h4 class="font-serif text-xl text-stone-900 font-bold flex items-center gap-2">
                                <svg class="w-5 h-5 text-terracotta" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.316.492-.533 1.035-.688 1.581a9.92 9.92 0 00-.377 1.87c-.126 1.05-.126 1.936-.126 2.5a.75.75 0 01-1.5 0c0-.604-.002-1.564-.13-2.673a9.89 9.89 0 00-.39-1.92 5.034 5.034 0 00-.735-1.568 1 1 0 00-1.566.248C3.78 4.256 3 6.07 3 8.25c0 4.28 3.47 7.75 7.75 7.75s7.75-3.47 7.75-7.75c0-2.385-.945-4.32-2.355-5.697z" clip-rule="evenodd"/></svg>
                                <span>Populer</span>
                            </h4>
                            <span class="text-[10px] font-sans font-bold uppercase tracking-wider text-stone-400 bg-stone-100 px-2 py-0.5 rounded">30 Hari</span>
                        </div>

                        <div class="flex flex-col divide-y divide-stone-200/60">
                            @foreach($popularArticlesMonth as $idx => $pop)
                                <a href="{{ $pop->url }}" class="py-3.5 flex items-start gap-3.5 group cursor-pointer first:pt-0 hover:text-forest transition-colors">
                                    <span class="font-serif text-xl sm:text-2xl font-bold {{ $idx === 0 ? 'text-terracotta' : ($idx === 1 ? 'text-forest' : ($idx === 2 ? 'text-stone-500' : 'text-stone-300')) }} leading-none w-6 flex-shrink-0 text-center mt-0.5">
                                        {{ sprintf('%02d', $idx + 1) }}
                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-1.5 mb-1 text-[10px] font-sans font-semibold uppercase tracking-wider text-terracotta">
                                            <span>{{ $pop->category->name ?? 'Karya Warga' }}</span>
                                        </div>
                                        <h5 class="font-serif text-sm font-bold text-stone-900 group-hover:text-forest transition-colors line-clamp-2 leading-snug">
                                            {{ $pop->title }}
                                        </h5>
                                        <div class="flex items-center gap-2 mt-1.5 text-[11px] font-sans text-stone-400">
                                            <span class="truncate text-stone-600 font-medium max-w-[130px]">{{ $pop->user->name ?? 'Warga' }}</span>
                                            <span>•</span>
                                            <span class="flex items-center gap-1 font-mono text-stone-500">
                                                <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                {{ number_format($pop->views_count) }}
                                            </span>
                                            @if($pop->likes_count > 0)
                                                <span>•</span>
                                                <span class="flex items-center gap-1 font-mono text-stone-500">
                                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                                                    {{ $pop->likes_count }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <h4 class="font-serif text-xl text-stone-900 mb-6 border-b border-stone-200 pb-2 font-bold">Penulis Aktif</h4>
                    <div class="flex flex-col gap-5">
                        @foreach($activeAuthors as $author)
                            @continue($author->isAdmin())
                            <a href="{{ route('warga.profile', $author->username ?? $author->id) }}" class="flex items-center gap-4 group cursor-pointer">
                                <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-stone-200">
                                    <img src="{{ $author->avatar_url }}" alt="{{ $author->name }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <h5 class="font-sans font-bold text-sm text-stone-900 group-hover:text-forest transition-colors truncate">{{ $author->name }}</h5>
                                        <span class="{{ $author->role_badge['class'] }} text-[9px] font-bold px-1.5 py-0.5 rounded-full shrink-0">
                                            {{ $author->role_badge['label'] }}
                                        </span>
                                    </div>
                                    <p class="font-sans text-xs text-stone-500 mt-0.5">{{ $author->articles_count }} Artikel Terpublikasi</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h4 class="font-serif text-xl text-stone-900 mb-6 border-b border-stone-200 pb-2 font-bold">Topik Kategori</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($categories as $cat)
                            <a href="{{ route('suara-warga.index', ['kategori' => $cat->slug]) }}" class="px-3 py-1.5 bg-white border border-stone-200 text-stone-600 rounded-lg text-xs font-semibold hover:border-forest hover:text-forest transition-colors">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

            </aside>
        </div>
    </main>

    <script>
        function suaraWargaSearchModal() {
            return {
                isOpen: false,
                query: @json($search ?? ''),
                isLoading: false,
                results: { articles: [], tags: [] },
                hasSearched: false,
                searchUrl: @json(route('suara-warga.index')),
                suggestUrl: @json(route('suara-warga.suggest')),

                openModal() {
                    this.isOpen = true;
                    document.body.style.overflow = 'hidden';
                    this.$nextTick(() => {
                        if (this.$refs.searchInput) {
                            this.$refs.searchInput.focus();
                            this.$refs.searchInput.select();
                        }
                        if (this.query && this.query.trim().length >= 2) {
                            this.fetchSuggest();
                        }
                    });
                },
                closeModal() {
                    this.isOpen = false;
                    document.body.style.overflow = '';
                },
                handleKeyDown(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                        e.preventDefault();
                        if (this.isOpen) {
                            this.closeModal();
                        } else {
                            this.openModal();
                        }
                    }
                },
                clearQuery() {
                    this.query = '';
                    this.results = { articles: [], tags: [] };
                    this.hasSearched = false;
                    if (this.$refs.searchInput) {
                        this.$refs.searchInput.focus();
                    }
                },
                fetchSuggest() {
                    const q = (this.query || '').trim().replace(/^#/, '');
                    if (q.length < 2) {
                        this.results = { articles: [], tags: [] };
                        this.hasSearched = false;
                        this.isLoading = false;
                        return;
                    }
                    this.isLoading = true;
                    fetch(`${this.suggestUrl}?q=${encodeURIComponent(q)}`)
                        .then(res => res.json())
                        .then(data => {
                            this.results = data || { articles: [], tags: [] };
                            this.hasSearched = true;
                        })
                        .catch(err => {
                            console.error('Suggest error:', err);
                        })
                        .finally(() => {
                            this.isLoading = false;
                        });
                },
                submitSearch() {
                    const q = (this.query || '').trim();
                    if (!q) {
                        window.location.href = this.searchUrl;
                        return;
                    }
                    if (q.startsWith('#')) {
                        const tag = q.replace(/^#/, '');
                        window.location.href = `${this.searchUrl}?tag=${encodeURIComponent(tag)}`;
                        return;
                    }
                    window.location.href = `${this.searchUrl}?q=${encodeURIComponent(q)}`;
                }
            };
        }

        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('load-more-btn');
            const container = document.getElementById('articles-container');
            const wrapper = document.getElementById('load-more-wrapper');
            const textEl = document.getElementById('load-more-text');
            const spinner = document.getElementById('load-more-spinner');
            const icon = document.getElementById('load-more-icon');

            if (!btn || !container) return;

            btn.addEventListener('click', async function () {
                const nextUrl = btn.getAttribute('data-next-url');
                if (!nextUrl) return;

                btn.disabled = true;
                textEl.textContent = 'Memuat artikel...';
                spinner.classList.remove('hidden');
                icon.classList.add('hidden');

                try {
                    const response = await fetch(nextUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) throw new Error('Network response not ok');

                    const data = await response.json();

                    const temp = document.createElement('div');
                    temp.innerHTML = data.html;
                    while (temp.firstChild) {
                        container.appendChild(temp.firstChild);
                    }

                    if (data.has_more && data.next_page_url) {
                        btn.setAttribute('data-next-url', data.next_page_url);
                        btn.disabled = false;
                        textEl.textContent = 'Muat Lainnya';
                        spinner.classList.add('hidden');
                        icon.classList.remove('hidden');
                    } else {
                        if (wrapper) {
                            wrapper.innerHTML = '<span class="text-xs font-sans font-semibold text-stone-400 uppercase tracking-wider">Semua karya telah dimuat</span>';
                        }
                    }
                } catch (err) {
                    console.error('Gagal memuat artikel suara warga:', err);
                    btn.disabled = false;
                    textEl.textContent = 'Gagal, Coba Lagi';
                    spinner.classList.add('hidden');
                    icon.classList.remove('hidden');
                }
            });
        });
    </script>

    <x-back-to-top />

</x-layouts.app>
