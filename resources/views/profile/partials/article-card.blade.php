@php
    $author = $article->user ?? $user;
@endphp

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
                    <img src="{{ $author->avatar_url }}" alt="{{ $author->name }}" class="w-full h-full object-cover">
                </div>
                <span class="font-sans font-bold text-sm text-stone-900">{{ $author->name }}</span>
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
