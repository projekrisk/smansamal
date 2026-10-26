@props(['article', 'layout' => 'vertical'])

@php
    if (is_string($article) || is_numeric($article)) {
        $article = \App\Models\Article::with(['category', 'user'])->where('slug', $article)->orWhere('id', $article)->first();
    }
@endphp

@if($article && is_object($article) && isset($article->slug) && ($article->isPublished() || auth()->user()?->isAdmin()))
@if($layout === 'vertical')

    <div class="bg-white p-6 md:p-8 rounded-2xl md:rounded-[2rem] shadow-sm border border-stone-200 group hover:border-forest transition-colors flex flex-col justify-between h-full">
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="{{ $article->user->role_badge['class'] ?? 'bg-forest/10 text-forest' }} font-sans text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full">
                    {{ $article->category->name ?? ($article->user->role_badge['label'] ?? 'Warga') }}
                </span>
            </div>
            <a href="{{ $article->url }}" class="block">
                <h3 class="font-serif text-xl md:text-2xl text-stone-900 group-hover:text-forest transition-colors cursor-pointer leading-snug">
                    {{ $article->title }}
                </h3>
            </a>
            @if($article->tags && $article->tags->isNotEmpty())
                <div class="flex flex-wrap gap-1.5 mt-3">
                    @foreach($article->tags->take(3) as $t)
                        <a href="{{ route('suara-warga.index', ['tag' => $t->slug]) }}" class="inline-flex items-center text-[10px] font-mono font-medium text-forest bg-forest/5 hover:bg-forest hover:text-white px-2 py-0.5 rounded transition-colors" onclick="event.stopPropagation()">
                            #{{ $t->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="mt-auto">
            <a href="{{ route('warga.profile', $article->user->username ?? $article->user_id) }}" class="flex items-center gap-4 border-t border-stone-100 pt-4 mb-4 group/author">
                <div class="w-10 h-10 rounded-full bg-stone-200 overflow-hidden flex-shrink-0">
                    <img src="{{ $article->user->avatar_url ?? asset('images/avatar-default.svg') }}" alt="{{ $article->user->name ?? 'Penulis' }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                </div>
                <div>
                    <p class="font-sans font-bold text-sm text-stone-900 group-hover/author:text-forest transition-colors">{{ $article->user->name ?? 'Anonim' }}</p>
                    <p class="font-sans text-xs text-stone-500">{{ $article->user->role_detail ?? 'Warga Sekolah' }}</p>
                </div>
            </a>
            <div class="flex items-center justify-between font-sans text-xs text-stone-500 pt-3 border-t border-stone-100">
                <span>{{ $article->formatted_date }}</span>
                <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1.5" title="Dilihat {{ $article->views_count ?? 0 }} kali"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> {{ $article->views_count ?? 0 }}</span>
                    <span class="flex items-center gap-1.5" title="Apresiasi"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> {{ $article->likes_count ?? 0 }}</span>
                    <span class="flex items-center gap-1.5" title="Komentar"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{ $article->comments_count ?? (method_exists($article, 'comments') ? $article->comments()->count() : 0) }}</span>
                </div>
            </div>
        </div>
    </div>
@else

    <article class="article-card group border-b border-stone-200 pb-10 flex flex-col sm:flex-row gap-6 sm:items-stretch cursor-pointer">

        <div class="flex-1 flex flex-col order-2 sm:order-1">
            <div class="flex items-center gap-3 mb-3">
                <span class="{{ $article->user->role_badge['class'] ?? 'bg-terracotta/10 text-terracotta' }} font-sans text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-sm">
                    {{ $article->category->name ?? ($article->user->role_badge['label'] ?? 'Warga') }}
                </span>
                <span class="font-sans text-xs text-stone-500">{{ $article->formatted_date }}</span>
            </div>
            <a href="{{ $article->url }}">
                <h3 class="font-serif text-xl md:text-2xl text-stone-900 mb-3 leading-snug transition-colors group-hover:text-forest">
                    {{ $article->title }}
                </h3>
            </a>
            <p class="font-sans text-stone-600 text-sm leading-relaxed mb-4 line-clamp-2 md:line-clamp-3">
                {{ $article->excerpt }}
            </p>
            @if($article->tags && $article->tags->isNotEmpty())
                <div class="flex flex-wrap gap-1.5 mb-4">
                    @foreach($article->tags as $t)
                        <a href="{{ route('suara-warga.index', ['tag' => $t->slug]) }}" class="inline-flex items-center text-[11px] font-mono font-medium text-forest bg-forest/5 hover:bg-forest hover:text-white px-2 py-0.5 rounded transition-colors" onclick="event.stopPropagation()">
                            #{{ $t->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="mt-auto flex items-center justify-between w-full pt-4 border-t border-stone-100">
                <a href="{{ route('warga.profile', $article->user->username ?? $article->user_id) }}" class="flex items-center gap-3 group/author">
                    <div class="w-8 h-8 rounded-full bg-stone-200 overflow-hidden flex-shrink-0">
                        <img src="{{ $article->user->avatar_url ?? asset('images/avatar-default.svg') }}" alt="{{ $article->user->name ?? 'Penulis' }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <div>
                        <span class="font-sans font-bold text-sm text-stone-900 group-hover/author:text-forest transition-colors">{{ $article->user->name ?? 'Anonim' }}</span>
                        <span class="text-xs text-stone-400 block sm:inline sm:ml-1">&bull; {{ $article->user->role_detail ?? 'Warga Sekolah' }}</span>
                    </div>
                </a>
                <div class="flex items-center gap-3 sm:gap-4 font-sans text-xs text-stone-500">
                    <span class="flex items-center gap-1.5" title="Dilihat {{ $article->views_count ?? 0 }} kali"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> {{ $article->views_count ?? 0 }}</span>
                    <span class="flex items-center gap-1.5" title="Apresiasi"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> {{ $article->likes_count ?? 0 }}</span>
                    <span class="flex items-center gap-1.5" title="Komentar"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{ $article->comments_count ?? (method_exists($article, 'comments') ? $article->comments()->count() : 0) }}</span>
                </div>
            </div>
        </div>

        @if($article->featured_image)

            <a href="{{ $article->url }}" class="w-full sm:w-[35%] relative rounded-xl overflow-hidden flex-shrink-0 order-1 sm:order-2 aspect-[3/1] sm:aspect-auto">
                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" decoding="async">
            </a>
        @endif
    </article>
@endif
@endif
