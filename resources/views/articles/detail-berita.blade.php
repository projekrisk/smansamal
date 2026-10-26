<x-layouts.app
    :title="$article->title . ' - Berita SMAN 1 Malingping'"
    :description="$article->excerpt"
    :image="$article->featured_image_url"
    type="article"
    :author="$article->user->name ?? 'Humas SMAN 1 Malingping'"
    :publishedTime="$article->published_at?->toIso8601String()">

    <main class="flex-grow pt-32 pb-20 px-6">

        <article class="w-full max-w-[760px] mx-auto">

            @if(! $article->isPublished())
                <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-amber-50 border border-amber-200/80 text-amber-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs font-sans">
                    <div class="flex items-start sm:items-center gap-3">
                        <span class="px-2.5 py-1 bg-amber-200 text-amber-900 text-[11px] font-bold uppercase tracking-wider rounded-md flex-shrink-0">
                            {{ $article->status === 'draft' ? 'DRAF' : ($article->status === 'pending_review' ? 'MENUNGGU TINJAUAN' : ucfirst($article->status)) }}
                        </span>
                        <p class="text-xs sm:text-sm text-amber-800 leading-snug">
                            <strong>Pratinjau Khusus:</strong> Artikel ini tidak terlihat oleh publik (hanya pengelola/penulis yang memiliki hak akses pratinjau).
                        </p>
                    </div>
                    @if(auth()->user()?->isAdmin())
                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-xs font-bold text-forest hover:text-stone-900 underline flex-shrink-0">
                            Kelola di Admin &rarr;
                        </a>
                    @elseif(auth()->id() === $article->user_id)
                        <a href="{{ route('warga.articles.edit', $article->id) }}" class="text-xs font-bold text-forest hover:text-stone-900 underline flex-shrink-0">
                            Edit Karya &rarr;
                        </a>
                    @endif
                </div>
            @endif

            <div class="flex flex-col items-center text-center mb-10">
                <div class="flex items-center gap-3 mb-5">
                    <a href="{{ route('berita.index') }}" class="font-sans text-sm text-stone-500 hover:text-stone-900 transition-colors">Berita</a>
                    <span class="text-stone-400 text-xs">/</span>
                    <span class="font-sans text-[11px] font-bold text-terracotta uppercase tracking-widest">{{ $article->category->name ?? 'Prestasi' }}</span>
                </div>

                <h1 class="font-serif text-4xl md:text-5xl text-stone-900 leading-tight md:leading-snug mb-6 max-w-3xl">
                    {{ $article->title }}
                </h1>

                @if($article->excerpt)
                    <p class="font-sans text-stone-600 text-lg md:text-xl max-w-2xl leading-relaxed">
                        {{ $article->excerpt }}
                    </p>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row items-center sm:justify-between border-y border-stone-200/60 py-4 mb-10 gap-3.5 sm:gap-4">

                <a href="{{ route('warga.profile', $article->user->username ?? $article->user_id) }}" class="flex flex-col sm:flex-row items-center sm:items-center text-center sm:text-left gap-2.5 sm:gap-3.5 group/author">
                    <div class="w-14 h-14 sm:w-12 sm:h-12 rounded-full bg-stone-200 overflow-hidden flex-shrink-0 shadow-xs ring-2 ring-stone-100">
                        <img src="{{ $article->user->avatar_url }}" alt="{{ $article->user->name }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <div class="text-center sm:text-left">
                        <p class="font-sans font-bold text-base sm:text-sm text-stone-900 group-hover/author:text-forest transition-colors">{{ $article->user->name }}</p>
                        <p class="font-sans text-xs text-stone-500 mt-0.5">{{ $article->user->role_detail }} &bull; {{ $article->formatted_date }}</p>
                    </div>
                </a>

                <div class="flex items-center justify-center sm:justify-end gap-5 sm:gap-6 font-sans text-sm text-stone-500 w-full sm:w-auto">
                    <span class="flex items-center gap-1.5 text-stone-500" title="Dilihat {{ $article->views_count ?? 0 }} kali">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span id="views-count" class="font-semibold text-stone-700 transition-all duration-300">{{ $article->views_count ?? 0 }}</span>
                    </span>
                    <button id="like-btn" data-article-id="{{ $article->id }}" class="flex items-center gap-1.5 hover:text-terracotta transition-colors focus:outline-none group {{ $isLiked ? 'text-terracotta' : '' }}" title="Beri Apresiasi">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 {{ $isLiked ? 'text-terracotta fill-terracotta' : 'text-stone-400' }} group-hover:text-terracotta group-hover:fill-terracotta transition-all" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span id="likes-count" class="font-semibold text-stone-700 transition-all duration-300">{{ $article->likes_count }}</span>
                    </button>
                    <a href="#comments" class="flex items-center gap-1.5 hover:text-forest transition-colors focus:outline-none group" title="Lihat Komentar">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-stone-400 group-hover:text-forest transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span id="comments-count" class="font-semibold text-stone-700 transition-all duration-300">{{ $article->comments()->count() }}</span>
                    </a>
                </div>
            </div>

            <div x-data="{ imageModalOpen: false }" @keydown.escape.window="imageModalOpen = false" class="mb-10">
                @if(($article->featured_image_mode ?? 'normal') === 'full')

                    <div class="-mx-6 sm:-mx-10 md:-mx-24 lg:-mx-36 mb-4">
                        <figure class="relative group/img cursor-zoom-in" @click="imageModalOpen = true">
                            <div class="w-full aspect-video md:aspect-[21/9] rounded-none sm:rounded-2xl md:rounded-[2.5rem] overflow-hidden shadow-none sm:shadow-lg border-y sm:border border-stone-200/80">
                                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover/img:scale-102 transition-transform duration-500" fetchpriority="high" loading="eager" decoding="async">
                            </div>

                            <div class="absolute bottom-3 right-3 sm:bottom-4 sm:right-4 bg-stone-900/75 hover:bg-stone-900 text-white text-[11px] font-sans font-medium px-3.5 py-1.5 rounded-full backdrop-blur-md flex items-center gap-1.5 shadow-lg transition-all opacity-90 sm:opacity-0 group-hover/img:opacity-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                <span>Lihat Penuh</span>
                            </div>
                        </figure>
                    </div>
                @else

                    <div class="w-full mb-3">
                        <figure class="relative group/img cursor-zoom-in" @click="imageModalOpen = true">
                            <div class="w-full aspect-video md:aspect-[21/9] rounded-2xl overflow-hidden shadow-sm border border-stone-200">
                                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover/img:scale-102 transition-transform duration-500" fetchpriority="high" loading="eager" decoding="async">
                            </div>

                            <div class="absolute bottom-3 right-3 sm:bottom-4 sm:right-4 bg-stone-900/75 hover:bg-stone-900 text-white text-[11px] font-sans font-medium px-3.5 py-1.5 rounded-full backdrop-blur-md flex items-center gap-1.5 shadow-lg transition-all opacity-90 sm:opacity-0 group-hover/img:opacity-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                <span>Lihat Penuh</span>
                            </div>
                        </figure>
                    </div>
                @endif

                @if($article->featured_image_caption)
                    <figcaption class="text-center font-sans text-xs md:text-sm text-stone-500 italic max-w-2xl mx-auto px-4 mt-2.5">
                        {{ $article->featured_image_caption }}
                    </figcaption>
                @endif

                <template x-teleport="body">
                    <div
                        x-show="imageModalOpen"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 md:p-10 bg-stone-950/90 backdrop-blur-md"
                        @click.self="imageModalOpen = false"
                        style="display: none;"
                    >
                        <button
                            @click="imageModalOpen = false"
                            class="absolute top-4 right-4 sm:top-6 sm:right-6 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors focus:outline-none z-10"
                            title="Tutup Preview (ESC)"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>

                        <div class="relative max-w-5xl w-full max-h-[90vh] flex flex-col items-center">
                            <img
                                src="{{ $article->featured_image_url }}"
                                alt="{{ $article->title }}"
                                class="max-h-[75vh] w-auto max-w-full rounded-2xl object-contain shadow-2xl border border-white/10"
                            >
                            @if($article->featured_image_caption)
                                <p class="font-sans text-xs sm:text-sm text-stone-200 text-center mt-3 max-w-2xl px-5 py-2 rounded-full bg-stone-900/80 backdrop-blur-sm border border-white/10">
                                    {{ $article->featured_image_caption }}
                                </p>
                            @endif
                        </div>
                    </div>
                </template>
            </div>

            <div class="prose font-sans text-stone-800 text-lg">
                {!! $article->content_with_ads !!}
            </div>

            @if(\App\Models\Setting::getBool('ad_bottom_article_enabled') && \App\Models\Setting::get('ad_bottom_article_code'))
                <div class="my-10 p-5 text-center bg-stone-50 rounded-2xl border border-stone-200/80 overflow-hidden not-prose ad-container ad-bottom-article shadow-xs">
                    <span class="text-[10px] uppercase font-bold tracking-widest text-stone-400 block mb-2.5">Iklan</span>
                    {!! \App\Models\Setting::get('ad_bottom_article_code') !!}
                </div>
            @endif

            <div class="mt-12 pt-8 border-t border-stone-200/60 flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">

                <div class="flex flex-wrap items-center gap-2">
                    <span class="font-sans text-sm text-stone-500 font-medium mr-2">Kategori:</span>
                    <a href="{{ route('berita.index', ['kategori' => $article->category?->slug]) }}" class="px-4 py-1.5 bg-stone-200/50 text-stone-600 rounded-full text-xs font-semibold uppercase tracking-wider hover:bg-stone-200 transition-colors">
                        {{ $article->category?->name ?? 'Jurnal' }}
                    </a>
                </div>

                <div class="flex items-center gap-2 md:gap-3">
                    <span class="font-sans text-sm text-stone-500 font-medium mr-1 md:mr-2">Bagikan:</span>

                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 md:w-10 md:h-10 rounded-full border border-stone-200 flex items-center justify-center text-stone-600 hover:bg-[#25D366] hover:text-white hover:border-[#25D366] transition-colors" title="Bagikan ke WhatsApp">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>

                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 md:w-10 md:h-10 rounded-full border border-stone-200 flex items-center justify-center text-stone-600 hover:bg-[#1877F2] hover:text-white hover:border-[#1877F2] transition-colors" title="Bagikan ke Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>

                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 md:w-10 md:h-10 rounded-full border border-stone-200 flex items-center justify-center text-stone-600 hover:bg-black hover:text-white hover:border-black transition-colors" title="Bagikan ke X">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 25h-3.31l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>

                    <button onclick="copyCurrentUrl('Tautan berita berhasil disalin!')" class="w-9 h-9 md:w-10 md:h-10 rounded-full border border-stone-200 flex items-center justify-center text-stone-600 hover:bg-forest hover:text-white hover:border-forest transition-colors focus:outline-none cursor-pointer" title="Salin Tautan">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </button>

                    <x-report-article-modal :article="$article" />
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-2xl md:rounded-[2rem] border border-stone-200 shadow-sm flex flex-col md:flex-row items-center md:items-start gap-6 text-center md:text-left mb-16">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full overflow-hidden flex-shrink-0 border-4 border-stone-50">
                    <img src="{{ $article->user->avatar_url }}" alt="{{ $article->user->name }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                </div>
                <div class="flex-grow">
                    <h3 class="font-serif text-2xl text-stone-900 mb-1">{{ $article->user->name }}</h3>
                    <p class="font-sans text-[11px] font-bold text-forest uppercase tracking-widest mb-3">{{ $article->user->role_detail }}</p>
                    <p class="font-sans text-stone-600 text-sm leading-relaxed mb-5">{{ $article->user->bio ?: 'Civitas akademika dan pembina literasi SMAN 1 Malingping.' }}</p>
                    <a href="{{ route('warga.profile', $article->user->username ?? $article->user_id) }}" class="inline-block border border-stone-300 text-stone-700 hover:bg-forest hover:text-white hover:border-forest px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-colors duration-300">
                        Lihat Profil Penulis
                    </a>
                </div>
            </div>

            @if($relatedArticles->count() > 0)
                <div class="mb-16">
                    <h3 class="font-serif text-3xl text-stone-900 mb-8 border-b border-stone-200/60 pb-4">Baca Juga</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                        @foreach($relatedArticles as $rel)
                            <a href="{{ $rel->url }}" class="group flex flex-col md:block cursor-pointer">
                                <div class="w-full aspect-[3/1] md:aspect-[3/2] rounded-xl md:rounded-2xl overflow-hidden mb-3 md:mb-4 flex-shrink-0">
                                    <img src="{{ $rel->featured_image_url }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" decoding="async">
                                </div>
                                <div class="flex-1 px-1 md:px-0">
                                    <p class="font-sans text-[10px] md:text-xs font-semibold text-terracotta uppercase tracking-wider mb-1 md:mb-2">{{ $rel->category->name ?? 'Jurnal' }}</p>
                                    <h4 class="font-serif text-lg md:text-xl text-stone-900 leading-snug group-hover:text-forest transition-colors">{{ $rel->title }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div id="comments" class="scroll-mt-32">
                <div class="flex items-center gap-3 mb-8 border-b border-stone-200/60 pb-4">
                    <h3 class="font-serif text-3xl text-stone-900">Komentar</h3>
                    <span id="comments-badge" class="bg-stone-200 text-stone-700 text-xs font-bold px-3 py-1 rounded-full transition-all duration-300">{{ $article->comments()->count() }}</span>
                </div>

                <div id="main-comment-form-container" class="transition-all duration-300">
                    <form id="main-comment-form" action="{{ route('articles.comment', $article->id) }}" method="POST" class="mb-12 bg-stone-50 p-6 md:p-8 rounded-2xl md:rounded-[2rem] border border-stone-200/60 shadow-xs">
                        @csrf
                        <h4 class="font-sans font-semibold text-stone-900 mb-4">Tinggalkan Komentar</h4>

                        @guest
                            <div class="mb-4 p-3.5 bg-emerald-50/80 rounded-xl border border-emerald-200/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2.5">
                                <div class="flex items-center gap-2 text-xs text-stone-700">
                                    <svg class="w-4 h-4 text-forest flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                    <span>Punya akun warga sekolah? Masuk agar komentar Anda langsung tayang.</span>
                                </div>
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-xs font-bold text-forest hover:text-stone-900 underline underline-offset-2 flex-shrink-0">
                                    <span>Masuk ke Akun</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                <input type="text" name="author_name" placeholder="Nama Lengkap *" class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-white focus:outline-none focus:border-forest focus:ring-1 focus:ring-forest font-sans text-sm transition-colors" required>
                                <input type="email" name="author_email" placeholder="Email (opsional)" class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-white focus:outline-none focus:border-forest focus:ring-1 focus:ring-forest font-sans text-sm transition-colors">
                            </div>
                            <p class="font-sans text-[11px] text-stone-500 mb-3 bg-stone-100/70 p-2.5 rounded-xl border border-stone-200/50 flex items-center gap-2">
                                <svg class="w-4 h-4 text-stone-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span><strong>Pemberitahuan Tamu:</strong> Komentar dari pengunjung umum akan melalui proses moderasi sebelum ditampilkan ke publik.</span>
                            </p>
                        @else
                            <input type="hidden" name="author_name" value="{{ auth()->user()->name }}">
                            <p class="font-sans text-xs text-stone-500 mb-3">Mengomentari sebagai <strong>{{ auth()->user()->name }}</strong></p>
                        @endguest

                        <textarea name="content" rows="4" placeholder="Tulis komentar Anda di sini..." class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-white focus:outline-none focus:border-forest focus:ring-1 focus:ring-forest font-sans text-sm transition-colors mb-4 resize-none" required></textarea>

                        <div class="text-right">
                            <button type="submit" class="bg-forest text-white px-8 py-3 rounded-full text-sm font-semibold hover:bg-stone-900 transition-colors duration-300 shadow-xs cursor-pointer">
                                Kirim Komentar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="space-y-8">
                    @forelse($article->comments as $comment)
                        <div class="comment-item pb-6 border-b border-stone-200/50 last:border-b-0" id="comment-{{ $comment->id }}">

                            <div class="flex gap-4 items-start">
                                @if($comment->user)
                                    <a href="{{ $comment->user->profile_url }}" class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 shadow-xs border border-stone-200/80 hover:ring-2 hover:ring-forest transition-all" title="Lihat profil {{ $comment->author_name }}">
                                        <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->author_name }}" class="w-full h-full object-cover">
                                    </a>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-forest text-white flex items-center justify-center font-serif text-lg flex-shrink-0 shadow-xs">
                                        {{ $comment->initial }}
                                    </div>
                                @endif
                                <div class="flex-grow min-w-0">
                                    <div class="flex items-center gap-2.5 mb-1 flex-wrap">
                                        @if($comment->user)
                                            <a href="{{ $comment->user->profile_url }}" class="font-sans font-bold text-stone-900 hover:text-forest transition-colors text-sm hover:underline underline-offset-2 flex items-center gap-1.5" title="Lihat profil {{ $comment->author_name }}">
                                                <span>{{ $comment->author_name }}</span>
                                            </a>
                                        @else
                                            <h5 class="font-sans font-bold text-stone-900 text-sm">{{ $comment->author_name }}</h5>
                                        @endif

                                        @if($comment->isAuthor())
                                            <span class="bg-forest/10 text-forest text-[10px] px-2 py-0.5 rounded-full font-bold">Penulis</span>
                                        @elseif($comment->user)
                                            <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold {{ $comment->user->role_badge['class'] ?? 'bg-stone-100 text-stone-600' }}">
                                                {{ $comment->user->role_badge['label'] ?? 'Warga' }}
                                            </span>
                                        @endif
                                        <span class="font-sans text-xs text-stone-400">{{ $comment->formatted_date }}</span>
                                    </div>
                                    <p class="font-sans text-stone-600 text-sm leading-relaxed">{{ $comment->content }}</p>

                                    <div class="mt-2.5 flex items-center gap-4">
                                        <button type="button" onclick="openReplyForm({{ $comment->id }})" class="inline-flex items-center gap-1.5 text-xs font-bold text-stone-500 hover:text-forest transition-colors cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                            <span>Balas</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="reply-form-{{ $comment->id }}" class="reply-form-box hidden mt-4 pt-4 border-t border-stone-200/70 transition-all duration-300">
                                <form action="{{ route('articles.comment', $article->id) }}" method="POST" class="bg-stone-50/95 p-4 sm:p-5 rounded-2xl border border-stone-200/80 shadow-xs">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                                    <div class="flex items-center justify-between mb-3">
                                        <span class="font-sans text-xs font-bold text-stone-700 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                            <span>Balas ke <strong>{{ $comment->author_name }}</strong></span>
                                        </span>
                                        <button type="button" onclick="cancelReplyForm({{ $comment->id }})" class="text-xs text-stone-400 hover:text-stone-700 font-semibold p-1 cursor-pointer">
                                            Batal
                                        </button>
                                    </div>

                                    @guest
                                        <div class="mb-3 p-2.5 bg-emerald-50/80 rounded-xl border border-emerald-200/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-xs">
                                            <span class="text-stone-700 text-[11px]">Punya akun warga sekolah?</span>
                                            <a href="{{ route('login') }}" class="font-bold text-forest hover:text-stone-900 underline underline-offset-2 text-[11px] flex-shrink-0">
                                                Masuk ke Akun &rarr;
                                            </a>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                                            <input type="text" name="author_name" placeholder="Nama Anda *" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 bg-white text-xs font-sans focus:border-forest outline-none transition-colors" required>
                                            <input type="email" name="author_email" placeholder="Email (opsional)" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 bg-white text-xs font-sans focus:border-forest outline-none transition-colors">
                                        </div>
                                        <p class="font-sans text-[11px] text-stone-500 mb-2.5 bg-stone-100/80 p-2 rounded-lg border border-stone-200/50">
                                            Komentar tamu akan ditayangkan setelah disetujui moderator.
                                        </p>
                                    @else
                                        <input type="hidden" name="author_name" value="{{ auth()->user()->name }}">
                                        <p class="font-sans text-xs text-stone-500 mb-2">Membalas sebagai <strong>{{ auth()->user()->name }}</strong></p>
                                    @endguest

                                    <textarea name="content" rows="2" placeholder="Tulis balasan Anda untuk {{ $comment->author_name }}..." class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 bg-white text-xs font-sans focus:border-forest outline-none resize-none mb-3 transition-colors" required></textarea>

                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" onclick="cancelReplyForm({{ $comment->id }})" class="px-4 py-2 rounded-full text-xs font-semibold text-stone-500 hover:bg-stone-200/60 transition-colors cursor-pointer">
                                            Batal
                                        </button>
                                        <button type="submit" class="bg-forest text-white px-5 py-2 rounded-full text-xs font-bold hover:bg-stone-900 transition-colors shadow-xs cursor-pointer">
                                            Kirim Balasan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            @if($comment->replies->count() > 0)
                                <div class="mt-4 pt-3 space-y-4">
                                    @foreach($comment->replies as $reply)
                                        <div class="flex gap-3.5 sm:gap-4 pl-4 sm:pl-6 border-l-2 border-stone-200/80" id="comment-{{ $reply->id }}">
                                            @if($reply->user)
                                                <a href="{{ $reply->user->profile_url }}" class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 shadow-xs border border-stone-200/80 hover:ring-2 hover:ring-forest transition-all" title="Lihat profil {{ $reply->author_name }}">
                                                    <img src="{{ $reply->user->avatar_url }}" alt="{{ $reply->author_name }}" class="w-full h-full object-cover">
                                                </a>
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-stone-200 overflow-hidden flex-shrink-0 shadow-xs">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->author_name) }}&background=E5E7EB&color=374151" alt="{{ $reply->author_name }}" class="w-full h-full object-cover">
                                                </div>
                                            @endif
                                            <div class="flex-grow min-w-0">
                                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                    @if($reply->user)
                                                        <a href="{{ $reply->user->profile_url }}" class="font-sans font-bold text-stone-900 hover:text-forest transition-colors text-sm hover:underline underline-offset-2 flex items-center gap-1.5" title="Lihat profil {{ $reply->author_name }}">
                                                            <span>{{ $reply->author_name }}</span>
                                                        </a>
                                                    @else
                                                        <h5 class="font-sans font-bold text-stone-900 text-sm">{{ $reply->author_name }}</h5>
                                                    @endif

                                                    @if($reply->isAuthor())
                                                        <span class="bg-forest/10 text-forest text-[10px] px-2 py-0.5 rounded-full font-bold">Penulis</span>
                                                    @elseif($reply->user)
                                                        <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold {{ $reply->user->role_badge['class'] ?? 'bg-stone-100 text-stone-600' }}">
                                                            {{ $reply->user->role_badge['label'] ?? 'Warga' }}
                                                        </span>
                                                    @endif
                                                    <span class="font-sans text-[11px] text-stone-400">{{ $reply->formatted_date }}</span>
                                                </div>
                                                <p class="font-sans text-stone-600 text-sm leading-relaxed">{{ $reply->content }}</p>
                                                <button type="button" onclick="replyToUser({{ $comment->id }}, '{{ addslashes($reply->author_name) }}')" class="inline-flex items-center gap-1 text-[11px] font-bold text-stone-400 hover:text-forest transition-colors mt-1.5 cursor-pointer">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                                    <span>Balas</span>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-stone-500 font-sans text-sm text-center py-6">Belum ada komentar. Jadilah yang pertama memberikan tanggapan!</p>
                    @endforelse
                </div>
            </div>

        </article>
    </main>

    <div class="fixed bottom-6 right-6 md:bottom-8 md:right-8 flex flex-col items-end gap-3 z-50">

        <div id="audio-player-bar" class="flex items-center gap-1.5 bg-white/95 backdrop-blur-md px-3 py-2 rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.15)] border border-stone-200/90 transition-all duration-300">

            <button id="btn-read-aloud" class="flex items-center gap-2 text-stone-700 hover:text-forest transition-colors focus:outline-none cursor-pointer pr-1" title="Putar Suara Artikel">
                <div class="w-8 h-8 rounded-full bg-forest/10 flex items-center justify-center text-forest flex-shrink-0">
                    <svg id="icon-play" class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <svg id="icon-stop" class="w-4 h-4 hidden text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span id="audio-label" class="text-xs font-bold text-stone-800 hidden sm:inline-block">Dengarkan</span>
            </button>

            <div class="w-px h-5 bg-stone-200"></div>

            <button id="btn-playback-rate" type="button" class="flex items-center gap-1 px-2.5 py-1 rounded-full bg-stone-100 hover:bg-forest/10 hover:text-forest text-stone-700 font-mono text-xs font-bold transition-all cursor-pointer" title="Klik untuk mempercepat / mengatur kecepatan suara">
                <svg class="w-3 h-3 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span id="playback-rate-text">1.0x</span>
            </button>
        </div>

        <button id="btn-back-top" class="relative w-11 h-11 md:w-12 md:h-12 bg-white rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-stone-100 flex items-center justify-center text-stone-600 hover:text-forest transition-all duration-500 focus:outline-none opacity-0 translate-y-8 pointer-events-none group cursor-pointer" title="Kembali ke Atas">
            <svg class="w-5 h-5 relative z-10 transition-transform group-hover:-translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
            <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none" viewBox="0 0 36 36">
                <path class="text-stone-100" stroke-width="2.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path id="scroll-progress-ring" class="text-forest transition-all duration-150" stroke-dasharray="0, 100" stroke-width="2.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
            </svg>
        </button>
    </div>

    @push('scripts')
    <script>
        const articleId = {{ $article->id }};

        function openReplyForm(commentId, authorMention = null) {
            document.querySelectorAll('.reply-form-box').forEach(el => {
                el.classList.add('hidden');
            });

            const topForm = document.getElementById('main-comment-form-container');
            if (topForm) {
                topForm.classList.add('hidden');
            }

            const formContainer = document.getElementById('reply-form-' + commentId);
            if (formContainer) {
                formContainer.classList.remove('hidden');
                const textarea = formContainer.querySelector('textarea');
                if (textarea) {
                    if (authorMention) {
                        textarea.value = '@' + authorMention + ' ';
                    }
                    textarea.focus();
                }
                formContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function cancelReplyForm(commentId) {
            const formContainer = document.getElementById('reply-form-' + commentId);
            if (formContainer) {
                formContainer.classList.add('hidden');
            }

            const topForm = document.getElementById('main-comment-form-container');
            if (topForm) {
                topForm.classList.remove('hidden');
            }
        }

        function replyToUser(parentCommentId, authorName) {
            openReplyForm(parentCommentId, authorName);
        }

        const likeBtn = document.getElementById('like-btn');
        const likesCount = document.getElementById('likes-count');
        const viewsCount = document.getElementById('views-count');
        const commentsCount = document.getElementById('comments-count');
        const commentsBadge = document.getElementById('comments-badge');

        if (likeBtn) {
            likeBtn.addEventListener('click', async () => {
                const icon = likeBtn.querySelector('svg');
                try {
                    const response = await fetch(`/artikel/${articleId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        if (likesCount) likesCount.textContent = data.likes_count;
                        if (data.liked) {
                            likeBtn.classList.add('text-terracotta');
                            icon.setAttribute('fill', 'currentColor');
                            icon.classList.add('text-terracotta', 'fill-terracotta');
                        } else {
                            likeBtn.classList.remove('text-terracotta');
                            icon.setAttribute('fill', 'none');
                            icon.classList.remove('text-terracotta', 'fill-terracotta');
                        }
                    }
                } catch (e) {
                    console.error('Error toggling like:', e);
                }
            });
        }

        let lastViews = {{ (int) ($article->views_count ?? 0) }};
        let lastLikes = {{ (int) ($article->likes_count ?? 0) }};
        let lastComments = {{ (int) ($article->comments()->count()) }};

        async function fetchRealtimeStats() {
            if (document.hidden) return;
            try {
                const res = await fetch(`/artikel/${articleId}/stats`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) return;
                const stats = await res.json();
                if (stats.success) {
                    if (viewsCount && stats.views_count !== lastViews) {
                        viewsCount.textContent = stats.views_count;
                        viewsCount.classList.add('scale-110', 'text-forest');
                        setTimeout(() => viewsCount.classList.remove('scale-110', 'text-forest'), 1000);
                        lastViews = stats.views_count;
                    }

                    if (likesCount && stats.likes_count !== lastLikes) {
                        likesCount.textContent = stats.likes_count;
                        likesCount.classList.add('scale-110', 'text-terracotta');
                        setTimeout(() => likesCount.classList.remove('scale-110', 'text-terracotta'), 1000);
                        lastLikes = stats.likes_count;
                    }

                    if (stats.comments_count !== lastComments) {
                        if (commentsCount) {
                            commentsCount.textContent = stats.comments_count;
                            commentsCount.classList.add('scale-110', 'text-forest');
                            setTimeout(() => commentsCount.classList.remove('scale-110', 'text-forest'), 1000);
                        }
                        if (commentsBadge) {
                            commentsBadge.textContent = stats.comments_count;
                        }
                        lastComments = stats.comments_count;
                    }
                }
            } catch (err) {
            }
        }

        setInterval(fetchRealtimeStats, 5000);
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) fetchRealtimeStats();
        });

        const availableRates = [1.0, 1.25, 1.5, 2.0];
        let currentRateIndex = 0;
        let isReading = false;
        const synth = window.speechSynthesis;

        const btnReadAloud = document.getElementById('btn-read-aloud');
        const iconPlay = document.getElementById('icon-play');
        const iconStop = document.getElementById('icon-stop');
        const audioLabel = document.getElementById('audio-label');
        const audioPlayerBar = document.getElementById('audio-player-bar');
        const btnPlaybackRate = document.getElementById('btn-playback-rate');
        const playbackRateText = document.getElementById('playback-rate-text');

        function startSpeaking() {
            if (!synth) return;
            synth.cancel();

            const articleContent = document.querySelector('.prose').innerText;
            const utterance = new SpeechSynthesisUtterance(articleContent);
            utterance.lang = 'id-ID';
            utterance.rate = availableRates[currentRateIndex];

            utterance.onend = () => {
                isReading = false;
                iconPlay.classList.remove('hidden');
                iconStop.classList.add('hidden');
                if (audioLabel) audioLabel.textContent = 'Dengarkan';
                if (audioPlayerBar) audioPlayerBar.classList.remove('border-forest', 'ring-2', 'ring-forest/20');
            };

            utterance.onerror = () => {
                isReading = false;
                iconPlay.classList.remove('hidden');
                iconStop.classList.add('hidden');
                if (audioLabel) audioLabel.textContent = 'Dengarkan';
                if (audioPlayerBar) audioPlayerBar.classList.remove('border-forest', 'ring-2', 'ring-forest/20');
            };

            synth.speak(utterance);
            isReading = true;
            iconPlay.classList.add('hidden');
            iconStop.classList.remove('hidden');
            if (audioLabel) audioLabel.textContent = 'Memutar...';
            if (audioPlayerBar) audioPlayerBar.classList.add('border-forest', 'ring-2', 'ring-forest/20');
        }

        function stopSpeaking() {
            if (!synth) return;
            synth.cancel();
            isReading = false;
            iconPlay.classList.remove('hidden');
            iconStop.classList.add('hidden');
            if (audioLabel) audioLabel.textContent = 'Dengarkan';
            if (audioPlayerBar) audioPlayerBar.classList.remove('border-forest', 'ring-2', 'ring-forest/20');
        }

        if (btnReadAloud && synth) {
            btnReadAloud.addEventListener('click', () => {
                if (isReading) {
                    stopSpeaking();
                } else {
                    startSpeaking();
                }
            });

            window.addEventListener('beforeunload', () => synth.cancel());
        }

        if (btnPlaybackRate) {
            btnPlaybackRate.addEventListener('click', () => {
                currentRateIndex = (currentRateIndex + 1) % availableRates.length;
                const newRate = availableRates[currentRateIndex];
                playbackRateText.textContent = newRate.toFixed(1) + 'x';

                if (isReading) {
                    startSpeaking();
                }
            });
        }

        const btnBackTop = document.getElementById('btn-back-top');
        const progressRing = document.getElementById('scroll-progress-ring');

        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = docHeight > 0 ? Math.min(scrollTop / docHeight, 1) : 0;

            if (progressRing) {
                progressRing.style.strokeDasharray = `${scrollPercent * 100}, 100`;
            }

            if (scrollTop > 400) {
                btnBackTop.classList.remove('opacity-0', 'translate-y-8', 'pointer-events-none');
            } else {
                btnBackTop.classList.add('opacity-0', 'translate-y-8', 'pointer-events-none');
            }
        });

        if (btnBackTop) {
            btnBackTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        if (window.location.hash && window.location.hash.startsWith('#comment-')) {
            const targetComment = document.querySelector(window.location.hash);
            if (targetComment) {
                setTimeout(() => {
                    targetComment.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    targetComment.classList.add('bg-forest/10', 'rounded-2xl', 'p-3', 'transition-all', 'duration-500');
                    setTimeout(() => {
                        targetComment.classList.remove('bg-forest/10');
                    }, 3500);
                }, 400);
            }
        }
    </script>
    @endpush

</x-layouts.app>
