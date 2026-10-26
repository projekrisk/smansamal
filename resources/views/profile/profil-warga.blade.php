<x-layouts.app
    :title="'Profil: ' . $user->name . ' - SMAN 1 Malingping'"
    :description="$user->bio ?: ('Profil dan karya tulis ' . $user->name . ' di portal civitas akademika SMAN 1 Malingping.')"
    :image="$user->avatar_url"
    type="profile"
    twitterCard="summary">

    <main class="flex-grow pt-0 w-full pb-20">

        <div class="w-full h-56 sm:h-64 md:h-80 relative bg-stone-200 overflow-hidden">
            <img
                src="{{ asset('images/bg.jpg') }}"
                alt="Cover Profil {{ $user->name }}"
                class="w-full h-full object-cover"
                loading="eager"
            >
            <div class="absolute inset-0 bg-stone-900/40"></div>
        </div>

        <div class="w-full max-w-[1000px] mx-auto px-6 relative -mt-20 md:-mt-28 mb-16">
            <div class="bg-white p-6 md:p-10 rounded-2xl md:rounded-[2.5rem] shadow-sm border border-stone-200 flex flex-col md:flex-row items-center md:items-end gap-6 md:gap-8">

                <div class="w-32 h-32 md:w-32 md:h-32 rounded-full border-4 border-white overflow-hidden flex-shrink-0 bg-stone-100 shadow-md relative z-10 -mt-16 md:-mt-20">
                    <img
                        src="{{ $user->avatar_url }}"
                        alt="{{ $user->name }}"
                        class="w-full h-full object-cover"
                    >
                </div>

                <div class="flex-grow text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
                        <div>
                            <h1 class="font-serif text-3xl md:text-4xl text-stone-900 mb-1">{{ $user->name }}</h1>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-2">
                                <span class="inline-flex items-center gap-1.5 {{ $user->role_badge['class'] ?? 'bg-terracotta/10 text-terracotta' }} font-sans text-xs font-bold tracking-wider px-3 py-1 rounded-full shadow-2xs">
                                    @if(isset($user->role_type) && $user->role_type === 'alumni')
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                    @endif
                                    {{ $user->role_badge['label'] ?? 'Warga Sekolah' }}
                                </span>

                                @if($user->tahun_lulus)
                                    <span class="inline-flex items-center text-xs font-semibold text-stone-600 bg-stone-100 px-2.5 py-1 rounded-full">
                                        Angkatan {{ $user->tahun_lulus }}
                                    </span>
                                @endif

                                @php
                                    $detailText = $user->pekerjaan_kampus ?: ($user->role_detail ?: 'SMAN 1 Malingping');
                                @endphp
                                @if($detailText)
                                    <span class="inline-flex items-center gap-1.5 text-xs md:text-xs text-stone-600 font-medium bg-stone-50 border border-stone-200/60 px-3 py-1 rounded-full">
                                        <svg class="w-3.5 h-3.5 text-stone-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        <span>{{ $detailText }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3 justify-center">
                            @if(auth()->id() === $user->id)
                                <a
                                    href="{{ route('profile.edit') }}"
                                    class="bg-stone-800 text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-stone-900 transition-colors duration-300 shadow-xs"
                                >
                                    Edit Profil
                                </a>
                                <a
                                    href="{{ route('warga.articles.create') }}"
                                    class="bg-forest text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-stone-900 transition-colors duration-300 shadow-xs"
                                >
                                    Tulis Karya
                                </a>
                            @else
                                @auth
                                    <button
                                        type="button"
                                        id="btn-follow"
                                        onclick="toggleFollowAuthor(this)"
                                        data-username="{{ $user->username }}"
                                        data-followed="{{ $isFollowing ? 'true' : 'false' }}"
                                        class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 shadow-xs flex items-center gap-2 {{ $isFollowing ? 'bg-stone-100 text-stone-700 hover:bg-stone-200 border border-stone-200' : 'bg-forest text-white hover:bg-stone-900' }}"
                                    >
                                        <svg id="btn-follow-icon" class="w-4 h-4 {{ $isFollowing ? 'text-forest' : 'text-white' }}" fill="{{ $isFollowing ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        <span id="btn-follow-text">{{ $isFollowing ? 'Mengikuti' : 'Ikuti' }}</span>
                                    </button>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="bg-forest text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-stone-900 transition-colors duration-300 shadow-xs inline-flex items-center gap-2"
                                        title="Login untuk mengikuti penulis ini"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                        Ikuti
                                    </a>
                                @endauth
                            @endif

                            <div class="relative" x-data="{ openShare: false }">
                                <button
                                    type="button"
                                    @click="openShare = !openShare"
                                    class="w-10 h-10 rounded-full border border-stone-200 flex items-center justify-center text-stone-600 hover:text-forest hover:border-forest transition-colors focus:outline-none bg-white shadow-2xs"
                                    title="Bagikan Profil ke Media Sosial"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                </button>

                                <div
                                    x-show="openShare"
                                    @click.outside="openShare = false"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                    class="absolute right-0 md:left-0 md:right-auto mt-2 w-60 bg-white rounded-2xl shadow-xl border border-stone-200/80 p-2 z-50 font-sans"
                                    style="display: none;"
                                >
                                    <div class="px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-stone-400 border-b border-stone-100">
                                        Bagikan Profil Ke
                                    </div>

                                    <div class="space-y-1 mt-1 text-xs font-semibold text-stone-700">

                                        <a
                                            href="https://api.whatsapp.com/send?text={{ urlencode('Lihat profil dan karya tulis ' . $user->name . ' di SMAN 1 Malingping: ' . url()->current()) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition-colors"
                                        >
                                            <span class="w-6 h-6 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                            </span>
                                            <span>WhatsApp</span>
                                        </a>

                                        <a
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-colors"
                                        >
                                            <span class="w-6 h-6 rounded-lg bg-blue-500/10 text-blue-600 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                            </span>
                                            <span>Facebook</span>
                                        </a>

                                        <a
                                            href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode('Lihat profil dan karya tulis ' . $user->name . ' di SMAN 1 Malingping') }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-stone-100 hover:text-stone-900 transition-colors"
                                        >
                                            <span class="w-6 h-6 rounded-lg bg-stone-900/10 text-stone-900 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                            </span>
                                            <span>X (Twitter)</span>
                                        </a>

                                        <a
                                            href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode('Lihat profil dan karya tulis ' . $user->name . ' di SMAN 1 Malingping') }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-sky-50 hover:text-sky-700 transition-colors"
                                        >
                                            <span class="w-6 h-6 rounded-lg bg-sky-500/10 text-sky-500 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.161c-.18.716-.962 4.084-1.362 5.75-.17.706-.433.942-.686.965-.55.05-1.07-.365-1.603-.715-.834-.546-1.305-.886-2.115-1.42-.936-.617-.329-.956.204-1.51.139-.145 2.562-2.35 2.609-2.55.006-.025.011-.12-.048-.172-.059-.052-.146-.034-.209-.02-.09.02-1.523.968-4.3 2.842-.406.279-.774.415-1.102.408-.363-.008-1.06-.205-1.579-.374-.637-.207-1.144-.317-1.1-.669.023-.183.275-.371.755-.563 2.96-1.29 4.935-2.14 5.925-2.552 2.822-1.173 3.409-1.377 3.793-1.383.085-.001.273.02.395.12.102.084.13.199.144.281.014.082.028.267.016.412z"/></svg>
                                            </span>
                                            <span>Telegram</span>
                                        </a>

                                        <a
                                            href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-blue-50 hover:text-blue-800 transition-colors"
                                        >
                                            <span class="w-6 h-6 rounded-lg bg-blue-700/10 text-blue-700 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                            </span>
                                            <span>LinkedIn</span>
                                        </a>

                                        <hr class="border-stone-100 my-1">

                                        <button
                                            type="button"
                                            @click="copyPublicProfileLink(); openShare = false;"
                                            class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-forest/10 hover:text-forest transition-colors text-left"
                                        >
                                            <span class="w-6 h-6 rounded-lg bg-stone-100 text-stone-600 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </span>
                                            <span>Salin Tautan</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="font-sans text-stone-600 text-sm md:text-base leading-relaxed max-w-2xl mt-4">
                        {{ $user->bio ?: 'Civitas akademika yang aktif berkarya dan menyumbangkan buah pikiran untuk kemajuan literasi SMAN 1 Malingping.' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 md:gap-8 mt-8 px-4 md:px-8">
                <div class="text-center md:text-left">
                    <p class="font-serif text-2xl text-stone-900">{{ $articles->total() }}</p>
                    <p class="font-sans text-xs text-stone-500 uppercase tracking-widest font-semibold mt-1">Artikel</p>
                </div>
                <div class="w-px h-8 bg-stone-200 hidden sm:block"></div>
                <div class="text-center md:text-left">
                    <p class="font-serif text-2xl text-stone-900">
                        {{ $totalViews >= 1000 ? round($totalViews / 1000, 1) . 'k' : $totalViews }}
                    </p>
                    <p class="font-sans text-xs text-stone-500 uppercase tracking-widest font-semibold mt-1">Dilihat</p>
                </div>
                <div class="w-px h-8 bg-stone-200 hidden sm:block"></div>
                <div class="text-center md:text-left">
                    <p class="font-serif text-2xl text-stone-900">
                        {{ $totalLikes >= 1000 ? round($totalLikes / 1000, 1) . 'k' : $totalLikes }}
                    </p>
                    <p class="font-sans text-xs text-stone-500 uppercase tracking-widest font-semibold mt-1">Apresiasi</p>
                </div>
                <div class="w-px h-8 bg-stone-200 hidden sm:block"></div>
                <div class="text-center md:text-left">
                    <p id="stat-followers-count" class="font-serif text-2xl text-stone-900">
                        {{ $followersCount >= 1000 ? round($followersCount / 1000, 1) . 'k' : $followersCount }}
                    </p>
                    <p class="font-sans text-xs text-stone-500 uppercase tracking-widest font-semibold mt-1">Pengikut</p>
                </div>
            </div>
        </div>

        <div class="w-full max-w-[1000px] mx-auto px-6">
            <h2 class="font-serif text-2xl md:text-3xl text-stone-900 mb-8 border-b border-stone-200/60 pb-4">
                Karya Tulis {{ explode(' ', $user->name)[0] }}
            </h2>

            <div class="flex flex-col gap-10">
                @forelse($articles as $article)

                    <article class="article-card group border-b border-stone-200 pb-10 flex flex-col sm:flex-row gap-6 sm:items-stretch">

                        <div class="flex-1 flex flex-col order-2 sm:order-1">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="bg-terracotta/10 text-terracotta font-sans text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-sm">
                                    {{ $article->category->name ?? ($article->type === 'jurnal' ? 'Jurnal Sekolah' : 'Suara Warga') }}
                                </span>
                                <span class="font-sans text-xs text-stone-500">
                                    {{ $article->formatted_date }}
                                </span>
                            </div>

                            <a href="{{ $article->url }}" class="block">
                                <h3 class="font-serif text-xl md:text-2xl text-stone-900 mb-3 leading-snug transition-colors group-hover:text-forest">
                                    {{ $article->title }}
                                </h3>
                            </a>

                            <p class="font-sans text-stone-600 text-sm leading-relaxed mb-5 line-clamp-2 md:line-clamp-3">
                                {{ $article->excerpt }}
                            </p>

                            <div class="mt-auto flex items-center justify-between w-full pt-4 border-t border-stone-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-stone-200 overflow-hidden flex-shrink-0">
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <span class="font-sans font-bold text-sm text-stone-900">{{ $user->name }}</span>
                                </div>

                                <div class="flex items-center gap-3 sm:gap-4 font-sans text-xs text-stone-500">

                                    <span class="flex items-center gap-1.5" title="Dilihat {{ $article->views_count ?? 0 }} kali">
                                        <svg class="w-4 h-4 text-stone-400 group-hover:text-forest transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        {{ $article->views_count ?? 0 }}
                                    </span>

                                    <span class="flex items-center gap-1.5" title="Apresiasi">
                                        <svg class="w-4 h-4 text-stone-400 group-hover:text-terracotta transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        {{ $article->likes_count ?? 0 }}
                                    </span>

                                    <span class="flex items-center gap-1.5" title="Komentar">
                                        <svg class="w-4 h-4 text-stone-400 group-hover:text-forest transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        {{ $article->comments_count ?? (method_exists($article, 'comments') ? $article->comments()->count() : 0) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($article->featured_image)
                            <a href="{{ $article->url }}" class="w-full sm:w-[35%] relative rounded-xl overflow-hidden flex-shrink-0 order-1 sm:order-2 aspect-[3/1] sm:aspect-auto">
                                <img
                                    src="{{ $article->featured_image_url }}"
                                    alt="{{ $article->title }}"
                                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                    loading="lazy"
                                >
                            </a>
                        @endif
                    </article>
                @empty
                    <div class="text-center py-16 bg-white rounded-3xl border border-stone-200/60 p-8 shadow-xs">
                        <svg class="w-12 h-12 text-stone-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
                        <h4 class="font-serif text-lg text-stone-800 mb-1">Belum Ada Karya Tulis</h4>
                        <p class="font-sans text-stone-500 text-sm">Penulis ini belum memiliki karya tulis yang terpublikasi.</p>
                    </div>
                @endforelse
            </div>

            @if($articles->hasPages())
                <div class="flex justify-center mt-12 mb-8">
                    {{ $articles->links() }}
                </div>
            @endif

        </div>
    </main>

    @push('scripts')
    <script>
        function copyPublicProfileLink() {
            if (typeof copyCurrentUrl === 'function') {
                copyCurrentUrl('Tautan profil berhasil disalin!');
            } else if (typeof showToast === 'function') {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showToast('Tautan profil berhasil disalin!', 'success');
                });
            }
        }

        async function toggleFollowAuthor(btn) {
            const username = btn.getAttribute('data-username');
            if (!username) return;

            btn.disabled = true;
            try {
                const response = await fetch(`/warga/${username}/follow`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();
                if (data.success) {
                    const isFollowed = data.following;
                    btn.setAttribute('data-followed', isFollowed ? 'true' : 'false');

                    const textEl = document.getElementById('btn-follow-text');
                    const iconEl = document.getElementById('btn-follow-icon');
                    const countEl = document.getElementById('stat-followers-count');

                    if (isFollowed) {
                        btn.className = 'px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 shadow-xs flex items-center gap-2 bg-stone-100 text-stone-700 hover:bg-stone-200 border border-stone-200';
                        if (textEl) textEl.innerText = 'Mengikuti';
                        if (iconEl) {
                            iconEl.classList.remove('text-white');
                            iconEl.classList.add('text-forest');
                            iconEl.setAttribute('fill', 'currentColor');
                        }
                    } else {
                        btn.className = 'px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 shadow-xs flex items-center gap-2 bg-forest text-white hover:bg-stone-900';
                        if (textEl) textEl.innerText = 'Ikuti';
                        if (iconEl) {
                            iconEl.classList.remove('text-forest');
                            iconEl.classList.add('text-white');
                            iconEl.setAttribute('fill', 'none');
                        }
                    }

                    if (countEl && typeof data.followers_formatted !== 'undefined') {
                        countEl.innerText = data.followers_formatted;
                    }

                    if (typeof showToast === 'function') {
                        showToast(data.message, isFollowed ? 'success' : 'info');
                    }
                } else {
                    if (typeof showToast === 'function') {
                        showToast(data.message || 'Gagal mengubah status ikuti.', 'error');
                    }
                }
            } catch (err) {
                if (typeof showToast === 'function') {
                    showToast('Terjadi kesalahan koneksi jaringan.', 'error');
                }
            } finally {
                btn.disabled = false;
            }
        }
    </script>
    @endpush

</x-layouts.app>
