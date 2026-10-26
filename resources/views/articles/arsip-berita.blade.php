<x-layouts.app
    title="Berita & Warta Terkini - SMAN 1 Malingping"
    description="Kumpulan berita resmi, warta kegiatan kesiswaan, prestasi akademik, dan pengumuman terbaru SMA Negeri 1 Malingping.">

    <main class="flex-grow pt-32 pb-20 px-6 w-full flex justify-center">

        <div class="w-full max-w-[1000px]">

            <div class="mb-10 text-center md:text-left flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>

                    <div class="flex items-center justify-center md:justify-start gap-3 mb-4">
                        <a href="{{ route('home') }}" class="font-sans text-sm text-stone-500 hover:text-stone-900 transition-colors">Beranda</a>
                        <span class="text-stone-400 text-xs">/</span>
                        <span class="font-sans text-[11px] font-bold text-terracotta uppercase tracking-widest">Arsip Berita</span>
                    </div>

                    <h1 class="font-serif text-4xl md:text-5xl text-stone-900 mb-4">Berita Sekolah</h1>
                    <p class="font-sans text-stone-600 max-w-xl">Kumpulan berita, eksplorasi sains, kegiatan siswa, dan prestasi terbaru dari ekosistem SMAN 1 Malingping.</p>
                </div>

                <form action="{{ route('berita.index') }}" method="GET" class="relative w-full md:w-72 flex-shrink-0">
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari berita..." class="w-full pl-10 pr-4 py-3 rounded-full border border-stone-200 bg-white focus:outline-none focus:border-forest focus:ring-1 focus:ring-forest font-sans text-sm transition-colors text-stone-800">
                    <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 hover:text-forest focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>

            <div class="w-full overflow-x-auto no-scrollbar border-b border-stone-200 mb-10">
                <div class="flex space-x-6 w-max font-sans text-sm font-semibold text-stone-500">
                    <a href="{{ route('berita.index', array_filter(['q' => $search])) }}"
                       class="pb-3 border-b-2 transition-colors {{ empty($selectedCategory) ? 'border-forest text-forest' : 'border-transparent hover:text-stone-900 hover:border-stone-300' }}">
                        Semua
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('berita.index', array_filter(['kategori' => $category->slug, 'q' => $search])) }}"
                           class="pb-3 border-b-2 transition-colors {{ ($selectedCategory === $category->slug) ? 'border-forest text-forest' : 'border-transparent hover:text-stone-900 hover:border-stone-300' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div id="articles-container" class="grid grid-cols-1 md:grid-cols-3 gap-y-10 gap-x-6 md:gap-y-12 mb-12">
                @forelse($articles as $article)
                    <x-article-card-jurnal :article="$article" />
                @empty
                    <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-stone-200/60 p-8">
                        <svg class="w-12 h-12 text-stone-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        <h3 class="font-serif text-xl text-stone-800 mb-1">Tidak ada berita ditemukan</h3>
                        <p class="font-sans text-stone-500 text-sm">Coba kata kunci pencarian atau kategori lain.</p>
                        @if($search || $selectedCategory)
                            <a href="{{ route('berita.index') }}" class="mt-4 inline-block text-xs font-bold text-forest uppercase tracking-wider underline">Reset Filter</a>
                        @endif
                    </div>
                @endforelse
            </div>

            @if($articles->hasMorePages())
                <div id="load-more-wrapper" class="flex justify-center mb-12">
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
    </main>

    <x-back-to-top />

    @push('scripts')
    <script>
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
                            wrapper.innerHTML = '<span class="text-xs font-sans font-semibold text-stone-400 uppercase tracking-wider">Semua artikel telah dimuat</span>';
                        }
                    }
                } catch (err) {
                    console.error('Gagal memuat berita:', err);
                    btn.disabled = false;
                    textEl.textContent = 'Gagal, Coba Lagi';
                    spinner.classList.add('hidden');
                    icon.classList.remove('hidden');
                }
            });
        });
    </script>
    @endpush

</x-layouts.app>
